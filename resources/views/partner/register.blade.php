<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Partner Registration - AmikomEventHub</title>
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
                    <h1 class="text-5xl font-black text-slate-900 mb-3">Mulai Bisnis</h1>
                    <p class="text-lg text-slate-600">Jadilah Event Partner kami dan berkembang bersama</p>
                </div>
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-100 text-amber-600 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900">Teknologi Terdepan</h3>
                            <p class="text-slate-600 text-sm">Platform dengan fitur manajemen event terlengkap</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-cyan-100 text-cyan-600 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900">Komisi Kompetitif</h3>
                            <p class="text-slate-600 text-sm">Sistem komisi yang transparan dan menguntungkan</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-100 text-rose-600 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5-4a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900">Support Profesional</h3>
                            <p class="text-slate-600 text-sm">Tim dedicated siap mendampingi kesuksesan Anda</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="bg-white rounded-3xl p-8 shadow-lg max-h-[90vh] overflow-y-auto">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-black text-slate-900 mb-2">Daftar Event Partner</h2>
                    <p class="text-slate-500">Bergabunglah dengan ribuan event organizer</p>
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

                <form action="{{ route('partner.register.post') }}" method="POST" class="space-y-4">
                    @csrf
                    <label class="block">
                        <span class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Nama Organisasi</span>
                        <input type="text" name="nama_organisasi" value="{{ old('nama_organisasi') }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" placeholder="PT. Organisasi Anda" required>
                    </label>

                    <label class="block">
                        <span class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Nama PIC</span>
                        <input type="text" name="nama_pic" value="{{ old('nama_pic') }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" placeholder="Nama Lengkap Anda" required>
                    </label>

                    <label class="block">
                        <span class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Email</span>
                        <input type="email" name="email" value="{{ old('email') }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" placeholder="email@organisasi.com" required>
                    </label>

                    <label class="block">
                        <span class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Nomor HP</span>
                        <input type="tel" name="phone" value="{{ old('phone') }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" placeholder="08xxxxxxxxx" required>
                    </label>

                    <label class="block">
                        <span class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Password</span>
                        <input type="password" name="password" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" placeholder="Min. 8 karakter" required>
                    </label>

                    <label class="block">
                        <span class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Konfirmasi Password</span>
                        <input type="password" name="password_confirmation" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" placeholder="Ulangi password" required>
                    </label>

                    <button type="submit" class="w-full rounded-2xl bg-indigo-600 text-white px-5 py-3 text-base font-semibold shadow-lg shadow-indigo-200/50 hover:bg-indigo-700 transition mt-6">Daftar sebagai Event Partner</button>
                </form>

                <div class="mt-6 text-center text-sm text-slate-500 border-t border-slate-200 pt-6">
                    <p class="mb-2">Sudah memiliki akun?</p>
                    <a href="{{ route('partner.login') }}" class="font-semibold text-indigo-600 hover:text-indigo-700 transition">Masuk sebagai Event Partner</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
