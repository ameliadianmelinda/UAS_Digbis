@extends('layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 lg:grid-cols-3 gap-12">
        @if(session('error'))
            <div class="lg:col-span-3 mb-6 p-4 rounded-3xl bg-rose-50 border border-rose-200 text-rose-700 font-bold">
                {{ session('error') }}
            </div>
        @endif
        <!-- Left: Poster -->
        <div class="lg:col-span-1">
            <div class="sticky top-32">
                @php
                    $posterUrl = null;
                    if (!empty($event->poster_path) && file_exists(public_path($event->poster_path))) {
                        $posterUrl = asset($event->poster_path);
                    }
                    $partnerName = $event->partner?->name ?? 'Penyelenggara Tidak Diketahui';
                    $partnerInitials = implode('', array_map(fn($part) => strtoupper(substr($part, 0, 1)), explode(' ', trim($partnerName))));
                @endphp
                <img src="{{ $posterUrl ?? 'https://placehold.co/400x533?text=No+Image' }}" alt="{{ $event->title }}" class="w-full rounded-[2.5rem] shadow-2xl border-8 border-white object-cover aspect-[3/4]">
                <div class="mt-8 p-6 bg-white rounded-3xl border border-slate-100 shadow-sm">
                    <h4 class="font-bold mb-4">Penyelenggara</h4>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold">
                            {{ $partnerInitials }}</div>
                        <div>
                            <p class="font-bold text-slate-800">{{ $partnerName }}</p>
                            <p class="text-xs text-slate-500">Verified Organizer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Details -->
        <div class="lg:col-span-2 space-y-12">
            <div class="space-y-4">
                <span
                    class="px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">{{ $event->category->name }}</span>
                <h1 class="text-4xl md:text-5xl font-black leading-tight">{{ $event->title }}</h1>
                <div class="flex flex-wrap gap-6 text-slate-500 font-medium">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>{{ $event->location }}</span>
                    </div>
                </div>
            </div>

            <div class="prose prose-slate max-w-none">
                <h3 class="text-2xl font-bold mb-4">Deskripsi Event</h3>
                <p class="text-lg text-slate-600 leading-relaxed">
                    {{ $event->description }}
                </p>
            </div>

            <div
                class="bg-indigo-600 rounded-[2.5rem] p-8 md:p-12 text-white shadow-2xl shadow-indigo-200 relative overflow-hidden">
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
                    <div>
                        <p class="text-indigo-200 font-bold uppercase tracking-widest text-sm mb-2">Harga Tiket</p>
                        <h2 class="text-5xl font-black">Rp {{ number_format($event->price, 0, ',', '.') }} <span class="text-lg font-medium text-indigo-200">/
                                orang</span></h2>
                        <p class="mt-4 text-indigo-100 flex items-center gap-2" id="availability-status">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span id="availability-text">
                                @if($isSoldOut)
                                    <span class="font-bold underline">Sisa stok: Sold Out</span>
                                @else
                                    Sisa stok: <span class="font-bold underline">{{ $remainingTickets }} Tiket lagi!</span>
                                @endif
                            </span>
                        </p>
                    </div>
                    <div id="checkout-action">
                        @if($isSoldOut)
                            <button disabled
                                class="inline-flex cursor-not-allowed items-center justify-center px-10 py-5 rounded-2xl bg-slate-200 text-slate-500 font-black text-xl shadow-xl">
                                Sold Out
                            </button>
                        @else
                            <a href="{{ route('checkout.create', $event) }}"
                                class="inline-block px-10 py-5 bg-white text-indigo-600 rounded-2xl font-black text-xl hover:scale-105 transition-transform shadow-xl">
                                Pesan Sekarang
                            </a>
                        @endif
                    </div>
                </div>
                <!-- Decoration -->
                <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-white opacity-10 rounded-full"></div>
                <div class="absolute -left-10 -top-10 w-32 h-32 bg-indigo-400 opacity-20 rounded-full"></div>
            </div>

            <div class="space-y-4">
                <h3 class="text-xl font-bold">Kebijakan Tiket</h3>
                <ul class="space-y-3 text-slate-500">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        E-Ticket akan dikirimkan otomatis setelah pembayaran berhasil.
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Tiket dapat discan di pintu masuk (Check-in).
                    </li>
                    <li class="flex items-start gap-2 text-rose-500">
                        <svg class="w-5 h-5 text-rose-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Tiket yang sudah dibeli tidak dapat direfund.
                    </li>
                </ul>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const availabilityText = document.getElementById('availability-text');
        const checkoutAction = document.getElementById('checkout-action');
        const availabilityUrl = @json(route('events.availability', $event));
        const checkoutHref = @json(route('checkout.create', $event));

        if (!availabilityText || !checkoutAction) {
            return;
        }

        let prevAvailable = Number(@json($remainingTickets ?? 0));

        const updateAvailability = () => {
            // prevent cached responses by adding a timestamp and telling fetch not to use cache
            const url = availabilityUrl + (availabilityUrl.includes('?') ? '&' : '?') + '_=' + Date.now();
            fetch(url, {
                headers: { 'Accept': 'application/json', 'Cache-Control': 'no-store' },
                cache: 'no-store'
            })
                .then(response => response.json())
                .then(data => {
                    const available = Number(data.available_tickets ?? 0);
                    const isSoldOut = Boolean(data.is_sold_out);
                    // If available changed from what was shown when page loaded,
                    // reload the page so the whole view (and any dependent state)
                    // stays consistent (useful when users are in payment flow).
                    if (available !== prevAvailable) {
                        // small delay to avoid interrupting immediate UI updates
                        return window.location.reload();
                    }

                    availabilityText.innerHTML = isSoldOut
                        ? '<span class="font-bold underline">Sisa stok: Sold Out</span>'
                        : 'Sisa stok: <span class="font-bold underline">' + available + ' Tiket lagi!</span>';

                    prevAvailable = available;

                    if (isSoldOut) {
                        checkoutAction.innerHTML = `
                            <button disabled
                                class="inline-flex cursor-not-allowed items-center justify-center px-10 py-5 rounded-2xl bg-slate-200 text-slate-500 font-black text-xl shadow-xl">
                                Sold Out
                            </button>
                        `;
                    } else {
                        checkoutAction.innerHTML = `
                            <a href="${checkoutHref}"
                                class="inline-block px-10 py-5 bg-white text-indigo-600 rounded-2xl font-black text-xl hover:scale-105 transition-transform shadow-xl">
                                Pesan Sekarang
                            </a>
                        `;
                    }
                })
                .catch(() => {});
        };

        updateAvailability();
        window.setInterval(updateAvailability, 3000);
    });
</script>
@endsection
