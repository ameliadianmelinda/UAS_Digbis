@extends('layouts.partner')

@section('content')
@php
    $profile = $profile ?? [];
@endphp

<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-black tracking-tight text-slate-900 sm:text-4xl">Profil Organisasi</h1>
        <p class="mt-2 text-sm text-slate-500">Kelola Informasi akun organisasi Anda secara aman dan tetap fokus pada tampilan frontend.</p>
    </div>

    <form action="{{ route('partner.profile.update') }}" method="POST" class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        @csrf
        @method('PUT')
        <div class="space-y-6 p-5 sm:p-6">
            @if(session('success'))
                <div class="rounded-xl bg-green-50 border border-green-100 p-3 text-sm text-green-700">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="rounded-xl bg-rose-50 border border-rose-100 p-3 text-sm text-rose-700">{{ $errors->first() }}</div>
            @endif
            <div class="space-y-2">
                <label for="org_name" class="text-sm font-semibold text-slate-700">Nama Organisasi</label>
                <input type="text" value="{{ data_get($profile, 'org_name', '-') }}" readonly class="w-full rounded-xl border border-slate-200 bg-slate-100 px-3 py-2.5 text-sm text-slate-500 shadow-sm outline-none">
                <p class="text-xs text-slate-500">Nama organisasi tidak dapat diubah.</p>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-4">
                <div class="rounded-2xl bg-indigo-50 p-4">
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-400">Rating Rata-rata</p>
                    <p class="mt-2 text-3xl font-black text-slate-900">{{ data_get($profile, 'rating', 0.0) }}</p>
                </div>
                <div class="rounded-2xl bg-slate-100 p-4">
                    <p class="text-xs uppercase tracking-[0.24em] text-slate-400">Jumlah Review</p>
                    <p class="mt-2 text-3xl font-black text-slate-900">{{ data_get($profile, 'review_count', 0) }}</p>
                </div>
            </div>

            <div class="space-y-2">
                <label for="email" class="text-sm font-semibold text-slate-700">Email</label>
                <input type="email" value="{{ data_get($profile, 'org_email', '-') }}" readonly class="w-full rounded-xl border border-slate-200 bg-slate-100 px-3 py-2.5 text-sm text-slate-500 shadow-sm outline-none">
                <p class="text-xs text-slate-500">Email tidak dapat diubah</p>
            </div>

            <div class="space-y-2">
                <label for="current_password" class="text-sm font-semibold text-slate-700">Password Lama <span class="text-slate-400">(wajib saat mengganti password)</span></label>
                <input
                    id="current_password"
                    name="current_password"
                    type="password"
                    autocomplete="current-password"
                    placeholder="Masukkan password lama untuk konfirmasi"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700 shadow-sm outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-100"
                >
                @error('current_password')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="password" class="text-sm font-semibold text-slate-700">Password Baru <span class="text-slate-400">(opsional)</span></label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    autocomplete="new-password"
                    placeholder="Kosongkan bila tidak ingin mengubah password"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700 shadow-sm outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-100"
                >
                @error('password')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="password_confirmation" class="text-sm font-semibold text-slate-700">Konfirmasi Password Baru <span class="text-slate-400">(opsional)</span></label>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    autocomplete="new-password"
                    placeholder="Ulangi password baru"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700 shadow-sm outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-100"
                >
                @error('password_confirmation')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50/60 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
            <a href="{{ route('partner.dashboard') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
