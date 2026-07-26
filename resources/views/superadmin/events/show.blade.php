@extends('layouts.superadmin')
@section('title', 'Detail Event')
@section('page_title', 'Detail Event')
@section('page_subtitle', 'Informasi event dan performa penjualannya.')
@section('content')
@php
    $posterUrl = 'https://placehold.co/640x360?text=No+Banner&bg=F8FAFC&fg=94A3B8';
    if ($event->poster_path) {
        if (file_exists(public_path($event->poster_path))) {
            $posterUrl = asset($event->poster_path);
        } elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists($event->poster_path)) {
            $posterUrl = asset('storage/' . ltrim($event->poster_path, '/'));
        }
    }
@endphp
<div class="w-full bg-white rounded-3xl border border-slate-100 shadow-sm p-6 lg:p-8">
    <div class="flex flex-col lg:flex-row lg:items-center gap-6 mb-6">
        <div class="w-full lg:w-80 rounded-3xl overflow-hidden border border-slate-200 bg-slate-100">
            <img src="{{ $posterUrl }}" alt="Banner {{ $event->title }}" class="w-full h-64 object-cover">
        </div>
        <div class="min-w-0 flex-1">
            <h2 class="text-3xl font-black text-slate-900">{{ $event->title }}</h2>
            <p class="mt-3 text-sm text-slate-500">{{ $event->partner->name ?? 'Tenant belum ditentukan' }} · {{ $event->category->name ?? '-' }}</p>
            <div class="mt-4 flex flex-wrap items-center gap-2">
                <span class="inline-flex rounded-full bg-indigo-100 px-3 py-1 text-xs font-bold uppercase text-indigo-700">{{ ($event->status ?? 'active') === 'inactive' ? 'Tidak Aktif' : 'Aktif' }}</span>
                <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-bold uppercase text-slate-700">{{ $event->location ?? '-' }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div class="p-5 bg-slate-50 rounded-2xl">
            <p class="text-xs uppercase tracking-wide font-semibold text-slate-400">Lokasi</p>
            <p class="mt-2 font-semibold text-slate-900">{{ $event->location ?? '-' }}</p>
        </div>
        <div class="p-5 bg-slate-50 rounded-2xl">
            <p class="text-xs uppercase tracking-wide font-semibold text-slate-400">Tanggal & Waktu</p>
            <p class="mt-2 font-semibold text-slate-900">{{ $event->date?->format('d M Y, H:i') ?? '-' }}</p>
        </div>
        <div class="p-5 bg-slate-50 rounded-2xl">
            <p class="text-xs uppercase tracking-wide font-semibold text-slate-400">Harga Tiket</p>
            <p class="mt-2 font-semibold text-slate-900">Rp {{ number_format($event->price, 0, ',', '.') }}</p>
        </div>
        <div class="p-5 bg-slate-50 rounded-2xl">
            <p class="text-xs uppercase tracking-wide font-semibold text-slate-400">Kuota Tersisa</p>
            <p class="mt-2 font-semibold text-slate-900">{{ number_format($event->stock, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="p-5 bg-slate-50 rounded-2xl mb-6">
        <p class="text-xs uppercase tracking-wide font-semibold text-slate-400">Deskripsi Event</p>
        <p class="mt-2 text-slate-900">{{ $event->description ?? '-' }}</p>
    </div>

    <div class="grid md:grid-cols-3 gap-4 mb-6">
        <div class="p-5 bg-slate-50 rounded-2xl">
            <p class="text-xs uppercase tracking-wide font-semibold text-slate-400">Tiket Terjual</p>
            <p class="mt-2 text-3xl font-black text-slate-900">{{ number_format($ticketsSold, 0, ',', '.') }}</p>
        </div>
        <div class="p-5 bg-slate-50 rounded-2xl">
            <p class="text-xs uppercase tracking-wide font-semibold text-slate-400">Pendapatan</p>
            <p class="mt-2 text-3xl font-black text-slate-900">Rp {{ number_format($revenue, 0, ',', '.') }}</p>
        </div>
        <div class="p-5 bg-slate-50 rounded-2xl">
            <p class="text-xs uppercase tracking-wide font-semibold text-slate-400">Status</p>
            <p class="mt-2 text-3xl font-black text-slate-900">{{ ucfirst($event->status ?? 'active') }}</p>
        </div>
    </div>

    <div class="flex flex-wrap gap-3">
        <a href="{{ route('superadmin.events.index') }}" class="px-5 py-3 rounded-2xl border border-slate-200 text-slate-700 font-bold hover:bg-slate-50">Kembali</a>
        @if(($event->status ?? 'active') !== 'inactive')
            <form method="POST" action="{{ route('superadmin.events.disable', $event) }}" onsubmit="return confirm('Nonaktifkan event ini?')" class="inline-block">
                @csrf
                <button type="submit" class="px-5 py-3 rounded-2xl bg-amber-500 text-white font-bold hover:bg-amber-600">Nonaktifkan</button>
            </form>
        @endif
        <form method="POST" action="{{ route('superadmin.events.destroy', $event) }}" onsubmit="return confirm('Hapus event ini?')" class="inline-block">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-5 py-3 rounded-2xl bg-red-600 text-white font-bold hover:bg-red-700">Hapus</button>
        </form>
    </div>
</div>
@endsection
