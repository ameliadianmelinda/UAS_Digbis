@extends('layouts.partner')

@section('title', 'Detail Transaksi Partner')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-black tracking-tight text-slate-900 sm:text-4xl">Detail Transaksi</h1>
                <p class="mt-2 text-sm text-slate-500">Informasi lengkap transaksi partner dan status pembayaran.</p>
            </div>

            <a href="{{ route('partner.transactions.index') }}" class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="grid gap-6 sm:grid-cols-2">
                <div class="space-y-2">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Order ID</p>
                    <p class="text-lg font-semibold text-slate-900">{{ $transaction->order_id }}</p>
                </div>
                <div class="space-y-2">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Status</p>
                    <p class="inline-flex rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-700">{{ ucfirst($transaction->status) }}</p>
                </div>
                <div class="space-y-2">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Nama Event</p>
                    <p class="font-semibold text-slate-900">{{ $transaction->event?->title ?? '-' }}</p>
                </div>
                <div class="space-y-2">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Tanggal Transaksi</p>
                    <p class="font-semibold text-slate-900">{{ $transaction->created_at?->translatedFormat('d M Y, H:i') ?? '-' }}</p>
                </div>
            </div>

            <div class="mt-6 grid gap-6 md:grid-cols-2">
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Pembeli</p>
                    <p class="mt-2 text-lg font-semibold text-slate-900">{{ $transaction->customer_name ?? '-' }}</p>
                    <p class="text-sm text-slate-600">{{ $transaction->customer_email ?? '-' }}</p>
                    <p class="text-sm text-slate-600">{{ $transaction->customer_phone ?? '-' }}</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Pembayaran</p>
                    <p class="mt-2 text-lg font-semibold text-slate-900">Rp {{ number_format((float) $transaction->total_price, 0, ',', '.') }}</p>
                    <p class="text-sm text-slate-600">Snap Token: {{ $transaction->snap_token ?? '-' }}</p>
                </div>
            </div>

            <div class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-5">
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Detail Event</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">{{ $transaction->event?->title ?? '-' }}</p>
                <p class="text-sm text-slate-600">Partner: {{ $transaction->event?->partner?->name ?? '-' }}</p>
            </div>

        </div>
    </div>
@endsection
