@extends('layouts.app')

@section('content')

   <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-6 py-20 flex flex-col md:flex-row items-center gap-12">
        <div class="flex-1 space-y-8">
            <span
                class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">#1
                Event Platform</span>
            <h1 class="text-5xl md:text-7xl font-extrabold leading-tight">
                Temukan & Pesan <span class="text-indigo-600">Tiket Event</span> Impianmu.
            </h1>
            <p class="text-lg text-slate-500 max-w-lg leading-relaxed">
                Dari konser musik hingga workshop teknologi, semua ada di genggamanmu. Pesan aman & cepat dengan
                Midtrans.
            </p>
            <div class="flex gap-4">
                <a href="#events"
                    class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-lg shadow-xl shadow-indigo-200 hover:scale-105 transition-transform">
                    Mulai Jelajah
                </a>
                <a href="#"
                    class="px-8 py-4 border-2 border-slate-200 rounded-2xl font-bold text-lg hover:border-indigo-600 hover:text-indigo-600 transition">
                    Cara Pesan
                </a>
            </div>
        </div>
        <div class="flex-1 relative">
            <div
                class="absolute -top-10 -left-10 w-64 h-64 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob">
            </div>
            <div
                class="absolute -bottom-10 -right-10 w-64 h-64 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000">
            </div>
            <img src="{{ asset('assets/concert.png') }}" alt="Concert"
                class="rounded-4xl shadow-2xl relative z-10 w-full object-cover aspect-4/5 object-center">

            <div class="absolute -bottom-6 -left-6 glass p-6 rounded-2xl shadow-xl z-20 border border-white">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-bold uppercase">Terverifikasi</p>
                        <p class="font-bold">Pembayaran Aman via Midtrans</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Events Grid -->
    <section id="events" class="max-w-7xl mx-auto px-6 py-20 scroll-mt-28">


        <!-- Judul & Filter Kategori Sejajar -->
        <div id="kategori" class="flex flex-col md:flex-row items-center justify-between gap-4 mb-8 scroll-mt-28">
            <div class="text-center md:text-left">
                <h2 class="text-3xl font-extrabold mb-2">Event Terdekat</h2>
                <p class="text-slate-500 font-medium">Jangan sampai ketinggalan acara seru minggu ini!</p>
            </div>
            <!-- Blok Navigasi Filter Kategori -->
            <div class="flex gap-4">
                <a href="{{ route('home') }}#kategori" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded text-black transition">Semua Kategori</a>
                @foreach($categories as $cat)
                    <a href="{{ route('home') }}?category={{ $cat->id }}#kategori"
                       class="px-4 py-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 rounded shadow-sm transition">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Zona Menampilkan Grid List Event -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($events as $event)
                <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden">
                    <div class="relative overflow-hidden aspect-3/4">
                        <img src="{{ ($event->poster_path && Storage::disk('public')->exists($event->poster_path)) ? asset('storage/' . $event->poster_path) : 'https://placehold.co/200x600' }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div
                            class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold uppercase text-indigo-600">
                            {{ $event->category->name }}
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 group-hover:text-indigo-600 transition">{{ $event->title }}</h3>
                        <div class="flex items-center gap-2 text-slate-500 text-sm mb-4">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($event->date)->format('d-m-Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-4 border-t">
                            <span class="text-2xl font-black text-indigo-600">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                            <a href="{{ route('events.show', $event->id) }}" class="px-5 py-2 bg-indigo-50 text-indigo-600 rounded-xl font-bold hover:bg-indigo-600 hover:text-white transition">Lihat Detail</a>
                        </div>
                    </div>
                </div>
                @endforeach
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 pb-20">
        <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm">
            <div class="grid md:grid-cols-3 gap-6">
                <div>
                    <p class="text-sm font-black tracking-[0.2em] text-indigo-500 uppercase">Tentang Kami</p>
                    <h3 class="text-3xl font-black mt-2">Platform tiket untuk event kampus dan komunitas.</h3>
                </div>
                <div class="md:col-span-2 text-slate-600 leading-relaxed space-y-4">
                    <p>AmikomEventHub membantu pembeli menemukan event, pesan tiket dengan cepat, dan menerima tiket secara aman. Pembayaran didukung Midtrans sehingga proses transaksi lebih praktis.</p>
                    <p>Untuk penyelenggara event, tersedia jalur login partner dan dashboard pengelolaan event yang terpisah dari akun pembeli.</p>
                </div>
            </div>
        </div>
    </section>


@endsection
