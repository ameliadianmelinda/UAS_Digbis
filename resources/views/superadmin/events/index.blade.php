@extends('layouts.superadmin')
@section('title', 'Kelola Event')
@section('page_title', 'Kelola Event')
@section('page_subtitle', 'Pantau seluruh event dari semua tenant.')

@section('content')
<form method="GET" class="mb-4 flex gap-2">
    <input name="search" value="{{ request('search') }}" placeholder="Cari nama event..." class="flex-1 px-5 py-3 bg-white border-2 border-slate-100 rounded-2xl outline-none focus:border-indigo-600">
    <button class="px-5 py-3 bg-indigo-600 text-white rounded-2xl font-bold">Cari</button>
</form>

<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-6 py-4 whitespace-nowrap">Banner</th>
                    <th class="px-6 py-4 whitespace-nowrap min-w-[240px]">Nama Event</th>
                    <th class="px-6 py-4 whitespace-nowrap min-w-[180px]">Tenant</th>
                    <th class="px-6 py-4 whitespace-nowrap min-w-[180px]">Kategori</th>
                    <th class="px-6 py-4 whitespace-nowrap">Tanggal</th>
                    <th class="px-6 py-4 whitespace-nowrap">Status</th>
                    <th class="px-6 py-4 whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($events as $event)
                    @php
                        $posterUrl = 'https://placehold.co/72x72?text=No+Banner&bg=F8FAFC&fg=94A3B8';
                        if ($event->poster_path) {
                            if (file_exists(public_path($event->poster_path))) {
                                $posterUrl = asset($event->poster_path);
                            } elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists($event->poster_path)) {
                                $posterUrl = asset('storage/' . ltrim($event->poster_path, '/'));
                            }
                        }
                    @endphp
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 align-middle whitespace-nowrap">
                            <div class="w-[72px] h-[72px] rounded-xl overflow-hidden bg-slate-100 border border-slate-200">
                                <img src="{{ $posterUrl }}" class="w-full h-full object-cover object-center" alt="Banner {{ $event->title }}">
                            </div>
                        </td>
                        <td class="px-6 py-4 font-bold whitespace-nowrap overflow-hidden text-ellipsis max-w-[260px]">{{ $event->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap overflow-hidden text-ellipsis max-w-[200px]">{{ $event->partner->name ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap overflow-hidden text-ellipsis max-w-[200px]">{{ $event->category->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-slate-500 whitespace-nowrap">{{ $event->date->format('d M Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 rounded-lg text-xs font-bold uppercase {{ ($event->status ?? 'active') === 'inactive' ? 'bg-slate-100 text-slate-600' : 'bg-green-100 text-green-700' }}">{{ $event->status ?? 'active' }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('superadmin.events.show', $event) }}" class="inline-flex items-center rounded-lg bg-indigo-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-indigo-700">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-slate-400">Belum ada event.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-6">{{ $events->links() }}</div>
</div>
@endsection
