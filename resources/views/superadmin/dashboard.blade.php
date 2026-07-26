@extends('layouts.superadmin')
@section('title', 'Dashboard Super Admin')
@section('page_title', 'Ringkasan Dashboard')
@section('page_subtitle', 'Pantau seluruh aktivitas platform Event Ticketing.')
@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">
    @foreach([
        ['Total Tenant', number_format($totalTenants, 0, ',', '.'), 'bg-indigo-50 text-indigo-600', 'M17 20h5v-2a4 4 0 00-4-4h-1.26M9 20H4v-2a4 4 0 014-4h1.26M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
        ['Total Event', number_format($totalEvents, 0, ',', '.'), 'bg-orange-50 text-orange-600', 'M8 2v4M16 2v4M3 8h18M5 22h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
        ['Total Tiket Terjual', number_format($totalTicketsSold, 0, ',', '.'), 'bg-green-50 text-green-600', 'M21 10V6a2 2 0 00-2-2H5a2 2 0 00-2 2v4a3 3 0 010 6v4a2 2 0 002 2h14a2 2 0 002-2v-4a3 3 0 010-6zM7 12h10'],
        ['Total Pendapatan Platform', 'Rp ' . number_format($totalPlatformRevenue, 0, ',', '.'), 'bg-rose-50 text-rose-600', 'M7 9V7a2 2 0 012-2h6a2 2 0 012 2v2M3 10h18M7 9h10M7 21h10a2 2 0 002-2v-7H5v7a2 2 0 002 2zM12 15a2 2 0 100-4 2 2 0 000 4z'],
    ] as $card)
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="w-12 h-12 {{ $card[2] }} rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="{{ $card[3] }}" />
            </svg>
        </div>
        <p class="text-slate-400 text-sm font-bold uppercase mb-1">{{ $card[0] }}</p>
        <h3 class="text-2xl font-black">{{ $card[1] }}</h3>
    </div>
    @endforeach
</div>
<div id="superadmin-chart-data" data-labels="{{ json_encode($monthlyLabels) }}" data-revenue="{{ json_encode($monthlyRevenue) }}" data-tenants="{{ json_encode($monthlyTenantRegistrations) }}" hidden></div>
<div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-10">
    <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm"><h3 class="font-black text-xl mb-6">Pendapatan Platform Bulanan</h3><div class="relative h-72"><canvas id="platformRevenueChart"></canvas></div></div>
    <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm"><h3 class="font-black text-xl mb-6">Registrasi Tenant Bulanan</h3><div class="relative h-72"><canvas id="tenantRegistrationChart"></canvas></div></div>
</div>
<div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-10">
    <section class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden"><div class="p-8 border-b flex justify-between"><h3 class="font-black text-xl">Tenant Terbaru</h3><a href="{{ route('superadmin.tenants.index') }}" class="text-indigo-600 font-bold">Lihat Semua</a></div><div class="divide-y">@forelse($recentTenants as $tenant)<div class="px-8 py-5 flex items-center gap-4"><div class="flex-1"><p class="font-bold">{{ $tenant->name }}</p><p class="text-xs text-slate-400">{{ $tenant->created_at->format('d M Y') }}</p></div><span class="px-3 py-1 rounded-lg text-xs font-bold uppercase {{ $tenant->status === 'suspended' ? 'bg-rose-100 text-rose-700' : 'bg-green-100 text-green-700' }}">{{ $tenant->status ?? 'active' }}</span></div>@empty<div class="p-8 text-center text-slate-400">Belum ada tenant.</div>@endforelse</div></section>
    <section class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden"><div class="p-8 border-b flex justify-between"><h3 class="font-black text-xl">Event Terbaru</h3><a href="{{ route('superadmin.events.index') }}" class="text-indigo-600 font-bold">Lihat Semua</a></div><div class="divide-y">@forelse($recentEvents as $event)<div class="px-8 py-5 grid grid-cols-[64px_minmax(0,1fr)_auto] gap-4 items-center">@php
    $posterUrl = 'https://placehold.co/100x100';
    if ($event->poster_path) {
        if (file_exists(public_path($event->poster_path))) {
            $posterUrl = asset($event->poster_path);
        } elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists($event->poster_path)) {
            $posterUrl = asset('storage/' . ltrim($event->poster_path, '/'));
        }
    }
@endphp<img src="{{ $posterUrl }}" alt="{{ $event->title }}" class="w-16 h-16 rounded-3xl object-cover bg-slate-100"><div class="min-w-0"><p class="font-bold truncate">{{ $event->title }}</p><p class="text-xs text-slate-400">{{ $event->partner->name ?? 'Tenant belum ditentukan' }} · {{ $event->date->format('d M Y') }}</p></div><div class="flex flex-col items-end gap-2"><span class="px-3 py-1 rounded-lg text-xs font-bold uppercase {{ ($event->status ?? 'active') === 'inactive' ? 'bg-slate-100 text-slate-600' : 'bg-green-100 text-green-700' }}">{{ $event->status ?? 'active' }}</span></div></div>@empty<div class="p-8 text-center text-slate-400">Belum ada event.</div>@endforelse</div></section>
</div>
<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
    <section class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden"><div class="p-8 border-b flex justify-between"><h3 class="font-black text-xl">Transaksi Terbaru</h3><a href="{{ route('superadmin.transactions.index') }}" class="text-indigo-600 font-bold">Lihat Semua</a></div><div class="divide-y">@forelse($recentTransactions as $transaction)<div class="px-8 py-5 flex items-center gap-4"><div class="flex-1"><p class="font-bold">{{ $transaction->order_id }}</p><p class="text-xs text-slate-400">{{ $transaction->event->title ?? '-' }} · {{ $transaction->customer_name }}</p></div><p class="font-black">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p><span class="px-3 py-1 rounded-lg text-xs font-bold uppercase bg-slate-100 text-slate-700">{{ $transaction->status }}</span></div>@empty<div class="p-8 text-center text-slate-400">Belum ada transaksi.</div>@endforelse</div></section>
    <section class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden"><div class="p-8 border-b"><h3 class="font-black text-xl">Aktivitas Terbaru</h3></div><div class="divide-y">@forelse($activities as $activity)<div class="px-8 py-5"><p class="font-bold">{{ $activity['label'] }}</p><p class="text-sm text-slate-500">{{ $activity['subject'] }}</p><p class="text-xs text-slate-400 mt-1">{{ $activity['date']->format('d M Y, H:i') }}</p></div>@empty<div class="p-8 text-center text-slate-400">Belum ada aktivitas.</div>@endforelse</div></section>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script><script>
const data = document.getElementById('superadmin-chart-data').dataset; const labels = JSON.parse(data.labels); const options = {responsive:true, maintainAspectRatio:false, plugins:{legend:{display:false}}, scales:{y:{beginAtZero:true, ticks:{precision:0}}}};
new Chart(document.getElementById('platformRevenueChart'), {type:'bar', data:{labels, datasets:[{data:JSON.parse(data.revenue), backgroundColor:'#6366f1', borderRadius:6}]}, options});
new Chart(document.getElementById('tenantRegistrationChart'), {type:'line', data:{labels, datasets:[{data:JSON.parse(data.tenants), borderColor:'#f97316', backgroundColor:'rgba(249,115,22,.12)', fill:true, tension:.35}]}, options});
</script>
@endsection
