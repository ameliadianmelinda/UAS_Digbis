<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#4f46e5">
    <title>@yield('title', 'Super Admin - AmikomEventHub')</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/logo-apk2.png') }}" sizes="32x32">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/logo-apk2.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('assets/logo-apk2.png') }}" sizes="180x180">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-900 flex min-h-screen">
    <aside class="w-72 bg-indigo-900 text-indigo-100 flex flex-col p-6 space-y-8 sticky top-0 h-screen">
        <div class="flex items-center gap-3">
            <img src="{{ asset('assets/logo-apk.png') }}" alt="Super Admin Hub" class="w-12 h-12 rounded-2xl object-cover">
            <div>
                <p class="font-black text-lg text-white">Super Admin Hub</p>
                <p class="text-sm text-indigo-300">Control Center</p>
            </div>
        </div>

        <nav class="flex-1 space-y-2 overflow-y-auto">
            <a href="{{ route('superadmin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('superadmin.dashboard') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800/70' }} transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3V13h4v8h3a1 1 0 001-1V10"></path></svg>
                <span class="font-semibold">Dashboard</span>
            </a>

            <a href="{{ route('superadmin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('superadmin.users.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800/70' }} transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0"></path></svg>
                <span class="font-semibold">Kelola User</span>
            </a>

            <a href="{{ route('superadmin.tenants.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('superadmin.tenants.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800/70' }} transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9-4 9 4v10l-9 4-9-4V7zm9-4v18M3 7l9 4 9-4"></path></svg>
                <span class="font-semibold">Kelola Tenant</span>
            </a>

            <a href="{{ route('superadmin.events.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('superadmin.events.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800/70' }} transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span class="font-semibold">Kelola Event</span>
            </a>

            <a href="{{ route('superadmin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('superadmin.categories.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800/70' }} transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16v16H4zM8 12h8"></path></svg>
                <span class="font-semibold">Kelola Kategori</span>
            </a>

            <a href="{{ route('superadmin.transactions.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('superadmin.transactions.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800/70' }} transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6a2 2 0 012-2h2a2 2 0 012 2v13M5 19v-7a2 2 0 012-2h2M19 19v-4a2 2 0 00-2-2h-2"></path></svg>
                <span class="font-semibold">Laporan Transaksi</span>
            </a>
        </nav>

        <div class="space-y-2 border-t border-indigo-800 pt-6">
            <form action="{{ route('superadmin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-indigo-300 hover:bg-indigo-800/70 hover:text-white transition text-left">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span class="font-semibold">Logout</span>
                </button>
            </form>
        </div>
    </aside>
    <main class="flex-1 p-10 overflow-y-auto w-full">
        <header class="flex justify-between items-center mb-10 w-full">
            <div><h1 class="text-3xl font-black">@yield('page_title', 'Dashboard')</h1><p class="text-slate-500 font-medium">@yield('page_subtitle', 'Selamat datang kembali, Super Admin!')</p></div>
            <div class="flex items-center gap-4"><div class="text-right hidden md:block"><p class="font-bold">{{ auth()->user()->name }}</p><p class="text-xs text-slate-400">Super Admin</p></div><div class="w-12 h-12 bg-white rounded-2xl shadow-sm border flex items-center justify-center p-1"><img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=6366f1&color=fff" class="rounded-xl"></div></div>
        </header>
        @if(session('success'))<div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6 font-bold text-sm">{{ session('success') }}</div>@endif
        @if($errors->any())<div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6 font-bold text-sm">{{ $errors->first() }}</div>@endif
        @yield('content')
    </main>
</body>
</html>
