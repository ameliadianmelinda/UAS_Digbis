@extends('layouts.app')
@section('title', 'Dashboard Pembeli')
@section('content')

<main class="max-w-7xl mx-auto px-6 py-14">
    <div class="grid lg:grid-cols-[1.2fr_0.8fr] gap-8 items-start">
        <section class="bg-white rounded-4xl p-8 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <p class="text-sm font-bold tracking-[0.2em] text-indigo-500 uppercase">Dashboard Pembeli</p>
                    <h1 class="text-4xl font-black text-slate-900 mt-2">Halo, {{ $user->name }}</h1>
                    <p class="text-slate-500 mt-2">Kelola profil dan lihat riwayat tiket yang pernah kamu pesan.</p>
                </div>
                <div class="hidden md:flex items-center justify-center w-20 h-20 rounded-3xl bg-indigo-600 text-white text-3xl font-black shadow-lg shadow-indigo-100 overflow-hidden">
                    @if($user->avatar)
                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                    @else
                        {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                    @endif
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-4 mb-8">
                <div class="rounded-3xl bg-slate-50 p-5 border border-slate-100">
                    <p class="text-xs font-black tracking-[0.2em] text-slate-400 uppercase">Nama</p>
                    <p class="mt-2 text-lg font-bold text-slate-900">{{ $user->name }}</p>
                </div>
                <div class="rounded-3xl bg-slate-50 p-5 border border-slate-100">
                    <p class="text-xs font-black tracking-[0.2em] text-slate-400 uppercase">Email</p>
                    <p class="mt-2 text-lg font-bold text-slate-900 break-all">{{ $user->email }}</p>
                </div>
                <div class="rounded-3xl bg-slate-50 p-5 border border-slate-100">
                    <p class="text-xs font-black tracking-[0.2em] text-slate-400 uppercase">Akses</p>
                    <p class="mt-2 text-lg font-bold text-slate-900">Pembeli Tiket</p>
                </div>
            </div>

            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-2xl font-black text-slate-900">Riwayat Tiket</h2>
                    <p class="text-slate-500">Transaksi terakhir yang terhubung ke email kamu.</p>
                </div>
                <a href="{{ route('home') }}" class="px-5 py-3 rounded-2xl bg-indigo-600 text-white font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition">Cari Event</a>
            </div>

            <div class="space-y-4">
                @forelse($transactions as $transaction)
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 rounded-3xl border border-slate-100 bg-slate-50 p-5">
                        <div>
                            <p class="text-sm font-black tracking-[0.2em] text-indigo-500 uppercase">{{ $transaction->status }}</p>
                            <h3 class="text-xl font-bold text-slate-900 mt-1">{{ $transaction->event?->title ?? 'Event' }}</h3>
                            <p class="text-sm text-slate-500 mt-1">Order ID: {{ $transaction->order_id }}</p>
                        </div>
                        <div class="text-left md:text-right">
                            <p class="text-sm text-slate-500">Total</p>
                            <p class="text-2xl font-black text-indigo-700">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @empty
                    <div class="rounded-3xl border border-dashed border-slate-200 bg-white p-8 text-center text-slate-500">
                        Belum ada transaksi. Mulai pesan tiket dari halaman event.
                    </div>
                @endforelse
            </div>
        </section>

        <aside class="space-y-6">
            <div class="bg-white rounded-4xl p-7 shadow-sm border border-slate-100">
                <p class="text-sm font-black tracking-[0.2em] text-slate-400 uppercase">Profile</p>
                <div class="mt-5 flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-indigo-600 text-white flex items-center justify-center font-black text-2xl overflow-hidden">
                        @if($user->avatar)
                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900">{{ $user->name }}</h3>
                        <p class="text-sm text-slate-500">{{ $user->email }}</p>
                    </div>
                </div>

                <div class="mt-6 rounded-3xl bg-indigo-50 p-5 text-indigo-900">
                    <p class="text-sm font-bold">Akun aktif untuk pembeli tiket.</p>
                    <p class="text-sm mt-1">Gunakan profil ini untuk checkout cepat dan akses tiket.</p>
                </div>
            </div>

            <div class="bg-indigo-900 rounded-4xl p-7 text-white shadow-lg shadow-indigo-100">
                <p class="text-sm font-black tracking-[0.2em] text-indigo-200 uppercase">Quick Access</p>
                <h3 class="text-2xl font-black mt-4">Cari event baru dan pesan sekarang.</h3>
                <p class="text-indigo-100 mt-3">Semua tiket dan transaksi kamu akan mengikuti email Google yang digunakan saat login.</p>
                <a href="{{ route('home') }}" class="inline-flex mt-6 px-5 py-3 rounded-2xl bg-white text-indigo-900 font-black hover:bg-slate-100 transition">Jelajahi Event</a>
            </div>
        </aside>
    </div>
</main>

@endsection