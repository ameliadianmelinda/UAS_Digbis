<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partner Login - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="min-h-screen bg-slate-50 flex items-center justify-center p-6">
    <div class="w-full max-w-5xl grid lg:grid-cols-2 overflow-hidden rounded-[2rem] bg-white shadow-[0_28px_90px_rgba(15,23,42,0.10)] border border-slate-100">
        <section class="p-10 lg:p-14 bg-indigo-900 text-white flex items-center">
            <div class="max-w-xl mx-auto">
                <div class="inline-flex items-center gap-3 rounded-full bg-white/10 px-5 py-3 mb-8">
                    <div class="w-9 h-9 rounded-xl bg-white text-indigo-900 flex items-center justify-center font-black">AH</div>
                    <span class="font-extrabold">AmikomEventHub</span>
                </div>
                <p class="text-sm font-black tracking-[0.32em] text-indigo-200 uppercase mb-5">Event Partner Access</p>
                <h1 class="text-4xl md:text-6xl font-black leading-[1.05] mb-7">Masuk sebagai <span class="block text-indigo-200">Event Partner</span></h1>
                <p class="text-lg md:text-xl text-indigo-100 leading-relaxed max-w-lg">Kelola event, kategori, partner, dan transaksi dari dashboard penyelenggara.</p>
            </div>
        </section>

        <section class="p-6 sm:p-8 lg:p-10 bg-white">
            <div class="rounded-3xl border border-slate-100 bg-slate-50/60 p-6 sm:p-8 shadow-[0_16px_40px_rgba(15,23,42,0.04)]">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-black text-slate-900">Event Partner Login</h2>
                    <p class="text-slate-500 mt-2">Masuk untuk mengelola dashboard penyelenggara.</p>
                </div>

                @if(session('error'))
                    <div class="bg-red-100 text-red-600 p-4 rounded-xl mb-6 font-bold text-sm text-center">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('partner.login.post') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Email</label>
                        <input type="email" name="email" class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Password</label>
                        <input type="password" name="password" class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium" required>
                    </div>
                    <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-black text-xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">Masuk</button>
                </form>

                <div class="mt-6 text-center text-sm text-slate-500">
                    Bukan event partner?
                    <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-700 transition">Kembali ke portal login</a>
                </div>
            </div>
        </section>
    </div>
</body>
</html>