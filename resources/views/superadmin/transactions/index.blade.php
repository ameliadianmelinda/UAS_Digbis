@extends('layouts.superadmin')
@section('title', 'Laporan Transaksi')
@section('page_title', 'Laporan Transaksi')
@section('page_subtitle', 'Lihat seluruh transaksi lintas tenant.')

@section('content')
<form method="GET" class="bg-white rounded-3xl border border-slate-100 p-6 mb-6 grid grid-cols-1 gap-4 md:grid-cols-4">
    <div class="relative">
        <select name="tenant_id" class="w-full h-14 px-4 pr-14 bg-slate-50 rounded-2xl border border-slate-200 text-slate-900 appearance-none">
            <option value="">Semua Tenant</option>
            @foreach($tenants as $tenant)
                <option value="{{ $tenant->id }}" @selected(request('tenant_id') == $tenant->id)>{{ $tenant->name }}</option>
            @endforeach
        </select>
        <div class="pointer-events-none absolute right-5 top-1/2 -translate-y-1/2 text-slate-400">
            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                <path d="M6 8l4 4 4-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
    </div>

    <div class="relative">
        <select name="status" class="w-full h-14 px-4 pr-14 bg-slate-50 rounded-2xl border border-slate-200 text-slate-900 appearance-none">
            <option value="">Semua Status</option>
            @foreach(['pending','success','settlement','expire','cancel'] as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>{{ strtoupper($status) }}</option>
            @endforeach
        </select>
        <div class="pointer-events-none absolute right-5 top-1/2 -translate-y-1/2 text-slate-400">
            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                <path d="M6 8l4 4 4-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
    </div>

    <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full h-14 px-4 bg-slate-50 rounded-2xl border border-slate-200 text-slate-900">
    <button class="w-full h-14 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition">Filter</button>
</form>

<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto text-left border-separate border-spacing-0">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-6 py-4 whitespace-nowrap">Invoice</th>
                    <th class="px-6 py-4 whitespace-nowrap min-w-[180px]">Tenant</th>
                    <th class="px-6 py-4 whitespace-nowrap min-w-[220px]">Event</th>
                    <th class="px-6 py-4 whitespace-nowrap">Pembeli</th>
                    <th class="px-6 py-4 whitespace-nowrap">Total</th>
                    <th class="px-6 py-4 whitespace-nowrap">Status</th>
                    <th class="px-6 py-4 whitespace-nowrap">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($transactions as $transaction)
                    @php
                        $status = strtoupper($transaction->status ?? 'UNKNOWN');
                        $statusClasses = match($status) {
                            'SUCCESS', 'SETTLEMENT' => 'bg-green-100 text-green-700 border border-green-200',
                            'PENDING' => 'bg-amber-100 text-amber-700 border border-amber-200',
                            'EXPIRE', 'EXPIRED', 'FAILED' => 'bg-red-100 text-red-700 border border-red-200',
                            'CANCEL', 'CANCELLED' => 'bg-slate-100 text-slate-600 border border-slate-200',
                            default => 'bg-slate-100 text-slate-600 border border-slate-200',
                        };
                    @endphp
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-5 align-middle whitespace-nowrap">
                            <a href="{{ route('superadmin.transactions.show', $transaction) }}" class="font-mono font-bold text-indigo-600 hover:text-indigo-700 truncate block max-w-[160px]">{{ $transaction->order_id }}</a>
                        </td>
                        <td class="px-6 py-5 align-middle whitespace-nowrap">
                            <span class="block truncate max-w-[180px]">{{ $transaction->event->partner->name ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-5 align-middle whitespace-nowrap">
                            <span class="block truncate max-w-[240px]">{{ $transaction->event->title ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-5 align-middle whitespace-nowrap">
                            <span class="block truncate max-w-[180px]">{{ $transaction->customer_name }}</span>
                        </td>
                        <td class="px-6 py-5 align-middle whitespace-nowrap font-black text-slate-900">
                            <span class="block truncate max-w-[140px]">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-5 align-middle whitespace-nowrap">
                            <span class="inline-flex items-center justify-center rounded-full px-3 py-1 text-xs font-semibold uppercase {{ $statusClasses }}">{{ $status }}</span>
                        </td>
                        <td class="px-6 py-5 align-middle whitespace-nowrap text-sm text-slate-500">
                            {{ $transaction->created_at->format('d M Y, H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-slate-400">Belum ada transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-6">
        {{ $transactions->links() }}
    </div>
</div>
@endsection
