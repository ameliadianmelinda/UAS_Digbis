@extends('layouts.partner')

@section('content')
@php
    $transactions = $transactions ?? collect([]);
@endphp

<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-black tracking-tight text-slate-900 sm:text-4xl">Transaksi</h1>
        <p class="mt-2 text-sm text-slate-500">Pantau pembayaran event, status order, dan riwayat transaksi partner.</p>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 bg-white p-4 sm:p-5">
            <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <form method="GET" action="{{ route('partner.transactions.index') }}" class="flex flex-1 flex-col gap-3 sm:flex-row sm:flex-wrap">
                    <label class="flex-1 min-w-64 sm:min-w-88">
                        <span class="sr-only">Search transaksi</span>
                        <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 shadow-sm">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input
                                type="text"
                                name="search"
                                value="{{ old('search', $search ?? '') }}"
                                placeholder="Cari Order ID, Customer, atau Nama Event"
                                class="w-full border-0 bg-transparent text-sm text-slate-700 outline-none placeholder:text-slate-400"
                            >
                        </div>
                    </label>

                    <button type="submit" class="rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                        Cari
                    </button>

                    <a href="{{ route('partner.transactions.export', ['search' => $search]) }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                        Export
                    </a>
                </form>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Order ID</th>
                        <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Nama Event</th>
                        <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Customer</th>
                        <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Email</th>
                        <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">No. HP</th>
                        <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Total Pembayaran</th>
                        <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                        <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Tanggal Transaksi</th>
                        <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($transactions as $transaction)
                        @php
                            $status = data_get($transaction, 'status', 'Pending');
                            $statusClasses = [
                                'Pending' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200',
                                'Settlement' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
                                'Success' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
                                'Failed' => 'bg-rose-50 text-rose-700 ring-1 ring-rose-200',
                                'Expired' => 'bg-slate-100 text-slate-700 ring-1 ring-slate-200',
                                'Cancel' => 'bg-rose-50 text-rose-700 ring-1 ring-rose-200',
                            ];
                        @endphp
                        <tr class="h-20 bg-white transition hover:bg-slate-50">
                            <td class="whitespace-nowrap px-4 py-4 text-sm font-semibold text-slate-800">
                                <a href="{{ route('partner.transactions.show', $transaction['id']) }}" class="font-semibold text-indigo-600 hover:text-indigo-700 hover:underline">
                                    {{ data_get($transaction, 'order_id') }}
                                </a>
                            </td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm text-slate-700">{{ data_get($transaction, 'event_name') }}</td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm text-slate-700">{{ data_get($transaction, 'customer') }}</td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm text-slate-700">{{ data_get($transaction, 'email') }}</td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm text-slate-700">{{ data_get($transaction, 'phone') }}</td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm font-semibold text-slate-800">{{ data_get($transaction, 'total') }}</td>
                            <td class="whitespace-nowrap px-4 py-4">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClasses[$status] ?? 'bg-slate-100 text-slate-600 ring-1 ring-slate-200' }}">
                                    {{ $status }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm text-slate-700">{{ data_get($transaction, 'date') }}</td>
                            <td class="whitespace-nowrap px-4 py-4">
                                <a href="{{ route('partner.transactions.show', $transaction['id']) }}" class="inline-flex items-center rounded-lg border border-indigo-200 bg-indigo-50 px-3 py-2 text-xs font-semibold text-indigo-700 transition hover:bg-indigo-100 hover:text-indigo-800">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-16 text-center">
                                <div class="mx-auto flex max-w-md flex-col items-center rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-10">
                                    <svg class="h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <h3 class="mt-4 text-lg font-semibold text-slate-800">Belum ada transaksi</h3>
                                    <p class="mt-2 text-sm text-slate-500">Riwayat transaksi akan muncul di sini setelah customer melakukan pembayaran.</p>
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
