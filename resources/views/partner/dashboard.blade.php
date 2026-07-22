<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partner Dashboard - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen">
    <main class="max-w-7xl mx-auto px-6 py-10">
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-indigo-700 text-white flex items-center justify-center font-black text-xl">AH</div>
                <div>
                    <h1 class="text-2xl font-black">Dashboard Event Partner</h1>
                    <p class="text-slate-500">AmikomEventHub partner workspace</p>
                </div>
            </div>
            <form action="{{ route('partner.logout') }}" method="POST">
                @csrf
                <button type="submit" class="px-5 py-3 rounded-2xl bg-slate-900 text-white font-bold hover:bg-slate-800 transition">Logout</button>
            </form>
        </div>

        <div class="grid lg:grid-cols-[1.1fr_0.9fr] gap-6">
            <section class="bg-white rounded-4xl p-8 shadow-sm border border-slate-100">
                <p class="text-sm font-black tracking-[0.2em] text-indigo-500 uppercase">Ringkasan Akun</p>
                <h2 class="text-4xl font-black mt-3">Halo, {{ $partner->name }}</h2>
                <p class="text-slate-500 mt-3">Kamu masuk sebagai event partner dan bisa mengelola event serta data transaksi dari menu admin yang sudah ada.</p>

                <div class="grid md:grid-cols-2 gap-4 mt-8">
                    <div class="rounded-3xl bg-slate-50 p-5 border border-slate-100">
                        <p class="text-xs font-black tracking-[0.2em] text-slate-400 uppercase">Nama</p>
                        <p class="mt-2 text-lg font-bold">{{ $partner->name }}</p>
                    </div>
                    <div class="rounded-3xl bg-slate-50 p-5 border border-slate-100">
                        <p class="text-xs font-black tracking-[0.2em] text-slate-400 uppercase">Email</p>
                        <p class="mt-2 text-lg font-bold break-all">{{ $partner->email }}</p>
                    </div>
                </div>
            </section>

            <aside class="space-y-6">
                <div class="bg-indigo-900 rounded-4xl p-8 text-white shadow-lg shadow-indigo-100">
                    <p class="text-sm font-black tracking-[0.2em] text-indigo-200 uppercase">Akses Cepat</p>
                    <h3 class="text-2xl font-black mt-3">Kelola event dan partner</h3>
                    <p class="text-indigo-100 mt-3">Akun partner ini terpisah dari admin lama dan user pembeli Google SSO.</p>
                    <a href="{{ route('home') }}" class="inline-flex mt-6 px-5 py-3 rounded-2xl bg-white text-indigo-900 font-black hover:bg-slate-100 transition">Kembali ke Beranda</a>
                </div>

                <div class="bg-white rounded-4xl p-8 shadow-sm border border-slate-100">
                    <p class="text-sm font-black tracking-[0.2em] text-slate-400 uppercase">Catatan</p>
                    <p class="mt-3 text-slate-600 leading-relaxed">Akun partner ini menggunakan login terpisah dari admin lama dan user pembeli Google SSO.</p>
                </div>
            </aside>
        </div>
    </main>
</body>
</html>