@extends('layouts.superadmin')

@section('title', 'Kelola Tenant')
@section('page_title', 'Kelola Tenant')
@section('page_subtitle', 'Pantau dan kendalikan akun Tenant platform.')

@section('content')
<form method="GET" class="mb-4 flex gap-2"><input name="search" value="{{ request('search') }}" placeholder="Cari nama tenant..." class="flex-1 px-5 py-3 bg-white border-2 border-slate-100 rounded-2xl outline-none focus:border-indigo-600"><button class="px-5 py-3 bg-indigo-600 text-white rounded-2xl font-bold">Cari</button></form>
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden"><div class="overflow-x-auto"><table class="w-full text-left">
    <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest"><tr><th class="px-8 py-4 whitespace-nowrap">Nama Organisasi</th><th class="px-8 py-4 whitespace-nowrap">Nama PIC</th><th class="px-8 py-4 whitespace-nowrap min-w-[260px]">Email</th><th class="px-8 py-4 whitespace-nowrap">Status</th><th class="px-8 py-4 whitespace-nowrap">Jumlah Event</th><th class="px-8 py-4 whitespace-nowrap">Aksi</th></tr></thead>
    <tbody class="divide-y">@forelse($tenants as $tenant)<tr class="hover:bg-slate-50"><td class="px-8 py-5 font-bold whitespace-nowrap overflow-hidden text-ellipsis max-w-[260px]">{{ $tenant->name }}</td><td class="px-8 py-5 whitespace-nowrap overflow-hidden text-ellipsis max-w-[180px]">{{ $tenant->user->name }}</td><td class="px-8 py-5 text-slate-600 whitespace-nowrap overflow-hidden text-ellipsis min-w-[260px]">{{ $tenant->email ?: $tenant->user->email }}</td><td class="px-8 py-5 whitespace-nowrap"><span class="px-3 py-1 rounded-lg text-xs font-bold uppercase {{ $tenant->user->isSuspended() ? 'bg-rose-100 text-rose-700' : 'bg-green-100 text-green-700' }}">{{ $tenant->user->status }}</span></td><td class="px-8 py-5 text-sm text-slate-500 whitespace-nowrap">{{ $tenant->events->count() }}</td><td class="px-8 py-5 whitespace-nowrap"><a href="{{ route('superadmin.tenants.show', $tenant) }}" class="text-indigo-600 font-bold">Detail</a></td></tr>@empty<tr><td colspan="6" class="p-8 text-center text-slate-400">Belum ada Tenant.</td></tr>@endforelse</tbody>
</table></div><div class="p-6">{{ $tenants->links() }}</div></div>
@endsection
