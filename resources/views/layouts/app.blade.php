<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AmikomEventHub - Temukan Event Seru!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900">

    <!-- Navigation -->
    <nav
        class="glass sticky top-8 z-40 mx-4 mt-4 px-6 py-4 rounded-2xl border border-white/20 shadow-lg flex justify-between items-center">
        <div class="flex items-center gap-2">
            <div
                class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-xl">
                AH</div>
            <span class="text-xl font-bold tracking-tight">AmikomEventHub</span>
        </div>
        <div class="hidden md:flex gap-8 font-medium">
            <a href="{{ route('home') }}#events" class="nav-link text-slate-900 hover:text-indigo-600 transition">Jelajahi</a>
            <a href="{{ route('home') }}#kategori" class="nav-link text-slate-900 hover:text-indigo-600 transition">Kategori</a>
            <a href="{{ route('home') }}#tentang-kami" class="nav-link text-slate-900 hover:text-indigo-600 transition">Tentang Kami</a>
        </div>
        <div class="flex items-center gap-3">
            @auth
                <details class="relative group">
                    <summary class="list-none cursor-pointer flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 shadow-sm text-white hover:bg-indigo-700 transition">
                        <span class="text-sm font-semibold">Profile</span>
                        <svg class="w-4 h-4 text-white transition group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <div class="absolute left-0 mt-3 w-full rounded-2xl border border-slate-200 bg-white shadow-xl overflow-hidden z-50">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left px-5 py-3 text-sm font-semibold text-rose-600 hover:bg-rose-50 transition">Logout</button>
                        </form>
                    </div>
                </details>
            @else
                <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl font-semibold bg-indigo-600 text-white hover:bg-indigo-700 transition">Masuk/Daftar</a>
            @endauth
        </div>
    </nav>


    @yield('content')

    {{-- Partner Marquee --}}
    @isset($partners)
    <section class="w-full bg-[#f7f9fa] border-t border-slate-100 py-20">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-4xl font-extrabold text-center mb-4 text-slate-800">Partner & Sponsor</h2>
            <p class="text-xl text-center text-slate-400 mb-12">Didukung oleh perusahaan dan komunitas terpercaya</p>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-8 justify-center items-center">
                @foreach($partners as $partner)
                    <div class="flex items-center justify-center h-32 bg-slate-200 rounded-md">
                        <span class="text-4xl font-bold text-slate-400">{{ $partner->name }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endisset

    <!-- Footer -->
    <footer id="tentang-kami" class="bg-indigo-900 text-indigo-100 py-20 px-6 mt-20 scroll-mt-28">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12">
            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <div
                        class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-indigo-900 font-bold text-xl">
                        AH</div>
                    <span class="text-2xl font-bold text-white">AmikomEventHub</span>
                </div>
                <p class="max-w-xs text-indigo-300">Platform reservasi tiket event online terbaik untuk mahasiswa dan
                    penyelenggara profesional.</p>
            </div>
            <div>
                <h4 class="text-white font-bold mb-6">Kategori</h4>
                <ul class="space-y-4">
                    <li><a href="/" class="hover:text-white transition">Semua Kategori</a></li>
                    @isset($categories)
                        @foreach($categories as $cat)
                            <li>
                                <a href="{{ route('home') }}?category={{ $cat->id }}#kategori" class="hover:text-white transition">
                                    {{ $cat->name }}
                                </a>
                            </li>
                        @endforeach
                    @endisset
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4">Navigasi</h4>
                <ul class="space-y-4">
                    <li><a href="#" class="hover:text-white transition">Home</a></li>
                    <li><a href="#" class="hover:text-white transition">Semua Event</a></li>
                    <li><a href="#" class="hover:text-white transition">Cara Bayar</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4">Hubungi Kami</h4>
                <ul class="space-y-4">
                    <li>support@eventtiket.com</li>
                    <li>+62 812 3456 7890</li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto pt-12 mt-12 border-t border-indigo-800 text-center text-indigo-400 text-sm">
            &copy; 2024 AmikomEventHub. Built with Laravel & Tailwind CSS.
        </div>
    </footer>

    <script>
        const navLinks = document.querySelectorAll('.nav-link');
        const hashToId = {
            '#events': 'events',
            '#kategori': 'kategori',
            '#tentang-kami': 'tentang-kami'
        };

        function updateActiveLink() {
            const currentHash = window.location.hash || '#events';
            navLinks.forEach(link => {
                if (link.getAttribute('href').endsWith(currentHash)) {
                    link.classList.add('text-indigo-600');
                    link.classList.remove('text-slate-900');
                } else {
                    link.classList.remove('text-indigo-600');
                    link.classList.add('text-slate-900');
                }
            });
        }

        window.addEventListener('hashchange', updateActiveLink);
        window.addEventListener('load', () => {
            updateActiveLink();
        });

        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                setTimeout(updateActiveLink, 50);
            });
        });
    </script>
</body>

</html>
