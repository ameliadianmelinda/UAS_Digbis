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
    <section id="events" class="w-full py-20 scroll-mt-28 bg-slate-100 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 rounded-3xl">
            <!-- Judul & Filter Kategori Centered -->
            @php
                $selectedCategory = request()->query('category');
            @endphp
            <div id="kategori" class="flex flex-col items-center text-center gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-extrabold mb-2">Event Terdekat</h2>
                <p class="text-slate-500 font-medium">Jangan sampai ketinggalan acara seru minggu ini!</p>
            </div>
            <!-- Blok Navigasi Filter Kategori -->
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('home') }}#kategori" class="px-4 py-2 rounded-lg shadow-sm transition {{ $selectedCategory ? 'bg-gray-200 hover:bg-gray-300 text-black' : 'bg-indigo-600 text-white hover:bg-indigo-700' }}">
                    Semua Kategori
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('home') }}?category={{ $cat->id }}#kategori"
                       class="px-4 py-2 rounded-lg shadow-sm transition {{ $selectedCategory == $cat->id ? 'bg-indigo-600 text-white hover:bg-indigo-700' : 'bg-indigo-100 hover:bg-indigo-200 text-indigo-700' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Zona Menampilkan Grid List Event -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($events as $event)
                <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden h-full flex flex-col">
                    <div class="relative overflow-hidden h-56 sm:h-60">
                        @php
                            $eventImage = null;
                            if (!empty($event->poster_path) && file_exists(public_path($event->poster_path))) {
                                $eventImage = asset($event->poster_path);
                            }
                            $partnerLogo = $event->partner?->logo_url ?? null;
                        @endphp
                        <img src="{{ $eventImage ?? 'https://placehold.co/600x400?text=No+Image' }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @if($partnerLogo)
                            <img src="{{ $partnerLogo }}" alt="Partner logo" class="absolute top-3 right-3 h-10 w-10 rounded-full border-2 border-white object-cover shadow-sm">
                        @endif
                        @if($event->stock <= 0)
                            <div class="absolute top-3 left-3 rounded-full bg-rose-600 px-3 py-1 text-xs font-bold uppercase tracking-[0.25em] text-white shadow-lg">Sold Out</div>
                        @endif
                        <div class="absolute top-4 right-3 px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold uppercase text-indigo-600">
                            {{ $event->category->name }}
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col gap-4">
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <h3 class="text-xl font-bold group-hover:text-indigo-600 transition line-clamp-2">{{ $event->title }}</h3>
                                @php
                                    $capacity = max($event->stock ?? 0, 0);
                                    $isSoldOutCard = ($event->sold_tickets_count ?? 0) >= $capacity && $capacity > 0;
                                @endphp
                                @if($isSoldOutCard || $event->stock <= 0)
                                    <span class="inline-flex items-center rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-rose-700">
                                        SOLD OUT
                                    </span>
                                @endif
                            </div>
                            <div class="flex items-center gap-2 text-slate-500 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ \Carbon\Carbon::parse($event->date)->format('d-m-Y H:i') }}</span>
                            </div>
                        </div>
                        <div class="mt-auto flex items-center justify-between gap-4 pt-4 border-t">
                            <span class="text-2xl font-black text-indigo-600">
                                @if($event->price <= 0)
                                    Gratis
                                @else
                                    Rp {{ number_format($event->price, 0, ',', '.') }}
                                @endif
                            </span>
                            <a href="{{ route('events.show', $event->id) }}" class="inline-flex h-11 items-center justify-center px-5 rounded-xl bg-indigo-50 text-indigo-600 font-bold hover:bg-indigo-600 hover:text-white transition">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
        </div>
    </section>

    <!-- Partner & Sponsor Section -->
    <section class="pt-14 pb-24 bg-gradient-to-b from-slate-50 to-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 mb-14">
            <div class="text-center space-y-3">
                <h2 class="text-3xl md:text-xl font-extrabold">Partner & Sponsor</h2>
                <p class="text-slate-500">Didukung oleh perusahaan dan komunitas terpercaya</p>
            </div>
        </div>

        <!-- Partner Grid Container -->
        <div class="max-w-7xl mx-auto px-6">
            @php
                $sponsors = [
                    ['logo' => 'logo_amikom.png', 'name' => 'Universitas Amikom Yogyakarta'],
                    ['logo' => 'logo-si.png', 'name' => 'Prodi S1 Sistem Informasi Amikom'],
                    ['logo' => 'logo_ilabsains.png', 'name' => 'iLabSains'],
                    ['logo' => 'logo_arthanta.png', 'name' => 'Arthanta'],
                    ['logo' => 'logo_lentera.png', 'name' => 'Lentera'],
                ];
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @foreach($sponsors as $sponsor)
                    <div class="bg-white rounded-2xl p-4 shadow-md hover:shadow-lg transition-shadow duration-300 flex flex-col items-center">
                        <div class="h-20 flex items-center justify-center mb-2">
                            <img src="{{ asset('assets/' . $sponsor['logo']) }}" alt="{{ $sponsor['name'] }}" class="max-h-20 max-w-full object-contain">
                        </div>
                        <p class="text-center font-semibold text-slate-700 text-xs line-clamp-2">{{ $sponsor['name'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
