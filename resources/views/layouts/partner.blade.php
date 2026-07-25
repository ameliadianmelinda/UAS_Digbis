<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Partner Dashboard - AmikomEventHub')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 flex min-h-screen">
    <aside class="w-72 bg-indigo-900 text-indigo-100 flex flex-col p-6 space-y-8 sticky top-0 h-screen">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-white text-indigo-900 font-black text-lg flex items-center justify-center">PH</div>
            <div>
                <p class="font-black text-lg text-white">Partner Hub</p>
                <p class="text-sm text-indigo-300">Panel Organizer</p>
            </div>
        </div>

        <nav class="flex-1 space-y-2 overflow-y-auto">
            <a href="{{ route('partner.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('partner.dashboard') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800/70' }} transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3V13h4v8h3a1 1 0 001-1V10"></path></svg>
                <span class="font-semibold">Dashboard</span>
            </a>

            <a href="{{ route('partner.events.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('partner.events.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800/70' }} transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span class="font-semibold">Kelola Event</span>
            </a>

            <a href="{{ route('partner.transactions.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('partner.transactions.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800/70' }} transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-semibold">Transaksi</span>
            </a>

            <a href="{{ route('partner.ratings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('partner.ratings.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800/70' }} transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2m-1 4v10m-6 0h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <span class="font-semibold">Rating & Review</span>
            </a>

            <a href="{{ route('partner.profile.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('partner.profile.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800/70' }} transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 21V9m7 12V5m7 16V3"></path></svg>
                <span class="font-semibold">Profil Organisasi</span>
            </a>
        </nav>

        <div class="space-y-2 border-t border-indigo-800 pt-6">
            <form action="{{ route('partner.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-indigo-300 hover:bg-indigo-800/70 hover:text-white transition text-left">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span class="font-semibold">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-8 lg:p-10 overflow-y-auto w-full">
        @yield('content')
    </main>
    @stack('scripts')
</body>
</html>
