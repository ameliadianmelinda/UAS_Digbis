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
        if ($transactionStatus == 'capture') {

            if ($fraudStatus == 'challenge') {
                $transaction->status = 'challenge';
            }
            else if ($fraudStatus == 'accept') {
                $transaction->status = 'success';
                $this->processSuccess($transaction);
            }

        }
        else if ($transactionStatus == 'settlement') {

            $transaction->status = 'success';
            $this->processSuccess($transaction);

        }
        else if (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {

            $transaction->status = 'failed';

        }
        else if ($transactionStatus == 'pending') {

            $transaction->status = 'pending';

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

        // Jika tiket masih ada dan terhubung dengan data event, kurangi jumlahnya sebanyak 1
        if ($event && $event->stock > 0) {
            $event->stock = $event->stock - 1;
            $event->save();

            // Mengirimkan email E-Ticket ke pelanggan
            try {
                \Illuminate\Support\Facades\Mail::to($transaction->customer_email)->send(new \App\Mail\EventTicketMail($transaction));
            } catch (\Exception $e) {
                Log::error('Gagal mengirim email E-Ticket: ' . $e->getMessage());
            }
        } else {
            Log::warning('Stock habis setelah pembayaran berhasil (Perlu proses refund opsional). Order: ' . $transaction->order_id);
        }
    }
}
