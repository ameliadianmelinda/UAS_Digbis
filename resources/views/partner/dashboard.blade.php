@extends('layouts.partner')

@section('title', 'Dashboard Partner')

@section('content')
    @php
        $partnerName = $partnerName ?? ($partner->name ?? 'Partner');
        $organization = $organization ?? ($partner->name ?? 'Partner');
        $joinedAt = $partner->created_at ? \Carbon\Carbon::parse($partner->created_at)->translatedFormat('d F Y') : '-';
        $stats = $stats ?? [];
        $latestEvents = $latestEvents ?? [];
        $topEvents = $topEvents ?? [];
        $nearestEvent = $nearestEvent ?? null;
        $transactions = $transactions ?? [];
        $activityItems = $activityItems ?? [];
        $revenueByMonth = $revenueByMonth ?? collect();
        $ticketByMonth = $ticketByMonth ?? collect();
    @endphp

    <div class="space-y-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
            <div class="flex items-center gap-3">
                
                <div>
                    <h1 class="text-2xl font-black text-slate-900">Dashboard Event Partner</h1>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm text-slate-600 shadow-sm">
                    <span class="font-semibold">{{ $organization }}</span>
                </div>
            </div>
        </div>

        <section class="mb-6 overflow-hidden rounded-2xl border  bg-indigo-600 border-white/20 bg-linear-to-r from-violet-700 via-indigo-600 to-fuchsia-500 text-white shadow-soft">
            <div class="px-5 py-6 md:px-8 md:py-8">
                <div class="mb-3 inline-flex items-center gap-2 rounded-full bg-white/15 px-3 py-1 text-xs font-semibold tracking-[0.2em] text-indigo-50 uppercase">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4" /></svg>
                    Welcome Partner
                </div>

                <h2 class="text-3xl font-black sm:text-4xl">Halo, {{ $partnerName }}</h2>
                <p class="mt-3 max-w-3xl text-sm text-indigo-100 sm:text-base">Selamat datang kembali! Pantau performa event, penjualan tiket, dan transaksi dalam satu dashboard yang mudah dipahami.</p>

                <div class="mt-5 flex flex-wrap gap-2">
                    <span class="inline-flex items-center gap-2 rounded-full bg-emerald-500/60 px-3 py-1.5 text-sm font-semibold text-emerald-50 ring-1 ring-emerald-200/40">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 3" /></svg>
                        Status: Aktif
                    </span>

                    <span class="inline-flex items-center gap-2 rounded-full bg-white/20 px-3 py-1.5 text-sm font-semibold text-white ring-1 ring-white/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        Bergabung: {{ $joinedAt }}
                    </span>
                </div>
            </div>
        </section>

        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
            @foreach ($stats as $stat)
                <div class="rounded-xl border border-indigo-100 bg-indigo-50/40 p-4 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold tracking-[0.22em] text-slate-400 uppercase">{{ $stat['label'] }}</p>
                            <p class="mt-3 text-2xl font-black text-slate-900">{{ $stat['value'] }}</p>
                        </div>
                        <div class="rounded-xl bg-indigo-50 p-3 text-indigo-600">
                            @if ($stat['icon'] === 'calendar')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            @elseif ($stat['icon'] === 'play')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 10v4a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            @elseif ($stat['icon'] === 'check')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 3" /></svg>
                            @elseif ($stat['icon'] === 'ticket')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16 3H8a2 2 0 00-2 2v2a2 2 0 110 4v2a2 2 0 110 4v2a2 2 0 002 2h8a2 2 0 002-2v-2a2 2 0 110-4v-2a2 2 0 110-4V5a2 2 0 00-2-2z" /></svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V6m0 12v-2m0-8c-1.11 0-2.08.402-2.599 1M6 9a9 9 0 012.5-6.5M18 9a9 9 0 00-2.5-6.5M7 17a9 9 0 0010 0" /></svg>
                            @endif
                        </div>
                    </div>
                    <p class="mt-3 text-sm font-semibold text-emerald-500">{{ $stat['trend'] }}</p>
                </div>
            @endforeach
        </section>

        <section class="mt-6 grid gap-6 xl:grid-cols-2">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold tracking-[0.24em] text-slate-400 uppercase">Grafik</p>
                        <h3 class="text-lg font-black text-slate-900">Pendapatan Bulanan</h3>
                    </div>
                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-600">{{ data_get($stats, '4.value', 'Rp 0') }}</span>
                </div>
                <div class="h-80">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <div class="rounded-xl border border-indigo-100 bg-indigo-50/40 p-4 shadow-sm sm:p-5">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold tracking-[0.24em] text-slate-400 uppercase">Grafik</p>
                        <h3 class="text-lg font-black text-slate-900">Tiket Terjual Bulanan</h3>
                    </div>
                    <span class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-600">{{ data_get($stats, '3.value', '0 tiket') }}</span>
                </div>
                <div class="h-80">
                    <canvas id="ticketChart"></canvas>
                </div>
            </div>
        </section>

        <section class="mt-6 grid gap-6 xl:grid-cols-2">
            <div class="rounded-xl border border-indigo-100 bg-indigo-50/40 p-4 shadow-sm sm:p-5">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold tracking-[0.24em] text-slate-400 uppercase">Event</p>
                        <h3 class="text-lg font-black text-slate-900">Event Terbaru</h3>
                    </div>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">5 item</span>
                </div>
                <div class="space-y-3">
                    @foreach ($latestEvents as $event)
                        <div class="flex items-center justify-between rounded-xl border border-slate-100 bg-slate-50 px-3 py-3">
                            <div>
                                <p class="font-bold text-slate-900">{{ $event['name'] }}</p>
                                <p class="text-sm text-slate-500">{{ $event['date'] }}</p>
                            </div>
                            <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-indigo-600">{{ $event['tickets'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-xl border border-indigo-100 bg-indigo-50/40 p-4 shadow-sm sm:p-5">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold tracking-[0.24em] text-slate-400 uppercase">Penjualan</p>
                        <h3 class="text-lg font-black text-slate-900">Event Terlaris</h3>
                    </div>
                    <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-600">Top 3</span>
                </div>
                <div class="space-y-3">
                    @foreach ($topEvents as $event)
                        <div class="flex items-center justify-between rounded-xl border border-slate-100 bg-slate-50 px-3 py-3">
                            <div>
                                <p class="font-bold text-slate-900">{{ $event['name'] }}</p>
                                <p class="text-sm text-slate-500">{{ $event['sales'] }}</p>
                            </div>
                            <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-600">{{ $event['income'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="mt-6 grid gap-6 xl:grid-cols-[0.95fr_1.05fr]">
            <div class="rounded-xl border border-indigo-100 bg-indigo-50/40 p-4 shadow-sm sm:p-5">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold tracking-[0.24em] text-slate-400 uppercase">Jadwal</p>
                        <h3 class="text-lg font-black text-slate-900">Event Terdekat</h3>
                    </div>
                    <span class="rounded-full bg-sky-50 px-3 py-1 text-xs font-semibold text-sky-600">Upcoming</span>
                </div>
                @if ($nearestEvent)
                    <div class="rounded-2xl bg-linear-to-br from-sky-50 to-indigo-50 p-4">
                        <p class="text-sm font-semibold text-sky-700">{{ $nearestEvent['date'] }}</p>
                        <h4 class="mt-2 text-xl font-black text-slate-900">{{ $nearestEvent['name'] }}</h4>
                        <p class="mt-1 text-sm text-slate-600">{{ $nearestEvent['location'] ?? '-' }}</p>
                    </div>
                @else
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-4 text-sm text-slate-500">
                        Belum ada event aktif untuk ditampilkan.
                    </div>
                @endif
            </div>

            <div class="rounded-xl border border-indigo-100 bg-indigo-50/40 p-4 shadow-sm sm:p-5">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold tracking-[0.24em] text-slate-400 uppercase">Feedback</p>
                        <h3 class="text-lg font-black text-slate-900">Rating & Review Terbaru</h3>
                    </div>
                    <span class="rounded-full bg-violet-50 px-3 py-1 text-xs font-semibold text-violet-600">4.8 / 5</span>
                </div>
                <div class="space-y-3">
                    @foreach ($activityItems as $review)
                        <div class="rounded-xl border border-slate-100 bg-slate-50 p-3">
                            <div class="flex items-center justify-between gap-2">
                                <p class="font-bold text-slate-900">{{ $review['name'] }}</p>
                                <div class="flex items-center gap-1 text-amber-400">
                                    @for ($i = 0; $i < $review['rating']; $i++)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.783.57-1.838-.197-1.538-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.029 10.72c-.783-.57-.38-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-slate-600">{{ $review['comment'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="mt-6 rounded-xl border border-indigo-100 bg-indigo-50/40 p-4 shadow-sm sm:p-5">
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold tracking-[0.24em] text-slate-400 uppercase">Transaksi</p>
                    <h3 class="text-lg font-black text-slate-900">Transaksi Terbaru</h3>
                </div>
                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">5 penjualan</span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm text-slate-700">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-500">
                            <th class="py-3 pr-4 font-semibold">Nama Pembeli</th>
                            <th class="py-3 pr-4 font-semibold">Nama Event</th>
                            <th class="py-3 pr-4 font-semibold">Order ID</th>
                            <th class="py-3 pr-4 font-semibold">Total Pembayaran</th>
                            <th class="py-3 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr class="border-b border-slate-100 last:border-b-0">
                                <td class="py-3 pr-4 font-semibold text-slate-900">{{ $transaction['buyer'] }}</td>
                                <td class="py-3 pr-4">{{ $transaction['event'] }}</td>
                                <td class="py-3 pr-4">{{ $transaction['order_id'] }}</td>
                                <td class="py-3 pr-4 font-semibold text-slate-900">{{ $transaction['amount'] }}</td>
                                <td class="py-3">
                                    @php
                                        $statusClass = match ($transaction['status']) {
                                            'Paid' => 'bg-emerald-50 text-emerald-600',
                                            'Pending' => 'bg-amber-50 text-amber-600',
                                            default => 'bg-rose-50 text-rose-600',
                                        };
                                    @endphp
                                    <span class="rounded-full px-2.5 py-1 text-xs font-bold {{ $statusClass }}">{{ $transaction['status'] }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const revenueCtx = document.getElementById('revenueChart');
        const ticketCtx = document.getElementById('ticketChart');

        const revenueLabels = {!! json_encode($revenueByMonth->pluck('label')) !!};
        const revenueData = {!! json_encode($revenueByMonth->pluck('value')) !!};
        const ticketLabels = {!! json_encode($ticketByMonth->pluck('label')) !!};
        const ticketData = {!! json_encode($ticketByMonth->pluck('value')) !!};

        if (revenueCtx) {
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: revenueLabels,
                    datasets: [{
                        label: 'Pendapatan Bulanan',
                        data: revenueData,
                        borderColor: '#4f46e5',
                        backgroundColor: 'rgba(79, 70, 229, 0.12)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            ticks: {
                                callback: (value) => `Rp ${value} jt`
                            }
                        }
                    }
                }
            });
        }

        if (ticketCtx) {
            new Chart(ticketCtx, {
                type: 'bar',
                data: {
                    labels: ticketLabels,
                    datasets: [{
                        label: 'Tiket Terjual',
                        data: ticketData,
                        backgroundColor: ['#6366f1', '#818cf8', '#6366f1', '#818cf8', '#6366f1', '#818cf8', '#6366f1'],
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 50
                            }
                        }
                    }
                }
            });
        }
    </script>
@endsection
