 @extends('layouts.app')
 @section('title', 'Checkout - ' . $event->title)
 @section('content')

<main class="max-w-3xl mx-auto px-6 py-20">
    <div class="mb-12">
         <a href="{{ route('events.show', $event->id) }}" class="text-indigo-600 font-bold flex items-center gap-2 mb-6">
             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
             </svg>
             Kembali ke Event
         </a>
         <h1 class="text-4xl font-extrabold">Checkout</h1>
         <p class="text-slate-500 mt-2">Lengkapi data Anda untuk mendapatkan tiket.</p>
    </div>

    @if(session('error'))
    <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-xl font-bold">
         {{ session('error') }}
    </div>
    @endif

    @auth
    <div class="mb-6 p-4 bg-emerald-50 text-emerald-800 rounded-2xl border border-emerald-200">
        Masuk sebagai {{ auth()->user()->name }}. Data nama dan email sudah diisi otomatis.
    </div>
    @else
    <div class="mb-6 p-6 bg-white border border-slate-200 rounded-3xl shadow-sm flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-sm font-black uppercase tracking-[0.2em] text-indigo-600">Login Instan</p>
            <h2 class="text-2xl font-extrabold text-slate-900 mt-1">Continue with Google</h2>
            <p class="text-slate-500 mt-2">Masuk sekali klik untuk mengisi identitas pembeli tanpa membuat akun manual.</p>
        </div>
        <a href="{{ route('auth.google.checkout', $event) }}"
            class="inline-flex items-center justify-center gap-3 px-6 py-4 rounded-2xl bg-slate-900 text-white font-black shadow-lg shadow-slate-200 hover:bg-slate-800 transition">
            <svg class="w-5 h-5" viewBox="0 0 24 24" aria-hidden="true">
                <path fill="#EA4335" d="M12 10.2v3.95h5.62c-.22 1.2-.93 2.22-2.02 2.91v2.42h3.27c1.9-1.75 3.01-4.33 3.01-7.4 0-.72-.06-1.42-.16-2.08H12z"/>
                <path fill="#34A853" d="M5.51 14.59l-.85.65-2.39 1.86C3.81 19.96 7.61 22 12 22c2.98 0 5.48-.98 7.3-2.65l-3.27-2.42c-.9.6-2.06.96-4.03.96-3.08 0-5.68-2.08-6.61-4.9z"/>
                <path fill="#4A90E2" d="M12 4.15c1.63 0 3.1.56 4.26 1.67l3.2-3.2C17.44 1.02 14.98 0 12 0 7.61 0 3.81 2.04 1.44 5.54l4.07 3.16C6.32 6.23 8.92 4.15 12 4.15z"/>
                <path fill="#FBBC05" d="M5.51 9.41c.23-.7.56-1.37 1-1.99L2.44 4.26A11.93 11.93 0 0 0 0 12c0 1.85.43 3.6 1.16 5.17l4.35-3.38c-.12-.56-.19-1.15-.19-1.79 0-.63.07-1.22.19-1.79z"/>
            </svg>
            Continue with Google
        </a>
    </div>
    @endauth

     <div class="grid grid-cols-1 gap-8">
         <!-- Summary Card -->
         <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
             <h3 class="text-xl font-bold mb-6 border-b pb-4">Pesanan Anda</h3>
             <div class="flex gap-6 items-start">
                 <img src="{{ $event->poster_url }}"
                     alt="{{ $event->title }}" class="w-24 h-24 rounded-2xl object-cover">
                 <div>
                     <h4 class="font-extrabold text-lg">{{ $event->title }}</h4>
                     <p class="text-slate-500">{{ $event->date->format('d M Y') }} • {{ $event->location }}</p>
                     <p class="text-indigo-600 font-bold mt-2">1 x Rp {{ number_format($event->price, 0, ',', '.') }}</p>
                 </div>
             </div>
             <div class="mt-8 pt-6 border-t space-y-3">
                 <div class="flex justify-between text-slate-500">
                     <span>Harga Tiket</span>
                     <span>Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                 </div>
                 @if($event->price > 0)
                     <div class="flex justify-between text-slate-500">
                         <span>Biaya Layanan</span>
                         <span>Rp 5.000</span>
                     </div>
                 @endif
                 <div class="flex justify-between text-2xl font-black mt-4 pt-4 border-t">
                     <span>Total Bayar</span>
                     <span class="text-indigo-600">
                         Rp {{ number_format($event->price > 0 ? $event->price + 5000 : 0, 0, ',', '.') }}
                     </span>
                 </div>
                 @if($event->price === 0)
                     <p class="text-sm text-emerald-600">Acara gratis: Pembayaran tidak diperlukan dan tiket langsung dikirim.</p>
                 @endif
             </div>
         </div>

         @auth
         <!-- Form Card -->
         <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
             <h3 class="text-xl font-bold mb-6 italic text-indigo-600 underline underline-offset-8">📦 Data Pemesan</h3>
             <form action="{{ route('checkout.store', $event->id) }}" method="POST" class="space-y-6">
                 @csrf
                 <input type="hidden" name="reservation_order_id" value="{{ $transaction->order_id ?? '' }}">
                 <div>
                     <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Nama
                         Lengkap</label>
                     <input type="text" name="customer_name" placeholder="Masukkan nama sesuai identitas"
                         class="w-full px-5 py-4 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium bg-slate-50"
                         required value="{{ old('customer_name', auth()->user()->name ?? '') }}" readonly>
                 </div>
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <div>
                         <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Email
                             Aktif</label>
                         <input type="email" name="customer_email" placeholder="contoh@gmail.com"
                             class="w-full px-5 py-4 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium bg-slate-50"
                             required value="{{ old('customer_email', auth()->user()->email ?? '') }}" readonly>
                         <p class="text-[10px] text-slate-400 mt-2 font-bold uppercase tracking-tighter">*E-Ticket
                             akan dikirim ke email ini</p>
                     </div>
                     <div>
                         <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">No.
                             WhatsApp</label>
                         <input type="tel" name="customer_phone" placeholder="08xxxxxxx"
                             class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                             required value="{{ old('customer_phone') }}">
                     </div>
                 </div>

                 <button type="submit"
                     class="w-full py-5 bg-indigo-600 text-white rounded-2xl font-black text-xl shadow-xl shadow-indigo-200 hover:bg-indigo-700 active:scale-95 transition-all">
                     Lanjut Pembayaran
                 </button>
                 <p class="text-center text-xs text-slate-400">Dengan menekan tombol di atas, Anda menyetujui Syarat
                     & Ketentuan kami.</p>
             </form>
         </div>
         @endauth

     </div>
</main>
@endsection
