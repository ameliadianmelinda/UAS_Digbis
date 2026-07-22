<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">
    <div class="min-h-screen flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-xl bg-white rounded-4xl shadow-xl border border-slate-100 p-8">
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold mb-2">Daftar Akun Baru</h1>
                <p class="text-slate-500">Buat akun buyer untuk pesan tiket dengan mudah.</p>
            </div>

            @if($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    <ul class="space-y-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST" class="space-y-5">
                @csrf
                <label class="block">
                    <span class="text-sm font-semibold text-slate-700">Nama Lengkap</span>
                    <input type="text" name="name" value="{{ old('name') }}" class="mt-2 w-full rounded-3xl border border-slate-200 px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500 outline-none" required>
                </label>
                <label class="block">
                    <span class="text-sm font-semibold text-slate-700">Email</span>
                    <input type="email" name="email" value="{{ old('email') }}" class="mt-2 w-full rounded-3xl border border-slate-200 px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500 outline-none" required>
                </label>
                <label class="block">
                    <span class="text-sm font-semibold text-slate-700">Password</span>
                    <input type="password" name="password" class="mt-2 w-full rounded-3xl border border-slate-200 px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500 outline-none" required>
                </label>
                <label class="block">
                    <span class="text-sm font-semibold text-slate-700">Konfirmasi Password</span>
                    <input type="password" name="password_confirmation" class="mt-2 w-full rounded-3xl border border-slate-200 px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500 outline-none" required>
                </label>
                <button type="submit" class="w-full rounded-3xl bg-indigo-600 text-white py-3 text-lg font-bold hover:bg-indigo-700 transition">Daftar Sekarang</button>
            </form>

            <div class="mt-6 text-center text-sm text-slate-500">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-indigo-600 font-semibold">Masuk di sini</a>
            </div>
        </div>
    </div>
</body>
</html>
