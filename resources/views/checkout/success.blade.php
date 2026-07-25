@extends('layouts.app')
@section('title', 'Pembayaran Berhasil')
@section('content')
<main class="max-w-3xl mx-auto px-6 py-20 text-center">
    <div class="bg-white rounded-3xl border border-slate-200 p-12 shadow-sm inline-block w-full max-w-md">
        <div class="w-24 h-24 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h2 class="text-3xl font-black mb-4">Terima Kasih!</h2>
        <p class="text-slate-500 mb-8 leading-relaxed">
            Pembayaran untuk pesanan <strong>{{ $transaction->order_id }}</strong>
            @if(isset($paymentState) && $paymentState === 'pending')
                masih dalam proses. Silakan tunggu beberapa saat hingga pembayaran berhasil.
            @else
                sedang diproses atau telah berhasil.
            @endif
            E-Ticket akan dikirim ke email Anda (<strong>{{ $transaction->customer_email }}</strong>) setelah pembayaran terkonfirmasi lunas.
        </p>
        <div class="flex flex-col gap-4 items-center">
            @if(isset($paymentState) && $paymentState === 'pending')
                <a href="{{ route('events.show', $transaction->event) }}" class="inline-block px-8 py-4 bg-slate-500 text-white rounded-xl font-bold hover:bg-slate-600 transition">
                    Kembali ke Event
                </a>
            @endif
            <a href="{{ route('home') }}" class="inline-block px-8 py-4 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</main>
@endsection
