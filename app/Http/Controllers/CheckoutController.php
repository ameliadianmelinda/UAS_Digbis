<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    private function reserveTicket(Event $event): Transaction
    {
        return DB::transaction(function () use ($event) {
            $freshEvent = Event::where('id', $event->id)->lockForUpdate()->first();

            if (!$freshEvent || $freshEvent->availableTicketsCount() <= 0) {
                throw new \Exception('Mohon maaf, tiket untuk acara ini sudah habis.');
            }

            return Transaction::create([
                'order_id' => 'TRX-' . time() . '-' . Str::random(5),
                'event_id' => $freshEvent->id,
                'customer_name' => Auth::user()?->name ?? '',
                'customer_email' => Auth::user()?->email ?? '',
                'customer_phone' => '',
                'total_price' => $freshEvent->price > 0 ? $freshEvent->price + 5000 : 0,
                'status' => Transaction::STATUS_PENDING,
            ]);
        });
    }

    public function create(Event $event)
    {
        $user = Auth::user();
        if ($user instanceof User && $user->isSuspended()) {
            return redirect()->route('login')->with('error', 'Akun Anda telah dinonaktifkan oleh Super Admin. Silakan hubungi administrator.');
        }

        $categories = \App\Models\Category::all();
        $sessionKey = 'checkout.pending.' . $event->id;
        $pendingOrderId = session($sessionKey);
        $transaction = null;

        if ($pendingOrderId) {
            $transaction = Transaction::where('order_id', $pendingOrderId)
                ->where('event_id', $event->id)
                ->where('status', Transaction::STATUS_PENDING)
                ->where('created_at', '>', now()->subMinutes(Transaction::PENDING_EXPIRY_MINUTES))
                ->first();
        }

        // If user opens the checkout page and doesn't yet have a pending reservation,
        // create one immediately so the stock is reserved and other users see updated availability.
        if (!$transaction) {
            try {
                $transaction = $this->reserveTicket($event);
                session([$sessionKey => $transaction->order_id]);
            } catch (\Exception $e) {
                return redirect()->route('events.show', $event)->with('error', $e->getMessage());
            }
        }

        return view('checkout.create', compact('event', 'categories', 'transaction'));
    }

    public function store(Request $request, Event $event)
    {
        $user = Auth::user();
        if ($user instanceof User && $user->isSuspended()) {
            return redirect()->route('login')->with('error', 'Akun Anda telah dinonaktifkan oleh Super Admin. Silakan hubungi administrator.');
        }

        if (!Auth::check()) {
            return redirect()->route('auth.google.checkout', $event)->with('error', 'Silakan login dengan Google terlebih dahulu untuk melanjutkan checkout.');
        }

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'reservation_order_id' => 'nullable|string',
        ]);

        $customerName = Auth::user()?->name ?? $request->customer_name;
        $customerEmail = Auth::user()?->email ?? $request->customer_email;
        $customerPhone = $request->customer_phone;
        $reservationOrderId = $request->input('reservation_order_id') ?: session('checkout.pending.' . $event->id);
        $transaction = null;

        if ($reservationOrderId) {
            $transaction = Transaction::where('order_id', $reservationOrderId)
                ->where('event_id', $event->id)
                ->where('status', Transaction::STATUS_PENDING)
                ->first();
        }

        if (!$transaction) {
            try {
                $transaction = $this->reserveTicket($event);
                session(['checkout.pending.' . $event->id => $transaction->order_id]);
            } catch (\Exception $e) {
                return back()->with('error', $e->getMessage());
            }
        }

        $totalPrice = $event->price > 0 ? $event->price + 5000 : 0;
        $orderId = $transaction->order_id;

        $transaction->update([
            'customer_name' => $customerName,
            'customer_email' => $customerEmail,
            'customer_phone' => $customerPhone,
            'total_price' => $totalPrice,
        ]);

        if ($event->price === 0) {
            if ($transaction->status === Transaction::STATUS_PENDING) {
                $transaction->update(['status' => Transaction::STATUS_SUCCESS]);
                try {
                    \Illuminate\Support\Facades\Mail::to($transaction->customer_email)->send(new \App\Mail\EventTicketMail($transaction));
                } catch (\Exception $e) {
                    Log::error('Gagal mengirim email E-Ticket untuk event gratis: ' . $e->getMessage());
                }
            }

            return redirect()->route('checkout.success', $transaction->order_id);
        }

        try {
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production');
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $totalPrice,
                ],
                'customer_details' => [
                    'first_name' => $customerName,
                    'email' => $customerEmail,
                    'phone' => $customerPhone,
                ],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $transaction->update(['snap_token' => $snapToken]);

            return redirect()->route('checkout.payment', $transaction->order_id);
        } catch (\Exception $e) {
            // Jika Midtrans gagal (500 dll), release reservation agar stok kembali
            try {
                $transaction->releaseReservation();
                $transaction->save();
            } catch (\Throwable $ex) {
                // log but don't block the original error
                Log::error('Failed to release reservation after Midtrans error: ' . $ex->getMessage());
            }

            // clear pending session key
            try {
                session()->forget('checkout.pending.' . $event->id);
            } catch (\Throwable $ex) {
            }

            Log::error('Midtrans Snap error: ' . $e->getMessage());

            return back()->with('error', 'Gagal memproses pembayaran jaringan: ' . $e->getMessage());
        }
    }

        public function payment(string $orderId)
    {
        // Mengambil daftar kategori untuk keperluan menu footer
        $categories = \App\Models\Category::all();

        $transaction = Transaction::with('event')->whereOrderId($orderId)->firstOrFail();

        if ($transaction->total_price === 0) {
            return redirect()->route('checkout.success', $transaction->order_id);
        }

        return view('checkout.payment', compact('transaction','categories'));
    }

        public function status(string $orderId)
        {
            $transaction = Transaction::with('event')->where('order_id', $orderId)->first();

            if (!$transaction) {
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            $expiryTime = now()->subMinutes(Transaction::PENDING_EXPIRY_MINUTES);
            $isExpired = false;

            if ($transaction->status === Transaction::STATUS_PENDING && $transaction->created_at < $expiryTime) {
                // Mark as expired immediately so pollers and other users see correct state
                $transaction->releaseReservation();
                $transaction->save();
                $isExpired = true;
                // refresh status value
                $transaction->refresh();
            }

            return response()->json([
                'status' => $transaction->status,
                'is_expired' => $isExpired,
                'order_id' => $transaction->order_id,
            ]);
        }

    public function success($order_id)
    {
        // Mengambil daftar kategori untuk keperluan menu footer
        $categories = \App\Models\Category::all();

        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();

        // Konfigurasi Midtrans untuk mengecek status transaksi langsung ke API
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $paymentState = 'success';

        if ($transaction->total_price === 0) {
            if ($transaction->status === Transaction::STATUS_PENDING) {
                $transaction->update(['status' => Transaction::STATUS_SUCCESS]);
            }
            return view('checkout.success', compact('transaction', 'categories', 'paymentState'));
        }

        try {
            // Mengecek status pesanan secara mandiri (Bypass)
            $status = \Midtrans\Transaction::status($order_id);

            if ($status) {
                // Mengambil nilai status transaksi
                $trx_status = is_array($status) ? ($status['transaction_status'] ?? '') : ($status->transaction_status ?? '');
                $trx_status = strtolower($trx_status);

                // Jika API Midtrans mengonfirmasi bahwa transaksi telah berhasil (settlement / capture)
                if (in_array($trx_status, ['settlement', 'capture'])) {
                    $expiryTime = now()->subMinutes(Transaction::PENDING_EXPIRY_MINUTES);

                    if ($transaction->status === Transaction::STATUS_PENDING && $transaction->created_at < $expiryTime) {
                        $transaction->releaseReservation();
                        $transaction->save();

                        return redirect()->route('events.show', $transaction->event)->with('error', 'Reservasi tiket Anda telah kedaluwarsa. Tiket telah dirilis kembali. Silakan buat reservasi baru.');
                    }

                    if ($transaction->status === Transaction::STATUS_PENDING) {
                        $transaction->update(['status' => Transaction::STATUS_SUCCESS]);

                        try {
                            \Illuminate\Support\Facades\Mail::to($transaction->customer_email)->send(new \App\Mail\EventTicketMail($transaction));
                        } catch (\Exception $e) {
                            Log::error('Gagal mengirim email E-Ticket secara manual (Bypass): ' . $e->getMessage());
                        }
                    }
                } elseif (in_array($trx_status, ['pending', 'challenge'])) {
                    $paymentState = 'pending';
                } else {
                    if ($transaction->status === Transaction::STATUS_PENDING) {
                        return redirect()->route('events.show', $transaction->event)->with('error', 'Pembayaran belum selesai. Reservasi akan kadaluarsa dalam beberapa menit jika tidak diselesaikan.');
                    }

                    if ($transaction->status === Transaction::STATUS_EXPIRED) {
                        return redirect()->route('events.show', $transaction->event)->with('error', 'Reservasi tiket Anda telah kedaluwarsa. Silakan lakukan pembelian ulang.');
                    }

                    if ($transaction->status === Transaction::STATUS_FAILED) {
                        return redirect()->route('events.show', $transaction->event)->with('error', 'Pembayaran gagal. Silakan coba lagi.');
                    }
                }
            }
        } catch (\Exception $e) {
            // Jika terjadi error dari API Midtrans (transaksi tidak valid), kembalikan ke beranda
            return redirect()->route('home')->with('error', 'Transaksi tidak ditemukan atau gagal diproses oleh sistem pembayaran.');
        }

        return view('checkout.success', compact('transaction', 'categories', 'paymentState'));
    }


}
