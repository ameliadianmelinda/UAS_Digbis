@extends('layouts.superadmin')

@section('title', 'Kelola User')
@section('page_title', 'Kelola User')
@section('page_subtitle', 'Kelola seluruh akun yang dapat login ke platform.')

@section('content')
<form method="GET" class="mb-4 flex gap-2">
    <input name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="flex-1 px-5 py-3 bg-white border-2 border-slate-100 rounded-2xl outline-none focus:border-indigo-600">
    <button class="px-5 py-3 bg-indigo-600 text-white rounded-2xl font-bold">Cari</button>
</form>
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-8 border-b"><h3 class="font-black text-xl">{{ number_format($users->total(), 0, ',', '.') }} Akun</h3></div>
    <div class="overflow-x-auto"><table class="w-full text-left">
        <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest"><tr><th class="px-8 py-4">Foto</th><th class="px-8 py-4">Nama</th><th class="px-8 py-4">Email</th><th class="px-8 py-4">Role</th><th class="px-8 py-4">Status</th><th class="px-8 py-4 whitespace-nowrap">Tanggal Daftar</th><th class="px-8 py-4">Aksi</th></tr></thead>
        <tbody class="divide-y">
            @forelse($users as $user)
                <tr class="hover:bg-slate-50"><td class="px-8 py-5"><div class="w-14 h-14 rounded-2xl overflow-hidden border border-slate-200 bg-slate-100 flex items-center justify-center"><img src="{{ $user->avatar ?: 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}" class="w-full h-full object-cover"></div></td><td class="px-8 py-5 min-w-[220px]"><span class="block font-bold whitespace-nowrap overflow-hidden text-ellipsis" title="{{ $user->name }}">{{ $user->name }}</span></td><td class="px-8 py-5 text-slate-600">{{ $user->email }}</td><td class="px-8 py-5"><span class="px-3 py-1 rounded-lg text-xs font-bold uppercase {{ $user->role === \App\Models\User::ROLE_SUPER_ADMIN ? 'bg-slate-100 text-slate-700' : 'bg-indigo-100 text-indigo-700' }}">{{ $user->role === \App\Models\User::ROLE_SUPER_ADMIN ? 'SUPER ADMIN' : strtoupper($user->role) }}</span></td><td class="px-8 py-1"><span class="px-3 py-1 rounded-lg text-xs font-bold uppercase {{ $user->isSuspended() ? 'bg-rose-100 text-rose-700' : 'bg-green-100 text-green-700' }}">{{ $user->status }}</span></td><td class="px-8 py-5 text-sm text-slate-500"><span class="block whitespace-nowrap overflow-hidden text-ellipsis" title="{{ $user->created_at?->format('d M Y') ?? '-' }}">{{ $user->created_at?->format('d M Y') ?? '-' }}</span></td><td class="px-8 py-5"><a href="{{ route('superadmin.users.show', $user) }}" class="text-indigo-600 font-bold">Detail</a></td></tr>
            @empty
                <tr><td colspan="7" class="p-8 text-center text-slate-400">Belum ada User.</td></tr>
            @endforelse
        </tbody>
    </table></div>
    <div class="p-6">{{ $users->links() }}</div>
</div>
@endsection
