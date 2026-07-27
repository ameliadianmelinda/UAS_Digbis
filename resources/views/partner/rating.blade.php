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
                <form method="GET" action="{{ route('partner.ratings.index') }}" class="flex flex-1 flex-col gap-3 md:flex-row md:flex-wrap">
                    <label class="flex-1 min-w-64 md:min-w-72">
                        <span class="sr-only">Search peserta atau event</span>
                        <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 shadow-sm">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input
                                type="text"
                                name="search"
                                value="{{ old('search', $search ?? '') }}"
                                placeholder="Cari nama peserta atau nama event"
                                class="w-full border-0 bg-transparent text-sm text-slate-700 outline-none placeholder:text-slate-400"
                            >
                        </div>
                    </label>

                        <label class="min-w-44">
                            <span class="sr-only">Filter rating</span>
                            <select name="rating" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700 shadow-sm outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-100">
                                <option value="">Semua</option>
                                <option value="5" {{ (string)($rating ?? '') === '5' ? 'selected' : '' }}>★5</option>
                                <option value="4" {{ (string)($rating ?? '') === '4' ? 'selected' : '' }}>★4</option>
                                <option value="3" {{ (string)($rating ?? '') === '3' ? 'selected' : '' }}>★3</option>
                                <option value="2" {{ (string)($rating ?? '') === '2' ? 'selected' : '' }}>★2</option>
                                <option value="1" {{ (string)($rating ?? '') === '1' ? 'selected' : '' }}>★1</option>
                            </select>
                        </label>

                        <button type="submit" class="rounded-xl border border-slate-200 bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                            Cari
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
                            $reviewText = (string) data_get($review, 'review', '');
                            $shortReview = strlen($reviewText) > 80 ? substr($reviewText, 0, 80) . '...' : $reviewText;
                        @endphp
                        <tr class="bg-white transition hover:bg-slate-50">
                            <td class="whitespace-nowrap px-4 py-4 text-sm font-semibold text-slate-800">{{ data_get($review, 'participant') }}</td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm text-slate-700">{{ data_get($review, 'event') }}</td>
                            <td class="whitespace-nowrap px-4 py-4">
                                <div class="flex items-center gap-1 text-sm">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span class="{{ $i <= data_get($review, 'rating', 0) ? 'text-amber-400' : 'text-slate-300' }}">&#9733;</span>
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
                                    @if (trim($search ?? '') !== '' || trim($rating ?? '') !== '')
                                        <h3 class="text-lg font-semibold text-slate-800">Data tidak ditemukan</h3>
                                        <p class="mt-2 text-sm text-slate-500">Coba ubah kata kunci pencarian atau hapus filter rating.</p>
                                    @else
                                        <h3 class="text-lg font-semibold text-slate-800">Belum ada review</h3>
                                        <p class="mt-2 text-sm text-slate-500">Feedback peserta event akan muncul di sini setelah acara selesai.</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
