<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - AmikomEventHub</title>
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
                    <h1 class="text-5xl font-black text-slate-900 mb-3">Bergabunglah</h1>
                    <p class="text-lg text-slate-600">dengan ribuan pembeli event di AmikomEventHub</p>
                </div>
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900">Akses Mudah</h3>
                            <p class="text-slate-600 text-sm">Daftar dalam hitungan detik</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-100 text-blue-600 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m-4 4v2m4 4v2M9 5a1 1 0 011-1h4a1 1 0 011 1v2H9V5zm0 4a1 1 0 011-1h4a1 1 0 011 1v2H9V9zm0 4a1 1 0 011-1h4a1 1 0 011 1v2H9v-2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900">Event Terbaru</h3>
                            <p class="text-slate-600 text-sm">Temukan ribuan event menarik</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-purple-100 text-purple-600 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900">Pembayaran Aman</h3>
                            <p class="text-slate-600 text-sm">Transaksi terjamin dan terpercaya</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="bg-white rounded-3xl p-8 shadow-lg">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-black text-slate-900 mb-2">Daftar Akun Baru</h2>
                    <p class="text-slate-500">Mulai membeli tiket event sekarang</p>
                </div>

                @if($errors->any())
                    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        <ul class="space-y-2">
                            @foreach($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register.post') }}" method="POST" class="space-y-5">
                    @csrf
                    <label class="block">
                        <span class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Nama Lengkap</span>
                        <input type="text" name="name" value="{{ old('name') }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" required>
                    </label>
                    <label class="block">
                        <span class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Email</span>
                        <input type="email" name="email" value="{{ old('email') }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" required>
                    </label>
                    <label class="block">
                        <span class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Password</span>
                        <input type="password" name="password" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" required>
                    </label>
                    <label class="block">
                        <span class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Konfirmasi Password</span>
                        <input type="password" name="password_confirmation" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" required>
                    </label>
                    <button type="submit" class="w-full rounded-2xl bg-indigo-600 text-white py-3 text-base font-semibold shadow-lg shadow-indigo-200/50 hover:bg-indigo-700 transition">Daftar Sekarang</button>
                </form>

                <div class="mt-6 text-center text-sm text-slate-500">
                    Sudah punya akun? <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:text-indigo-700 transition">Masuk di sini</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
