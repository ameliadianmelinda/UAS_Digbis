<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Partner Login - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 text-slate-900 min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-5xl">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Side - Branding -->
            <div class="hidden lg:flex flex-col justify-center">
                <div class="mb-8">
                    <h1 class="text-5xl font-black text-slate-900 mb-3">Kelola Event</h1>
                    <p class="text-lg text-slate-600">Platform manajemen event yang terpercaya</p>
                </div>
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-600 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900">Dashboard Lengkap</h3>
                            <p class="text-slate-600 text-sm">Pantau semua event dalam satu tempat</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-600 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900">Transaksi Real-time</h3>
                            <p class="text-slate-600 text-sm">Laporan penjualan tiket secara real-time</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-600 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900">Dukungan 24/7</h3>
                            <p class="text-slate-600 text-sm">Tim support siap membantu Anda</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="bg-white rounded-3xl p-8 shadow-lg">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-black text-slate-900 mb-2">Portal Event Partner</h2>
                    <p class="text-slate-500">Masuk ke akun Anda untuk mengelola event</p>
                </div>

                @if(session('error'))
                    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('partner.login.post') }}" method="POST" class="space-y-5">
                    @csrf
                    <label class="block">
                        <span class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Email</span>
                        <input type="email" name="email" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" required>
                    </label>
                    <label class="block">
                        <span class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Password</span>
                        <input type="password" name="password" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" required>
                    </label>
                    <button type="submit" class="w-full rounded-2xl bg-indigo-600 text-white px-5 py-3 text-base font-semibold shadow-lg shadow-indigo-200/50 hover:bg-indigo-700 transition">Masuk</button>
                </form>

                <div class="mt-6 space-y-4 text-center text-sm text-slate-500">
                    <div class="border-t border-slate-200 pt-4">
                        <p class="mb-2">Belum memiliki akun?</p>
                        <a href="{{ route('partner.register') }}" class="font-semibold text-indigo-600 hover:text-indigo-700 transition">Daftar sebagai Event Partner</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>