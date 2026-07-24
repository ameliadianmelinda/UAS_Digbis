@extends('layouts.superadmin')

@section('title', 'Detail User')
@section('page_title', 'Detail User')
@section('page_subtitle', 'Informasi akun yang terdaftar di platform.')

@section('content')
<div class="max-w-3xl bg-white rounded-3xl border border-slate-100 shadow-sm p-8">
    <div class="flex items-center gap-5 mb-8"><img src="{{ $user->avatar ?: 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}" class="w-20 h-20 rounded-2xl object-cover"><div><h2 class="text-2xl font-black">{{ $user->name }}</h2><p class="text-slate-500">{{ $user->email }}</p></div></div>
    <div class="grid md:grid-cols-2 gap-4">
        <div class="p-5 bg-slate-50 rounded-2xl"><p class="text-xs uppercase font-bold text-slate-400">Foto Profil</p><p class="font-bold mt-2">{{ $user->avatar ? 'Tersedia' : 'Belum tersedia' }}</p></div>
        <div class="p-5 bg-slate-50 rounded-2xl"><p class="text-xs uppercase font-bold text-slate-400">Nama</p><p class="font-bold mt-2">{{ $user->name }}</p></div>
        <div class="p-5 bg-slate-50 rounded-2xl"><p class="text-xs uppercase font-bold text-slate-400">Email</p><p class="font-bold mt-2 break-all">{{ $user->email }}</p></div>
        <div class="p-5 bg-slate-50 rounded-2xl"><p class="text-xs uppercase font-bold text-slate-400">Role</p><p class="font-bold mt-2">{{ $user->role === \App\Models\User::ROLE_SUPER_ADMIN ? 'SUPER ADMIN' : strtoupper($user->role) }}</p></div>
        <div class="p-5 bg-slate-50 rounded-2xl"><p class="text-xs uppercase font-bold text-slate-400">Status</p><p class="font-bold mt-2">{{ $user->status }}</p></div>
        <div class="p-5 bg-slate-50 rounded-2xl"><p class="text-xs uppercase font-bold text-slate-400">Tanggal Daftar</p><p class="font-bold mt-2">{{ $user->created_at?->format('d M Y, H:i') ?? '-' }}</p></div>
    </div>
    <div class="mt-8 flex flex-wrap gap-3">
        @if($user->role === \App\Models\User::ROLE_USER)
            @if($user->isSuspended())
                <form method="POST" action="{{ route('superadmin.users.activate', $user) }}" onsubmit="return confirm('Aktifkan User ini kembali?')">@csrf<button class="px-5 py-3 rounded-2xl bg-green-600 text-white font-bold hover:bg-green-700">Aktifkan User</button></form>
            @else
                <form method="POST" action="{{ route('superadmin.users.suspend', $user) }}" onsubmit="return confirm('Suspend User ini? User tidak dapat login atau melakukan transaksi.')">@csrf<button class="px-5 py-3 rounded-2xl bg-rose-600 text-white font-bold hover:bg-rose-700">Suspend User</button></form>
            @endif
        @elseif($user->role === \App\Models\User::ROLE_TENANT && $user->partner)
            @if($user->isSuspended())
                <form method="POST" action="{{ route('superadmin.tenants.activate', $user->partner) }}" onsubmit="return confirm('Aktifkan Tenant ini kembali?')">@csrf<button class="px-5 py-3 rounded-2xl bg-green-600 text-white font-bold hover:bg-green-700">Aktifkan Tenant</button></form>
            @else
                <form method="POST" action="{{ route('superadmin.tenants.suspend', $user->partner) }}" onsubmit="return confirm('Suspend Tenant ini? Tenant tidak dapat login atau mengelola event.')">@csrf<button class="px-5 py-3 rounded-2xl bg-rose-600 text-white font-bold hover:bg-rose-700">Suspend Tenant</button></form>
            @endif
        @endif
        <a href="{{ route('superadmin.users.index') }}" class="px-5 py-3 rounded-2xl border border-slate-200 text-slate-700 font-bold hover:bg-slate-50">Kembali</a>
    </div>
</div>
@endsection
