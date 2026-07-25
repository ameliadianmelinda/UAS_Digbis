<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Log semua data callback dari Midtrans
        Log::info('MIDTRANS CALLBACK MASUK:', $request->all());

        $payload = $request->all();

        $orderId = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;

        // Cek apakah order ID ada
        if (!$orderId) {
            Log::error('Order ID kosong');

            return response()->json([
                'message' => 'Invalid payload'
            ], 400);
        }

        // Cari transaksi berdasarkan order_id
        $transaction = Transaction::with('event')
            ->where('order_id', $orderId)
            ->first();

        if (!$transaction) {
            Log::error('Transaksi tidak ditemukan: ' . $orderId);

            return response()->json([
                'message' => 'Transaction not found'
            ], 404);
        }

        // Hindari pemrosesan ganda
        if (
            $transaction->status === 'settlement' ||
            $transaction->status === 'success'
        ) {
            Log::info('Transaksi sudah diproses: ' . $orderId);

            return response()->json([
                'message' => 'Already processed'
            ], 200);
        }

        // Mapping status Midtrans
        if (in_array($transactionStatus, ['capture', 'settlement'])) {
            // Before marking success, ensure reservation hasn't expired
            $expiryTime = now()->subMinutes(\App\Models\Transaction::PENDING_EXPIRY_MINUTES);
            if ($transaction->status === Transaction::STATUS_PENDING && $transaction->created_at < $expiryTime) {
                // Reservation expired before payment confirmation
                $transaction->releaseReservation();
                $transaction->save();

                Log::info('Transaction expired before webhook success: ' . $orderId);

                return response()->json(['message' => 'Reservation expired'], 200);
            }

            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'challenge') {
                    $transaction->status = 'challenge';
                } else if ($fraudStatus == 'accept') {
                    $transaction->status = 'success';
                    $this->processSuccess($transaction);
                }
            } else {
                $transaction->status = 'success';
                $this->processSuccess($transaction);
            }

        } else if (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            if (strtolower($transaction->status) === Transaction::STATUS_PENDING) {
                $transaction->releaseReservation();
            } else {
                $transaction->status = Transaction::STATUS_FAILED;
            }
        }
        else if ($transactionStatus == 'pending') {
            $transaction->status = Transaction::STATUS_PENDING;
        }

        // Simpan perubahan
        $transaction->save();

        Log::info('Status transaksi berhasil diperbarui', [
            'order_id' => $orderId,
            'status' => $transaction->status
        ]);

        return response()->json([
            'message' => 'OK'
        ], 200);
    }

    private function processSuccess(Transaction $transaction)
    {
        $event = $transaction->event;
        // Do NOT decrement `stock` here. `stock` represents event capacity and
        // sold tickets are derived from transactions with status 'success'/'settlement'.
        // Only send the e-ticket email and log.
        if ($event) {
            try {
                \Illuminate\Support\Facades\Mail::to($transaction->customer_email)->send(new \App\Mail\EventTicketMail($transaction));
            } catch (\Exception $e) {
                Log::error('Gagal mengirim email E-Ticket: ' . $e->getMessage());
            }
        } else {
            Log::warning('Event not found for successful transaction. Order: ' . $transaction->order_id);
        }
    }
}
