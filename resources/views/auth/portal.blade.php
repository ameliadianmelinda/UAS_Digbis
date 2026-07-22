<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
    <main class="min-h-screen flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-6xl overflow-hidden rounded-[2.5rem] bg-white shadow-[0_40px_120px_rgba(15,23,42,0.12)] border border-slate-200 grid lg:grid-cols-2">
            <section class="relative hidden lg:flex p-14 bg-gradient-to-br from-indigo-700 via-sky-600 to-cyan-500 text-white overflow-hidden">
                <div class="absolute inset-0 opacity-30 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.4),_transparent_45%)]"></div>
                <div class="absolute -top-16 -right-16 h-56 w-56 rounded-full bg-white/10 blur-2xl"></div>
                <div class="absolute -bottom-16 -left-16 h-72 w-72 rounded-full bg-white/10 blur-2xl"></div>

                <div class="relative max-w-lg mx-auto space-y-10">
                    <div class="inline-flex items-center gap-3 rounded-full bg-white/10 px-5 py-3 backdrop-blur-xl border border-white/20">
                        <div class="w-10 h-10 rounded-full bg-white text-indigo-700 flex items-center justify-center font-black">AH</div>
                        <span class="text-base font-semibold uppercase tracking-[0.18em]">AmikomEventHub</span>
                    </div>

                    <div class="space-y-6">
                        <p class="text-sm uppercase tracking-[0.35em] text-slate-200">Ticketing Platform</p>
                        <h1 class="text-5xl font-extrabold leading-tight">
                            Temukan event apa saja di<br><span class="text-white">AmikomEventHub</span>
                        </h1>
                        <p class="text-lg leading-relaxed text-slate-100/90">
                            Pesan tiket lebih cepat dengan AmikomEventHub.
                        </p>
                    </div>
                </div>
            </section>

            <section class="p-6 sm:p-10 lg:p-14 bg-white">
                <div class="max-w-md mx-auto space-y-8">
                    <div class="rounded-[2rem] border border-slate-200 bg-slate-50 p-6 shadow-sm">
                        <div class="grid grid-cols-2 gap-2 rounded-2xl bg-slate-100 p-1.5 mb-6">
                            <button type="button" data-tab-button="masuk" class="tab-button rounded-2xl py-4 text-sm font-bold text-slate-900 bg-white shadow-sm transition">
                                Masuk
                            </button>
                            <button type="button" data-tab-button="daftar" class="tab-button rounded-2xl py-4 text-sm font-semibold text-slate-500 transition">
                                Daftar
                            </button>
                        </div>

                        @if(session('success'))
                        <div class="mb-5 rounded-3xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-5 rounded-3xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div data-tab-panel="masuk" class="space-y-6">
                            <a href="{{ route('auth.google.redirect') }}" class="flex items-center justify-center gap-4 rounded-3xl border border-slate-200 bg-white px-5 py-4 text-base font-semibold text-slate-900 transition hover:border-indigo-300 hover:bg-indigo-50 shadow-sm">
                                <span class="flex h-11 w-11 items-center justify-center rounded-full bg-slate-100 text-2xl font-black text-slate-700">G</span>
                                Masuk dengan Google
                            </a>

                            <div class="relative text-center text-sm text-slate-500">
                                <span class="relative z-10 bg-slate-50 px-3">atau masuk dengan email</span>
                                <div class="absolute inset-x-0 top-1/2 h-px bg-slate-200"></div>
                            </div>

                            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                                @csrf
                                <label class="block">
                                    <span class="text-sm font-semibold text-slate-700">Email</span>
                                    <input type="email" name="email" value="{{ old('email') }}" class="mt-3 w-full rounded-3xl border border-slate-200 bg-white px-4 py-3 text-base outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" required>
                                </label>
                                <label class="block">
                                    <span class="text-sm font-semibold text-slate-700">Password</span>
                                    <input type="password" name="password" class="mt-3 w-full rounded-3xl border border-slate-200 bg-white px-4 py-3 text-base outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" required>
                                </label>
                                <button type="submit" class="w-full rounded-3xl bg-indigo-600 text-white px-5 py-4 text-base font-semibold shadow-lg shadow-indigo-200/40 hover:bg-indigo-700 transition">Masuk</button>
                            </form>
                        </div>

                        <div data-tab-panel="daftar" class="space-y-4 hidden">
                            <a href="{{ route('register') }}" class="flex items-center justify-between gap-4 rounded-3xl border border-slate-200 bg-white px-6 py-4 text-base font-semibold text-slate-900 transition hover:border-indigo-300 hover:bg-slate-50 shadow-sm">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-11 w-11 items-center justify-center rounded-full bg-slate-100 text-indigo-600 text-2xl font-black shadow-sm">@</span>
                                    <div class="text-left">
                                        <div class="text-base font-bold">Daftar dengan Email</div>
                                        <p class="text-sm text-slate-500">Buat akun buyer menggunakan email dan password.</p>
                                    </div>
                                </div>
                                <span class="text-indigo-600">→</span>
                            </a>

                            <a href="{{ route('auth.google.redirect') }}" class="flex items-center justify-between gap-4 rounded-3xl border border-indigo-100 bg-indigo-50 px-6 py-4 text-base font-semibold text-slate-900 transition hover:border-indigo-200 hover:bg-indigo-100 shadow-sm">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-11 w-11 items-center justify-center rounded-full bg-white text-2xl font-black text-slate-800 shadow-sm">G</span>
                                    <div class="text-left">
                                        <div class="text-base font-bold">Daftar dengan Google</div>
                                        <p class="text-sm text-slate-500">Registrasi cepat tanpa mengisi formulir panjang.</p>
                                    </div>
                                </div>
                                <span class="text-indigo-600">→</span>
                            </a>

                            <a href="{{ route('partner.login') }}" class="flex items-center justify-between gap-4 rounded-3xl border border-slate-200 bg-white px-6 py-4 text-base font-semibold text-slate-900 transition hover:border-indigo-300 hover:bg-slate-50 shadow-sm">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-11 w-11 items-center justify-center rounded-full bg-slate-100 text-slate-700 shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.657 0 3-1.567 3-3.5S13.657 4 12 4 9 5.567 9 7.5 10.343 11 12 11z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 20a7 7 0 0114 0"/>
                                        </svg>
                                    </span>
                                    <div class="text-left">
                                        <div class="text-base font-bold">Daftar sebagai Event Partner</div>
                                        <p class="text-sm text-slate-500">Kelola event dan tiket langsung.</p>
                                    </div>
                                </div>
                                <span class="text-indigo-600">→</span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <script>
        const tabButtons = document.querySelectorAll('[data-tab-button]');
        const tabPanels = document.querySelectorAll('[data-tab-panel]');

        function activateTab(name) {
            tabButtons.forEach((button) => {
                const active = button.getAttribute('data-tab-button') === name;
                button.classList.toggle('bg-white', active);
                button.classList.toggle('shadow-sm', active);
                button.classList.toggle('text-slate-900', active);
                button.classList.toggle('font-bold', active);
                button.classList.toggle('text-slate-500', !active);
                button.classList.toggle('font-semibold', !active);
            });

            tabPanels.forEach((panel) => {
                panel.classList.toggle('hidden', panel.getAttribute('data-tab-panel') !== name);
            });
        }

        tabButtons.forEach((button) => {
            button.addEventListener('click', () => {
                activateTab(button.getAttribute('data-tab-button'));
            });
        });

        activateTab('masuk');
    </script>
</body>
</html>
