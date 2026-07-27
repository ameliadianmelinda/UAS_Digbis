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
<body class="bg-[#F8FAFC] text-slate-900 min-h-screen flex items-center justify-center py-5 px-4">
    <div class="w-full max-w-4xl bg-white rounded-[28px] shadow-[0_24px_48px_rgba(15,23,42,0.08)] overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-2 items-stretch">
            <!-- Left Side - Branding -->
            <div class="hidden lg:flex items-center justify-center p-7 bg-slate-50">
                <div class="max-w-xl">
                    <span class="inline-flex rounded-full bg-[#EEF2FF] px-4 py-1.5 text-sm font-semibold text-[#4F46E5]">AmikomEventHub</span>
                    <h1 class="mt-4 text-3xl font-black tracking-tight text-slate-900 leading-tight">Gabung Jadi Partner<br><span class="text-[#4F46E5]">Kelola Event Lebih Mudah.</span></h1>
                    <div class="mt-5 border-t border-slate-200"></div>
                    <p class="mt-3 text-base leading-7 text-slate-600">Daftar sebagai event partner dan nikmati fitur manajemen acara, tiket, dan pendapatan dalam satu platform terpadu.</p>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="p-5 lg:border-l lg:border-slate-200">
                <div class="mx-auto max-w-md space-y-4">
                    <div class="text-center">
                        <h2 class="text-2xl font-black text-slate-900">Daftar Event Partner</h2>
                        <p class="mt-2 text-sm text-slate-500">Bergabunglah dan mulai kelola event dengan cepat.</p>
                    </div>

                    @if($errors->any())
                        <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            <ul class="space-y-2">
                                @foreach($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('partner.register.post') }}" method="POST" class="space-y-3">
                        @csrf
                        <label class="block">
                            <span class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Nama Organisasi</span>
                            <input type="text" name="nama_organisasi" value="{{ old('nama_organisasi') }}" class="mt-2 w-full rounded-[16px] border border-slate-200 bg-slate-50 px-4 py-3 text-base outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" placeholder="PT. Organisasi Anda" required>
                        </label>

                        <label class="block">
                            <span class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Nama PIC</span>
                            <input type="text" name="nama_pic" value="{{ old('nama_pic') }}" class="mt-2 w-full rounded-[16px] border border-slate-200 bg-slate-50 px-4 py-3 text-base outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" placeholder="Nama Lengkap Anda" required>
                        </label>

                        <label class="block">
                            <span class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Email</span>
                            <input type="email" name="email" value="{{ old('email') }}" class="mt-2 w-full rounded-[16px] border border-slate-200 bg-slate-50 px-4 py-3 text-base outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" placeholder="email@organisasi.com" required>
                        </label>

                        <label class="block">
                            <span class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Nomor HP</span>
                            <input type="tel" name="phone" value="{{ old('phone') }}" class="mt-2 w-full rounded-[16px] border border-slate-200 bg-slate-50 px-4 py-3 text-base outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" placeholder="08xxxxxxxxx" required>
                        </label>

                        <label class="block">
                            <span class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Password</span>
                            <input type="password" name="password" class="mt-2 w-full rounded-[16px] border border-slate-200 bg-slate-50 px-4 py-3 text-base outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" placeholder="Min. 8 karakter" required>
                        </label>

                        <label class="block">
                            <span class="text-sm font-semibold text-slate-700 uppercase tracking-wide">Konfirmasi Password</span>
                            <input type="password" name="password_confirmation" class="mt-2 w-full rounded-[16px] border border-slate-200 bg-slate-50 px-4 py-3 text-base outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" placeholder="Ulangi password" required>
                        </label>

                        <button type="submit" class="w-full rounded-[16px] bg-indigo-600 text-white px-5 py-3 text-base font-semibold shadow-lg shadow-indigo-200/50 hover:bg-indigo-700 transition">Daftar sebagai Event Partner</button>
                    </form>

                    <div class="mt-6 text-center text-sm text-slate-500">
                        <span>Sudah memiliki akun? </span>
                        <a href="{{ route('partner.login') }}" class="font-semibold text-[#4F46E5] underline transition duration-200 hover:text-[#4338CA]">Masuk disini!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
