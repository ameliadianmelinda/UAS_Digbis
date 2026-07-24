@extends('layouts.partner')

@section('content')
@php
    $events = $events ?? collect([]);
    $search = $search ?? '';
@endphp

<div class="space-y-6">
    <h1 class="text-3xl font-black tracking-tight text-slate-900 sm:text-4xl">Daftar Event</h1>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 bg-white p-4 sm:p-5">
            <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <form method="GET" action="#" class="flex flex-1 flex-col gap-3 sm:flex-row sm:flex-wrap">
                    <label class="flex-1 min-w-64 sm:min-w-88">
                        <span class="sr-only">Search Event</span>
                        <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 shadow-sm">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input
                                type="text"
                                name="search"
                                value="{{ $search }}"
                                placeholder="Search Event"
                                class="w-full border-0 bg-transparent text-sm text-slate-700 outline-none placeholder:text-slate-400"
                            >
                        </div>
                    </label>

                    <button type="submit" class="rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                        Cari
                    </button>
                </form>

                <a href="{{ route('partner.events.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Buat Event Baru
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Event</th>
                        <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Tanggal Event</th>
                        <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Tiket Terjual</th>
                        <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status Tiket</th>
                        <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Pendapatan</th>
                        <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($events as $event)
                        @php
                            $sold = (int) data_get($event, 'sold', 0);
                            $capacity = max((int) data_get($event, 'capacity', 0), 1);
                            $statusInput = (string) data_get($event, 'status', 'Tersedia');
                            $status = match ($statusInput) {
                                'Hampir Habis' => 'Hampir Habis',
                                'Sold Out' => 'Sold Out',
                                'Ditutup', 'Penjualan Ditutup' => 'Ditutup',
                                default => 'Tersedia',
                            };

                            $statusClasses = [
                                'Tersedia' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
                                'Hampir Habis' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200',
                                'Sold Out' => 'bg-rose-50 text-rose-700 ring-1 ring-rose-200',
                                'Ditutup' => 'bg-slate-100 text-slate-600 ring-1 ring-slate-200',
                            ];
                        @endphp

                        <tr class="h-24 bg-white transition hover:bg-slate-50">
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-14 w-20 shrink-0 overflow-hidden rounded-xl border border-slate-200 bg-slate-100">
                                        @if (data_get($event, 'banner'))
                                            <img src="{{ data_get($event, 'banner') }}" alt="{{ data_get($event, 'name', 'Banner Event') }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="flex h-full items-center justify-center text-[10px] font-semibold uppercase tracking-wider text-slate-400">
                                                Event
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="truncate font-semibold text-slate-900">{{ data_get($event, 'name', 'Event') }}</div>
                                        <div class="mt-1 flex flex-wrap items-center gap-2">
                                            <span class="inline-flex rounded-full bg-indigo-50 px-2 py-0.5 text-xs font-semibold text-indigo-700">
                                                {{ data_get($event, 'category', '-') }}
                                            </span>
                                            <span class="inline-flex items-center gap-1 text-sm text-slate-500">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3zm0 2c-3.866 0-7 2.239-7 5v1h14v-1c0-2.761-3.134-5-7-5z"></path>
                                                </svg>
                                                {{ data_get($event, 'location', '-') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm text-slate-600">{{ data_get($event, 'date', '-') }}</td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm font-semibold text-slate-800">{{ data_get($event, 'sold', 0) }} / {{ data_get($event, 'capacity', 0) }} Tiket</td>
                            <td class="whitespace-nowrap px-4 py-4">
                                <span class="inline-flex whitespace-nowrap rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClasses[$status] ?? 'bg-slate-100 text-slate-600 ring-1 ring-slate-200' }}">
                                    {{ $status }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm font-semibold text-slate-800">{{ data_get($event, 'revenue', 'Rp 0') }}</td>
                            <td class="whitespace-nowrap px-4 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="#" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 transition hover:bg-slate-100 hover:text-slate-900" title="Edit">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-9.5a2 2 0 113 3L12 15l-4 1 1-4 7.5-7.5z"></path>
                                        </svg>
                                    </a>
                                    <a href="#" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-rose-200 text-rose-600 transition hover:bg-rose-50" title="Hapus">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22m-4 0H7l1-2a2 2 0 012-1h4a2 2 0 012 1l1 2z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="mx-auto flex max-w-md flex-col items-center rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-10">
                                    <svg class="h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <h3 class="mt-4 text-lg font-semibold text-slate-800">Belum ada event</h3>
                                    <p class="mt-2 text-sm text-slate-500">Mulai buat event pertama Anda dan tampilkan daftar event di sini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($events instanceof \Illuminate\Contracts\Pagination\Paginator || $events instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="flex justify-center">
            <div class="rounded-2xl border border-slate-200 bg-white px-3 py-2 shadow-sm">
                {{ $events->links('pagination::tailwind') }}
            </div>
        </div>
    @endif
</div>
@endsection
