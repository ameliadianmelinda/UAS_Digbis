<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Super Admin - AmikomEventHub')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-900 flex min-h-screen">
    <aside class="w-64 bg-indigo-900 text-indigo-100 flex flex-col p-6 space-y-8 sticky top-0 h-screen">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-indigo-900 font-bold text-xl">AH</div>
            <span class="text-xl font-bold text-white tracking-tight">AmikomEventHub</span>
        </div>
        <nav class="flex-1 space-y-2 overflow-y-auto">
            <p class="text-[10px] font-bold uppercase tracking-widest text-indigo-400 mb-4 px-2">Super Admin</p>
            @php($menus = [
                ['route' => 'superadmin.dashboard', 'label' => 'Dashboard', 'icon' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z'],
                ['route' => 'superadmin.users.*', 'label' => 'Kelola User', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0'],
                ['route' => 'superadmin.tenants.*', 'label' => 'Kelola Tenant', 'icon' => 'M3 7l9-4 9 4v10l-9 4-9-4V7zm9-4v18M3 7l9 4 9-4'],
                ['route' => 'superadmin.events.*', 'label' => 'Kelola Event', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ['route' => 'superadmin.categories.*', 'label' => 'Kelola Kategori', 'icon' => 'M4 4h16v16H4zM8 12h8'],
                ['route' => 'superadmin.transactions.*', 'label' => 'Laporan Transaksi', 'icon' => 'M9 19V6a2 2 0 012-2h2a2 2 0 012 2v13M5 19v-7a2 2 0 012-2h2M19 19v-4a2 2 0 00-2-2h-2'],
            ])
            @foreach($menus as $menu)
            <a href="{{ route(str_ends_with($menu['route'], '.*') ? str_replace('.*', '.index', $menu['route']) : $menu['route']) }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs($menu['route']) ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">
                <svg class="w-5 h-5 {{ request()->routeIs($menu['route']) ? 'text-indigo-300' : 'text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $menu['icon'] }}"></path></svg>
                {{ $menu['label'] }}
            </a>
            @endforeach
        </nav>
        <div class="space-y-2 pt-6 border-t border-indigo-800">
            <a href="{{ route('superadmin.profile.edit') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('superadmin.profile.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">Profil Super Admin</a>
            <form action="{{ route('superadmin.logout') }}" method="POST">@csrf<button class="w-full flex items-center gap-3 px-4 py-3 text-indigo-300 hover:text-white transition font-medium text-left">Logout</button></form>
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