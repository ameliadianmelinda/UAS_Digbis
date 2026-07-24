@extends('layouts.partner')

@section('content')
@php
    $profile = $profile ?? [];
@endphp

<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-black tracking-tight text-slate-900 sm:text-4xl">Profil Organisasi</h1>
        <p class="mt-2 text-sm text-slate-500">Kelola informasi akun organisasi Anda secara aman dan tetap fokus pada tampilan frontend.</p>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="grid gap-6 p-5 sm:p-6 lg:grid-cols-2">
            <div class="space-y-6">
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700">Logo Organisasi</label>
                    <div class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4 sm:flex-row sm:items-center">
                        <div class="h-28 w-28 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                            @if (!empty(data_get($profile, 'logo')))
                                <img src="{{ data_get($profile, 'logo') }}" alt="Logo Organisasi" class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-linear-to-br from-indigo-100 to-slate-100 text-slate-400">
                                    <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-col gap-2">
                            <button type="button" class="inline-flex items-center justify-center rounded-xl bg-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition hover:bg-slate-300" disabled>
                                Upload Logo
                            </button>
                            <p class="text-xs text-slate-500">Logo organisasi tidak dapat diubah saat ini.</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="org_name" class="text-sm font-semibold text-slate-700">Nama Organisasi</label>
                    <input type="text" value="{{ data_get($profile, 'org_name', 'Amikom Event Hub Partner') }}" readonly class="w-full rounded-xl border border-slate-200 bg-slate-100 px-3 py-2.5 text-sm text-slate-500 shadow-sm outline-none">
                    <p class="text-xs text-slate-500">Nama organisasi tidak dapat diubah saat ini.</p>
                </div>

                <div class="space-y-2">
                    <label for="email" class="text-sm font-semibold text-slate-700">Email <span class="text-slate-400">(read-only)</span></label>
                    <input type="email" value="{{ data_get($profile, 'org_email', 'partner@amikomeventhub.com') }}" readonly class="w-full rounded-xl border border-slate-200 bg-slate-100 px-3 py-2.5 text-sm text-slate-500 shadow-sm outline-none">
                    <p class="text-xs text-slate-500">Email hanya ditampilkan sebagai informasi akun.</p>
                </div>

                <div class="space-y-2">
                    <label for="password" class="text-sm font-semibold text-slate-700">Password Baru <span class="text-slate-400">(opsional)</span></label>
                    <input type="password" placeholder="Kosongkan bila tidak ingin mengubah password" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700 shadow-sm outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-100">
                </div>

                <div class="space-y-2">
                    <label for="password_confirmation" class="text-sm font-semibold text-slate-700">Konfirmasi Password Baru <span class="text-slate-400">(opsional)</span></label>
                    <input type="password" placeholder="Ulangi password baru" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700 shadow-sm outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-100">
                </div>
            </div>

            <div class="space-y-6">
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700">Preview Data</label>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                        <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                            <span class="font-semibold text-slate-800">Status Akun</span>
                            <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">Aktif</span>
                        </div>
                        <div class="mt-3 space-y-2">
                            <p><span class="font-semibold text-slate-800">Organisasi:</span> Amikom Event Hub Partner</p>
                            <p><span class="font-semibold text-slate-800">Kontak:</span> partner@amikomeventhub.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50/60 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
            <button type="button" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                Batal
            </button>
            <button type="button" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                Simpan Perubahan
            </button>
        </div>
    </div>
</div>
@endsection
