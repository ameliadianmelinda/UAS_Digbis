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
<body class="bg-[#F8FAFC] text-slate-900 min-h-screen flex items-center justify-center py-5 px-4">
    <div class="w-full max-w-4xl bg-white rounded-[28px] shadow-[0_24px_48px_rgba(15,23,42,0.08)] overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-2 items-stretch">
            <!-- Left Side - Branding -->
            <div class="hidden lg:flex items-center justify-center p-7 bg-slate-50">
                <div class="max-w-xl">
                    <span class="inline-flex rounded-full bg-[#EEF2FF] px-4 py-1.5 text-sm font-semibold text-[#4F46E5]">AmikomEventHub</span>
                    <h1 class="mt-4 text-3xl font-black tracking-tight text-slate-900 leading-tight">Kelola Event Partnermu<br><span class="text-[#4F46E5]">Semua dalam Satu Dashboard.</span></h1>
                    <div class="mt-5 border-t border-slate-200"></div>
                    <p class="mt-3 text-base leading-7 text-slate-600">Akses data event, tiket, dan transaksi dengan cepat lewat portal yang dirancang khusus untuk event partner.</p>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="p-5 lg:border-l lg:border-slate-200">
                <div class="mx-auto max-w-md space-y-4">
                    <div class="text-center">
                        <h2 class="text-2xl font-black text-slate-900">Portal Event Partner</h2>
                        <p class="mt-2 text-sm text-slate-500">Masuk ke akun Anda untuk mengelola event dengan mudah.</p>
                    </div>

                    @if(session('error'))
                        <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-red-100 text-red-600 p-4 rounded-[16px] font-semibold text-sm">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('partner.login.post') }}" method="POST" class="space-y-3">
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

                    <div class="mt-6 text-center text-sm text-slate-500">
                        <span>Belum memiliki akun? </span>
                        <a href="{{ route('partner.register') }}" class="font-semibold text-[#4F46E5] underline transition duration-200 hover:text-[#4338CA]">Daftar sekarang!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
