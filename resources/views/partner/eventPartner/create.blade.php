@extends('layouts.partner')

@section('content')
@php
    $categories = $categories ?? collect([]);
    $old = $old ?? [];
@endphp

<div class="space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-black tracking-tight text-slate-900 sm:text-4xl">Tambah Event</h1>
            <p class="mt-2 text-sm text-slate-500">Isi detail event secara lengkap agar siap dipublikasikan.</p>
        </div>

        <a href="{{ url('/partner/events') }}" class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('partner.events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="createEventForm">
        @csrf

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 p-5 sm:p-6">
                <div class="flex items-center gap-2">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">Informasi Event</h2>
                        <p class="text-sm text-slate-500">Semua kolom wajib diisi.</p>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 p-5 sm:p-6 md:grid-cols-2">
                <div class="space-y-2 md:col-span-2">
                    <label for="name" class="text-sm font-semibold text-slate-700">Nama Event <span class="text-rose-500">*</span></label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name', $old['name'] ?? '') }}"
                        placeholder="Masukkan nama event"
                        required
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700 shadow-sm outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-100"
                    >
                </div>

                <div class="space-y-2">
                    <label for="category" class="text-sm font-semibold text-slate-700">Kategori <span class="text-rose-500">*</span></label>
                    <select
                        id="category"
                        name="category"
                        required
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700 shadow-sm outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-100"
                    >
                        <option value="">Pilih kategori</option>
                        @foreach ($categories as $category)
                            @php
                                $value = $category['value'] ?? $category['name'] ?? '';
                                $label = $category['label'] ?? $category['name'] ?? '';
                            @endphp
                            <option value="{{ $value }}" {{ old('category', $old['category'] ?? '') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label for="event_datetime" class="text-sm font-semibold text-slate-700">Tanggal & Waktu Event <span class="text-rose-500">*</span></label>
                    <input
                        id="event_datetime"
                        name="event_datetime"
                        type="datetime-local"
                        value="{{ old('event_datetime', $old['event_datetime'] ?? '') }}"
                        required
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700 shadow-sm outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-100"
                    >
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label for="location" class="text-sm font-semibold text-slate-700">Lokasi <span class="text-rose-500">*</span></label>
                    <input
                        id="location"
                        name="location"
                        type="text"
                        value="{{ old('location', $old['location'] ?? '') }}"
                        placeholder="Contoh: Jakarta Convention Center"
                        required
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700 shadow-sm outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-100"
                    >
                </div>

                <div class="space-y-2">
                    <label for="ticket_price" class="text-sm font-semibold text-slate-700">Harga Tiket <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400">Rp</span>
                        <input
                            id="ticket_price"
                            name="ticket_price"
                            type="number"
                            min="0"
                            step="1000"
                            value="{{ old('ticket_price', $old['ticket_price'] ?? '') }}"
                            placeholder="0"
                            required
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-3 py-2.5 text-sm text-slate-700 shadow-sm outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-100"
                        >
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="ticket_quantity" class="text-sm font-semibold text-slate-700">Jumlah Tiket <span class="text-rose-500">*</span></label>
                    <input
                        id="ticket_quantity"
                        name="ticket_quantity"
                        type="number"
                        min="1"
                        value="{{ old('ticket_quantity', $old['ticket_quantity'] ?? '') }}"
                        placeholder="100"
                        required
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700 shadow-sm outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-100"
                    >
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label for="description" class="text-sm font-semibold text-slate-700">Deskripsi <span class="text-rose-500">*</span></label>
                    <textarea
                        id="description"
                        name="description"
                        rows="5"
                        placeholder="Jelaskan secara singkat tentang event Anda"
                        required
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700 shadow-sm outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-100"
                    >{{ old('description', $old['description'] ?? '') }}</textarea>
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label for="poster" class="text-sm font-semibold text-slate-700">Upload Poster <span class="text-rose-500">*</span></label>
                    <div id="posterDropZone" class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-4 transition hover:border-indigo-400 hover:bg-indigo-50/40">
                        <label for="poster" class="flex cursor-pointer flex-col items-center justify-center rounded-2xl border border-dashed border-slate-200 bg-white px-6 py-10 text-center">
                            <svg class="h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 16a4 4 0 01-.88-7.9A5.5 5.5 0 0117.5 7H18a4 4 0 012 7.6M9 12l3-3m0 0l3 3m-3-3v8"></path>
                            </svg>
                            <p class="mt-4 text-sm font-semibold text-slate-700">Seret dan lepas poster di sini, atau klik untuk memilih file</p>
                            <p class="mt-1 text-sm text-slate-500">PNG, JPG, atau WebP hingga 5MB</p>
                            <input id="poster" name="poster" type="file" accept="image/*" required class="hidden">
                        </label>

                        <div id="posterPreview" class="mt-4 hidden rounded-2xl border border-slate-200 bg-white p-3">
                            <img id="posterPreviewImage" src="" alt="Preview poster" class="h-56 w-full rounded-xl object-cover">
                            <div class="mt-3 flex items-center justify-between gap-3">
                                <p id="posterFileName" class="truncate text-sm font-medium text-slate-600"></p>
                                <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">Preview</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50/60 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                <a href="{{ url('/partner/events') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                    Simpan Event
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    const posterInput = document.getElementById('poster');
    const posterPreview = document.getElementById('posterPreview');
    const posterPreviewImage = document.getElementById('posterPreviewImage');
    const posterFileName = document.getElementById('posterFileName');
    const posterDropZone = document.getElementById('posterDropZone');

    const showPosterPreview = (file) => {
        if (!file || !file.type.startsWith('image/')) return;

        const reader = new FileReader();
        reader.onload = (event) => {
            posterPreviewImage.src = event.target.result;
            posterFileName.textContent = file.name;
            posterPreview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    };

    if (posterInput) {
        posterInput.addEventListener('change', (event) => {
            const [file] = event.target.files || [];
            showPosterPreview(file);
        });
    }

    if (posterDropZone && posterInput) {
        ['dragenter', 'dragover'].forEach((eventName) => {
            posterDropZone.addEventListener(eventName, (event) => {
                event.preventDefault();
                posterDropZone.classList.add('border-indigo-400', 'bg-indigo-50/40');
            });
        });

        ['dragleave', 'drop'].forEach((eventName) => {
            posterDropZone.addEventListener(eventName, (event) => {
                event.preventDefault();
                posterDropZone.classList.remove('border-indigo-400', 'bg-indigo-50/40');
            });
        });

        posterDropZone.addEventListener('drop', (event) => {
            const [file] = event.dataTransfer.files || [];
            if (file) {
                showPosterPreview(file);
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                posterInput.files = dataTransfer.files;
            }
        });
    }
</script>
@endsection
