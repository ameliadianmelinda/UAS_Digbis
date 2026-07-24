@extends('layouts.superadmin')

@section('title', 'Kelola Tenant')
@section('page_title', 'Kelola Tenant')
@section('page_subtitle', 'Pantau dan kendalikan akun Tenant platform.')

@section('content')
<form method="GET" class="mb-4 flex gap-2"><input name="search" value="{{ request('search') }}" placeholder="Cari nama tenant..." class="flex-1 px-5 py-3 bg-white border-2 border-slate-100 rounded-2xl outline-none focus:border-indigo-600"><button class="px-5 py-3 bg-indigo-600 text-white rounded-2xl font-bold">Cari</button></form>
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden"><div class="overflow-x-auto"><table class="w-full text-left">
    <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest"><tr><th class="px-8 py-4">Logo</th><th class="px-8 py-4">Nama Organisasi</th><th class="px-8 py-4">Nama PIC</th><th class="px-8 py-4">Email</th><th class="px-8 py-4">Status</th><th class="px-8 py-4">Jumlah Event</th><th class="px-8 py-4">Aksi</th></tr></thead>
    <tbody class="divide-y">@forelse($tenants as $tenant)<tr class="hover:bg-slate-50"><td class="px-8 py-5"><img src="{{ $tenant->logo_url ?: 'https://ui-avatars.com/api/?name=' . urlencode($tenant->name) }}" class="w-12 h-12 rounded-xl object-cover"></td><td class="px-8 py-5 font-bold">{{ $tenant->name }}</td><td class="px-8 py-5">{{ $tenant->user->name }}</td><td class="px-8 py-5 text-slate-600">{{ $tenant->email ?: $tenant->user->email }}</td><td class="px-8 py-5"><span class="px-3 py-1 rounded-lg text-xs font-bold uppercase {{ $tenant->user->isSuspended() ? 'bg-rose-100 text-rose-700' : 'bg-green-100 text-green-700' }}">{{ $tenant->user->status }}</span></td><td class="px-8 py-5 text-sm text-slate-500">{{ $tenant->events->count() }}</td><td class="px-8 py-5"><a href="{{ route('superadmin.tenants.show', $tenant) }}" class="text-indigo-600 font-bold">Detail</a></td></tr>@empty<tr><td colspan="7" class="p-8 text-center text-slate-400">Belum ada Tenant.</td></tr>@endforelse</tbody>
</table></div><div class="p-6">{{ $tenants->links() }}</div></div>
@endsection
