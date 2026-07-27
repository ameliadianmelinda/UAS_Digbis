<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('assets/logo-apk2.png') }}" sizes="32x32">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#F8FAFC] text-slate-900 min-h-screen flex items-center justify-center py-5 px-4">
    <div class="w-full max-w-6xl bg-white rounded-[28px] shadow-[0_24px_48px_rgba(15,23,42,0.08)] overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-2 items-stretch">
            <div class="hidden lg:flex items-center justify-center p-7 bg-gradient-to-br from-slate-50 to-slate-100">
                <div class="max-w-xl">
                    <span class="inline-flex rounded-full bg-indigo-100 px-4 py-1.5 text-sm font-semibold text-indigo-700">AmikomEventHub</span>
                    <h1 class="mt-4 text-4xl font-black tracking-tight text-slate-900 leading-tight">Semua Kebutuhan Event<br><span class="text-[#4F46E5]">Dalam Satu Platform.</span></h1>
                    <div class="mt-5 border-t border-slate-200"></div>
                    <p class="mt-3 text-base leading-7 text-slate-600">Nikmati pengalaman menemukan event, membeli tiket, dan mengelola acara melalui satu platform yang modern dan mudah digunakan.</p>
              
                </div>
            </div>

            <div class="p-6 lg:p-10">
                <div class="mx-auto max-w-md">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-black text-slate-900">Daftar Akun Baru</h2>
                        <p class="mt-2 text-sm text-slate-500">Mulai membeli tiket event sekarang.</p>
                    </div>

                    @if($errors->any())
                        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
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
                            <input type="text" name="name" value="{{ old('name') }}" class="mt-2 w-full rounded-[16px] border border-slate-200 bg-slate-50 px-4 py-3 text-base outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" required>
                        </label>
                        <label class="block">
                            <span class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Email</span>
                            <input type="email" name="email" value="{{ old('email') }}" class="mt-2 w-full rounded-[16px] border border-slate-200 bg-slate-50 px-4 py-3 text-base outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" required>
                        </label>
                        <label class="block">
                            <span class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Password</span>
                            <input type="password" name="password" class="mt-2 w-full rounded-[16px] border border-slate-200 bg-slate-50 px-4 py-3 text-base outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" required>
                        </label>
                        <label class="block">
                            <span class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Konfirmasi Password</span>
                            <input type="password" name="password_confirmation" class="mt-2 w-full rounded-[16px] border border-slate-200 bg-slate-50 px-4 py-3 text-base outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" required>
                        </label>
                        <button type="submit" class="w-full rounded-[16px] bg-indigo-600 text-white px-5 py-4 text-base font-semibold shadow-lg shadow-indigo-200/50 hover:bg-indigo-700 transition">Daftar Sekarang</button>
                    </form>

                    <div class="mt-6 text-center text-sm text-slate-500">
                        Sudah punya akun? <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:text-indigo-700 transition">Masuk di sini</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
