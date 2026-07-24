@extends('layouts.partner')

@section('content')
@php
    $reviews = $reviews ?? collect([]);
@endphp

<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-black tracking-tight text-slate-900 sm:text-4xl">Rating & Review</h1>
        <p class="mt-2 text-sm text-slate-500">Pantau feedback peserta event dan kualitas pengalaman yang mereka rasakan.</p>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 bg-white p-4 sm:p-5">
            <div class="flex flex-col gap-3 xl:flex-row xl:items-center xl:justify-between">
                <form method="GET" action="#" class="flex flex-1 flex-col gap-3 md:flex-row md:flex-wrap">
                    <label class="flex-1 min-w-64 md:min-w-72">
                        <span class="sr-only">Search peserta atau event</span>
                        <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 shadow-sm">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input
                                type="text"
                                name="search"
                                placeholder="Cari nama peserta atau nama event"
                                class="w-full border-0 bg-transparent text-sm text-slate-700 outline-none placeholder:text-slate-400"
                            >
                        </div>
                    </label>

                    <label class="min-w-44">
                        <span class="sr-only">Filter rating</span>
                        <select class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700 shadow-sm outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-100">
                            <option>Semua</option>
                            <option>★5</option>
                            <option>★4</option>
                            <option>★3</option>
                            <option>★2</option>
                            <option>★1</option>
                        </select>
                    </label>

                    <button type="button" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                        Export
                    </button>
                </form>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Nama Peserta</th>
                        <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Nama Event</th>
                        <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Rating</th>
                        <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Review</th>
                        <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Tanggal Review</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($reviews as $review)
                        @php
                            $rating = (int) data_get($review, 'rating', 0);
                            $reviewText = (string) data_get($review, 'review', '');
                            $shortReview = strlen($reviewText) > 80 ? substr($reviewText, 0, 80) . '...' : $reviewText;
                        @endphp
                        <tr class="bg-white transition hover:bg-slate-50">
                            <td class="whitespace-nowrap px-4 py-4 text-sm font-semibold text-slate-800">{{ data_get($review, 'participant') }}</td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm text-slate-700">{{ data_get($review, 'event') }}</td>
                            <td class="whitespace-nowrap px-4 py-4">
                                <div class="flex items-center gap-1 text-amber-400">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $rating)
                                            <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.955a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.446a1 1 0 00-.364 1.118l1.287 3.955c.3.921-.755 1.688-1.538 1.118L10 2.927z"></path></svg>
                                        @else
                                            <svg class="h-4 w-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg>
                                        @endif
                                    @endfor
                                </div>
                            </td>
                            <td class="max-w-xs px-4 py-4 text-sm text-slate-700">{{ $shortReview }}</td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm text-slate-700">{{ data_get($review, 'date') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="mx-auto flex max-w-md flex-col items-center rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-10">
                                    <svg class="h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5h2m-1 4v10m-6 0h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <h3 class="mt-4 text-lg font-semibold text-slate-800">Belum ada review</h3>
                                    <p class="mt-2 text-sm text-slate-500">Feedback peserta event akan muncul di sini setelah acara selesai.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-center">
        <div class="rounded-2xl border border-slate-200 bg-white px-3 py-2 shadow-sm">
            <nav class="flex items-center gap-2 text-sm text-slate-600">
                <span class="rounded-lg px-3 py-1.5 hover:bg-slate-100">1</span>
                <span class="rounded-lg bg-indigo-600 px-3 py-1.5 text-white">2</span>
                <span class="rounded-lg px-3 py-1.5 hover:bg-slate-100">3</span>
            </nav>
        </div>
    </div>
</div>
@endsection
