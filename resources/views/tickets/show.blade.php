@extends('layouts.app')

@section('title', 'Detail Riwayat Tiket')

@section('content')
<main class="max-w-4xl mx-auto px-6 py-14">
    <section class="bg-white rounded-4xl p-8 shadow-sm border border-slate-100">
        <div class="mb-8">
            <p class="text-sm font-black tracking-[0.2em] text-indigo-500 uppercase">Detail Pesanan</p>
            <h1 class="text-4xl font-black text-slate-900 mt-2">{{ $transaction->event?->title ?? 'Event' }}</h1>
            <p class="text-slate-500 mt-2">Informasi lengkap transaksi dan tiket yang telah kamu pesan.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-5">
            <div class="rounded-3xl bg-slate-50 p-5 border border-slate-100">
                <p class="text-xs font-black tracking-[0.2em] text-slate-400 uppercase">Order ID</p>
                <p class="mt-2 text-lg font-bold text-slate-900">{{ $transaction->order_id }}</p>
            </div>
            <div class="rounded-3xl bg-slate-50 p-5 border border-slate-100">
                <p class="text-xs font-black tracking-[0.2em] text-slate-400 uppercase">Status</p>
                <p class="mt-2 text-lg font-bold text-slate-900">{{ $transaction->status }}</p>
            </div>
            <div class="rounded-3xl bg-slate-50 p-5 border border-slate-100">
                <p class="text-xs font-black tracking-[0.2em] text-slate-400 uppercase">Nama Pembeli</p>
                <p class="mt-2 text-lg font-bold text-slate-900">{{ $transaction->customer_name }}</p>
            </div>
            <div class="rounded-3xl bg-slate-50 p-5 border border-slate-100">
                <p class="text-xs font-black tracking-[0.2em] text-slate-400 uppercase">Email Pembeli</p>
                <p class="mt-2 text-lg font-bold text-slate-900 break-all">{{ $transaction->customer_email }}</p>
            </div>
            <div class="rounded-3xl bg-slate-50 p-5 border border-slate-100">
                <p class="text-xs font-black tracking-[0.2em] text-slate-400 uppercase">Nomor HP</p>
                <p class="mt-2 text-lg font-bold text-slate-900">{{ $transaction->customer_phone }}</p>
            </div>
            <div class="rounded-3xl bg-slate-50 p-5 border border-slate-100">
                <p class="text-xs font-black tracking-[0.2em] text-slate-400 uppercase">Tanggal Event</p>
                <p class="mt-2 text-lg font-bold text-slate-900">{{ optional($transaction->event?->date)->translatedFormat('d F Y') ?? '-' }}</p>
            </div>
            <div class="rounded-3xl bg-slate-50 p-5 border border-slate-100 md:col-span-2">
                <p class="text-xs font-black tracking-[0.2em] text-slate-400 uppercase">Lokasi Event</p>
                <p class="mt-2 text-lg font-bold text-slate-900">{{ $transaction->event?->location ?? '-' }}</p>
            </div>
            <div class="rounded-3xl bg-indigo-50 p-5 border border-indigo-100 md:col-span-2">
                <p class="text-xs font-black tracking-[0.2em] text-indigo-500 uppercase">Total Bayar</p>
                <p class="mt-2 text-3xl font-black text-indigo-700">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="mt-8 rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-black text-slate-900">Beri Penilaian & Review</h2>
            <p class="text-sm text-slate-500 mt-2">Berikan rating setelah acara selesai untuk membantu penyelenggara meningkatkan pengalaman.</p>

            @php
                $canReview = $transaction->isSuccess() && $transaction->event?->date?->isPast() && !$transaction->review;
            @endphp

            @if($canReview)
                <form action="{{ route('tickets.review.store', $transaction) }}" method="POST" class="mt-6 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Rating</label>
                        <select name="rating" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 shadow-sm outline-none">
                            <option value="">Pilih rating</option>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }} bintang</option>
                            @endfor
                        </select>
                        @error('rating')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Komentar</label>
                        <textarea name="comment" rows="4" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 shadow-sm outline-none" placeholder="Tulis pengalaman Anda mengikuti acara...">{{ old('comment') }}</textarea>
                        @error('comment')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-bold text-white hover:bg-indigo-700 transition">
                        Kirim Review
                    </button>
                </form>
            @elseif($transaction->review)
                <div class="mt-6 rounded-2xl bg-emerald-50 border border-emerald-100 p-5 text-slate-700">
                    <p class="font-bold">Terima kasih! Review Anda sudah terkirim.</p>
                    <p class="mt-2">Rating: {{ $transaction->review->rating }} ⭐</p>
                    <p class="mt-2">{{ $transaction->review->comment }}</p>
                </div>
            @else
                <div class="mt-6 rounded-2xl bg-slate-50 border border-slate-200 p-5 text-slate-600">
                    <p class="font-bold">Review tersedia setelah acara selesai.</p>
                    <p class="mt-2">Silakan kembali setelah tanggal acara untuk memberikan penilaian.</p>
                </div>
            @endif
        </div>

        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('tickets.history') }}" class="inline-flex items-center justify-center px-5 py-3 rounded-2xl bg-slate-900 text-white font-bold hover:bg-slate-800 transition">
                Kembali ke Riwayat Tiket
            </a>
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-5 py-3 rounded-2xl border border-slate-200 text-slate-700 font-bold hover:bg-slate-50 transition">
                Cari Event Lain
            </a>
        </div>
    </section>
</main>
@endsection
