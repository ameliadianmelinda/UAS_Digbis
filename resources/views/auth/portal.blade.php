<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#F8FAFC] text-slate-900 min-h-screen flex items-center justify-center py-5 px-4">
    <div class="w-full max-w-4xl bg-white rounded-[28px] shadow-[0_24px_48px_rgba(15,23,42,0.08)] overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-2 items-stretch">
            <!-- Left Side - Branding -->
            <div class="hidden lg:flex items-center justify-center p-7">
                <div class="max-w-xl">
                    <span class="inline-flex rounded-full bg-[#EEF2FF] px-4 py-1.5 text-sm font-semibold text-[#4F46E5]">AmikomEventHub</span>
                    <h1 class="mt-4 text-3xl font-black tracking-tight text-slate-900 leading-tight">Semua Kebutuhan Event<br><span class="text-[#4F46E5]">Dalam Satu Platform.</span></h1>
                    <div class="mt-5 border-t border-slate-200"></div>
                    <p class="mt-3 text-base leading-7 text-slate-600">Nikmati pengalaman menemukan event, membeli tiket, dan mengelola acara melalui satu platform yang modern dan mudah digunakan.</p>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="p-5 lg:border-l lg:border-slate-200">
                <div class="mx-auto max-w-md space-y-4">
                    <!-- Header -->
                    <div class="text-center">
                        <h2 class="text-2xl font-black text-slate-900">Selamat Datang</h2>
                        <p class="mt-2 text-sm text-slate-500">Masuk ke akun Anda atau buat yang baru dengan cepat.</p>
                    </div>

                    @if(session('success'))
                        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Tabs -->
                    <div class="flex justify-center gap-6 border-b border-slate-200 pb-3">
                        <button type="button" data-tab-button="masuk" class="tab-button px-4 pb-3 font-bold text-slate-900 border-b-2 border-indigo-600 transition">
                            Masuk
                        </button>
                        <button type="button" data-tab-button="daftar" class="tab-button px-4 pb-3 font-semibold text-slate-500 border-b-2 border-transparent transition hover:text-slate-900">
                            Daftar
                        </button>
                    </div>

                    <div data-tab-panel="masuk" class="space-y-4">
                        <form action="{{ route('login.post') }}" method="POST" class="space-y-3">
                            @csrf
                            <label class="block">
                                <span class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Email</span>
                                <input type="email" name="email" value="{{ old('email') }}" class="mt-2 w-full rounded-[16px] border border-slate-200 bg-slate-50 px-4 py-3 text-base outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" required>
                            </label>
                            <label class="block">
                                <span class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Password</span>
                                <input type="password" name="password" class="mt-2 w-full rounded-[16px] border border-slate-200 bg-slate-50 px-4 py-3 text-base outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" required>
                            </label>
                            <button type="submit" class="w-full rounded-[16px] bg-indigo-600 text-white px-5 py-3 text-base font-semibold shadow-lg shadow-indigo-200/50 hover:bg-indigo-700 transition">Masuk</button>
                        </form>

                        @if($errors->any())
                            <div class="bg-red-100 text-red-600 p-4 rounded-[16px] font-semibold text-sm">
                                @foreach($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <div class="relative text-center text-sm text-slate-500">
                            <span class="relative z-10 bg-white px-3">atau masuk dengan</span>
                            <div class="absolute inset-x-0 top-1/2 h-px bg-slate-200"></div>
                        </div>

                        <a href="{{ route('auth.google.redirect') }}" class="w-full inline-flex items-center justify-center gap-3 rounded-[16px] border border-slate-200 bg-slate-50 px-5 py-4 text-base font-semibold text-slate-900 transition hover:border-indigo-300 hover:bg-indigo-50">
                            <svg class="w-5 h-5" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                            Masuk dengan Google
                        </a>

                        <div class="mt-6 text-center text-sm text-gray-500">
                            <span>Kamu penyelenggara event? </span>
                            <a href="{{ route('partner.login') }}" class="font-semibold text-[#4F46E5] underline transition duration-200 hover:text-[#4338CA] hover:cursor-pointer">Masuk di sini</a>
                        </div>
                    </div>

                <!-- Tab Daftar -->
                <div data-tab-panel="daftar" class="space-y-4 hidden">
                    <a href="{{ route('register') }}" class="flex items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-base font-semibold text-slate-900 transition hover:bg-slate-100">
                        <div class="flex items-center gap-3">
                            <span class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100 text-indigo-600 text-xl font-bold">@</span>
                            <div class="text-left">
                                <div class="text-sm font-bold">Daftar dengan Email</div>
                                <p class="text-xs text-slate-500">Buat akun buyer baru</p>
                            </div>
                        </div>
                        <span class="text-indigo-600">→</span>
                    </a>

                    <a href="{{ route('auth.google.redirect') }}" class="flex items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-base font-semibold text-slate-900 transition hover:bg-slate-100">
                        <div class="flex items-center gap-3">
                            <svg class="w-10 h-10" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                            <div class="text-left">
                                <div class="text-sm font-bold">Daftar dengan Google</div>
                                <p class="text-xs text-slate-500">Registrasi instan</p>
                            </div>
                        </div>
                        <span class="text-indigo-600">→</span>
                    </a>

                    <a href="{{ route('partner.register') }}" class="flex items-center justify-between gap-3 rounded-2xl border border-indigo-300 bg-indigo-50 px-5 py-4 text-base font-semibold text-indigo-700 transition hover:bg-indigo-100">
                        <div class="flex items-center gap-3">
                            <span class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-200 text-indigo-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.657 0 3-1.567 3-3.5S13.657 4 12 4 9 5.567 9 7.5 10.343 11 12 11z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 20a7 7 0 0114 0"/>
                                </svg>
                            </span>
                            <div class="text-left">
                                <div class="text-sm font-bold">Daftar sebagai Event Partner</div>
                                <p class="text-xs text-slate-500">Kelola event & tiket</p>
                            </div>
                        </div>
                        <span class="text-indigo-600">→</span>
                    </a>
                </div>
        </div>
    </div>

    <script>
        const tabButtons = document.querySelectorAll('[data-tab-button]');
        const tabPanels = document.querySelectorAll('[data-tab-panel]');

        function activateTab(name) {
            tabButtons.forEach((button) => {
                const active = button.getAttribute('data-tab-button') === name;
                button.classList.toggle('border-indigo-600', active);
                button.classList.toggle('text-slate-900', active);
                button.classList.toggle('font-bold', active);
                button.classList.toggle('border-transparent', !active);
                button.classList.toggle('text-slate-500', !active);
                button.classList.toggle('font-semibold', !active);
            });

            tabPanels.forEach((panel) => {
                panel.classList.toggle('hidden', panel.getAttribute('data-tab-panel') !== name);
            });
        }

        function getQueryParam(name) {
            return new URLSearchParams(window.location.search).get(name);
        }

        tabButtons.forEach((button) => {
            button.addEventListener('click', () => {
                activateTab(button.getAttribute('data-tab-button'));
            });
        });

        const initialTab = getQueryParam('tab') === 'daftar' ? 'daftar' : 'masuk';
        activateTab(initialTab);
    </script>
</body>
</html>
