@extends('layouts.app')

@section('title', 'Riwayat Tiket')

@section('content')
<main class="max-w-6xl mx-auto px-6 py-14">
    <section class="bg-white rounded-4xl p-8 shadow-sm border border-slate-100">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <p class="text-sm font-black tracking-[0.2em] text-indigo-500 uppercase">Riwayat Tiket</p>
                <h1 class="text-4xl font-black text-slate-900 mt-2">Transaksi tiket kamu</h1>
                <p class="text-slate-500 mt-2">Semua pesanan yang terhubung dengan akun login saat ini.</p>
            </div>
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-5 py-3 rounded-2xl bg-indigo-600 text-white font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition">
                Cari Event
            </a>
        </div>

        <div class="space-y-4">
            @forelse($transactions as $transaction)
                <div class="rounded-3xl border border-slate-100 bg-slate-50 p-5">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div>
                            <p class="text-sm font-black tracking-[0.2em] text-indigo-500 uppercase">{{ $transaction->status }}</p>
                            <h2 class="text-xl font-black text-slate-900 mt-1">{{ $transaction->event?->title ?? 'Event' }}</h2>
                            <p class="text-sm text-slate-500 mt-1">Order ID: {{ $transaction->order_id }}</p>
                            <p class="text-sm text-slate-500 mt-1">Tanggal Event: {{ optional($transaction->event?->date)->translatedFormat('d F Y') ?? '-' }}</p>
                        </div>

                        <div class="flex flex-col md:flex-row items-start md:items-center gap-3">
                            <div class="text-left md:text-right">
                                <p class="text-sm text-slate-500">Total</p>
                                <p class="text-2xl font-black text-indigo-700">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                            </div>
                            <a href="{{ route('tickets.history.show', $transaction) }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-2xl bg-slate-900 text-white font-semibold hover:bg-slate-800 transition">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-3xl border border-dashed border-slate-200 bg-white p-8 text-center text-slate-500">
                    Belum ada riwayat tiket. Mulai pesan event untuk melihat transaksi di sini.
                </div>
            @endforelse
        </div>

        @if($transactions->hasPages())
            <div class="mt-8">
                {{ $transactions->links() }}
            </div>
        @endif
    </section>
</main>
@endsection
