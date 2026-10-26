<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['brand_name'] ?? 'HI 102' }} — {{ $settings['brand_subtitle'] ?? 'Electric Trolley Machine for Rail Painting' }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- Google Fonts: Plus Jakarta Sans & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Tailwind CSS via CDN (Tanpa Node.js / Vite, langsung jalan di cPanel murah) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    colors: {
                        rail: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316', // Warna Oranye Utama pengganti hijau referensi
                            600: '#ea580c',
                            700: '#c2410c',
                            900: '#7c2d12',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js untuk Interaktivitas Tab, Modal & Filter -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { background-color: #FAFAFA; color: #18181B; overflow-x: hidden; }
        .bento-card { transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1); }
        .bento-card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px -15px rgba(249, 115, 22, 0.15); }
        @keyframes marquee {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee { display: flex; width: max-content; animation: marquee 28s linear infinite; }
        .animate-marquee:hover { animation-play-state: paused; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="antialiased selection:bg-rail-500 selection:text-white" x-data="{ mobileNav: false }">

    <!-- Top Navigation Bar (Persis Referensi Desain) -->
    <header class="max-w-[1400px] mx-auto px-4 sm:px-8 pt-4 sm:pt-6 pb-4 flex items-center justify-between text-sm">
        <div class="flex items-center gap-4 sm:gap-8">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 font-extrabold text-lg sm:text-xl tracking-tight text-zinc-900">
                <span class="w-8 h-8 rounded-lg bg-rail-500 text-white flex items-center justify-center font-mono text-sm shadow-md shadow-rail-500/30">HI</span>
                <span>{{ $settings['brand_name'] ?? 'HI 102' }}</span>
            </a>
            <div class="hidden lg:flex items-center gap-2 text-zinc-500 font-mono text-xs bg-zinc-100 px-3 py-1.5 rounded-full">
                <span class="w-2 h-2 rounded-full bg-rail-500 animate-pulse"></span>
                <span>{{ $settings['location_tag'] ?? 'Indonesia • R54-70 Track Standard' }}</span>
                <span id="live-clock" class="ml-2 text-zinc-800 font-semibold"></span>
            </div>
        </div>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex items-center gap-5 lg:gap-6 font-medium text-zinc-600 text-xs sm:text-sm">
            <a href="{{ route('home') }}" class="hover:text-rail-600 transition {{ request()->routeIs('home') ? 'text-rail-600 font-bold' : '' }}">Spesifikasi</a>
            <a href="{{ route('home') }}#komponen" class="hover:text-rail-600 transition">Komponen</a>
            <a href="{{ route('home') }}#pengujian" class="hover:text-rail-600 transition">Pengujian</a>
            <a href="{{ route('home') }}#grafik" class="hover:text-rail-600 transition">Grafik Data</a>
            <a href="{{ route('team') }}" class="hover:text-rail-600 transition {{ request()->routeIs('team') ? 'text-rail-600 font-bold' : '' }}">Tim Pengembang</a>
        </nav>

        <!-- Hamburger Button on Mobile -->
        <button @click="mobileNav = true" 
                class="md:hidden w-10 h-10 rounded-xl bg-zinc-100 hover:bg-zinc-200 active:scale-95 flex items-center justify-center text-zinc-700 transition" 
                aria-label="Buka Menu Navigasi">
            <i class="fa-solid fa-bars text-base"></i>
        </button>

        <!-- Mobile Navigation Modal -->
        <div x-show="mobileNav" 
             x-cloak 
             @keydown.escape.window="mobileNav = false"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 md:hidden">
            
            <!-- Backdrop Overlay -->
            <div x-show="mobileNav"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="mobileNav = false"
                 class="fixed inset-0 bg-zinc-950/75 backdrop-blur-sm"></div>

            <!-- Modal Content Dialog -->
            <div x-show="mobileNav"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 scale-95"
                 class="relative w-full max-w-sm bg-white border border-zinc-200 rounded-[28px] shadow-2xl overflow-hidden z-10 flex flex-col">
                
                <!-- Modal Header -->
                <div class="flex items-center justify-between px-5 py-4 border-b border-zinc-100 bg-zinc-50/70">
                    <div class="flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-xl bg-rail-500 text-white flex items-center justify-center font-mono text-xs font-bold shadow-md shadow-rail-500/30">HI</span>
                        <div>
                            <span class="font-extrabold text-zinc-900 text-sm tracking-tight block leading-tight">{{ $settings['brand_name'] ?? 'HI 102' }}</span>
                            <span class="text-[10px] text-zinc-500 font-mono">Menu Navigasi</span>
                        </div>
                    </div>
                    <button @click="mobileNav = false" 
                            aria-label="Tutup Menu"
                            class="w-8 h-8 rounded-full bg-zinc-200/80 hover:bg-zinc-200 active:scale-95 text-zinc-600 flex items-center justify-center transition">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                <!-- Modal Navigation Links -->
                <div class="p-3 space-y-1.5 overflow-y-auto max-h-[65vh]">
                    <a href="{{ route('home') }}" 
                       @click="mobileNav = false" 
                       class="flex items-center justify-between px-3.5 py-2.5 rounded-2xl transition font-medium text-sm {{ request()->routeIs('home') ? 'bg-rail-50 text-rail-600 font-bold border border-rail-200' : 'text-zinc-800 hover:bg-zinc-100' }}">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl flex items-center justify-center {{ request()->routeIs('home') ? 'bg-rail-500 text-white' : 'bg-zinc-100 text-zinc-600' }}">
                                <i class="fa-solid fa-sliders text-xs"></i>
                            </span>
                            <span>Spesifikasi & 3D</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-xs opacity-40"></i>
                    </a>

                    <a href="{{ route('home') }}#komponen" 
                       @click="mobileNav = false" 
                       class="flex items-center justify-between px-3.5 py-2.5 rounded-2xl transition font-medium text-sm text-zinc-800 hover:bg-zinc-100">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-zinc-100 text-zinc-600 flex items-center justify-center">
                                <i class="fa-solid fa-cubes text-xs"></i>
                            </span>
                            <span>Komponen Produk</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-xs opacity-40"></i>
                    </a>

                    <a href="{{ route('home') }}#pengujian" 
                       @click="mobileNav = false" 
                       class="flex items-center justify-between px-3.5 py-2.5 rounded-2xl transition font-medium text-sm text-zinc-800 hover:bg-zinc-100">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-zinc-100 text-zinc-600 flex items-center justify-center">
                                <i class="fa-solid fa-circle-play text-xs"></i>
                            </span>
                            <span>Pengujian Video</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-xs opacity-40"></i>
                    </a>

                    <a href="{{ route('home') }}#grafik" 
                       @click="mobileNav = false" 
                       class="flex items-center justify-between px-3.5 py-2.5 rounded-2xl transition font-medium text-sm text-zinc-800 hover:bg-zinc-100">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-zinc-100 text-zinc-600 flex items-center justify-center">
                                <i class="fa-solid fa-chart-line text-xs"></i>
                            </span>
                            <span>Grafik Data</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-xs opacity-40"></i>
                    </a>

                    <a href="{{ route('team') }}" 
                       @click="mobileNav = false" 
                       class="flex items-center justify-between px-3.5 py-2.5 rounded-2xl transition font-medium text-sm {{ request()->routeIs('team') ? 'bg-rail-50 text-rail-600 font-bold border border-rail-200' : 'text-zinc-800 hover:bg-zinc-100' }}">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl flex items-center justify-center {{ request()->routeIs('team') ? 'bg-rail-500 text-white' : 'bg-zinc-100 text-zinc-600' }}">
                                <i class="fa-solid fa-users text-xs"></i>
                            </span>
                            <span>Tim Pengembang</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-xs opacity-40"></i>
                    </a>
                </div>

                <!-- Modal Footer -->
                <div class="px-4 py-3 bg-zinc-50 border-t border-zinc-100 flex items-center justify-between text-xs text-zinc-500 font-mono">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-[11px] truncate max-w-[180px]">{{ $settings['location_tag'] ?? 'R54-70 Track' }}</span>
                    </div>
                    <button @click="mobileNav = false" class="px-3.5 py-1 rounded-xl bg-zinc-200 hover:bg-zinc-300 text-zinc-700 font-sans font-semibold text-xs transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <!-- Footer (Mengikuti Referensi Desain) -->
    <footer class="max-w-[1400px] mx-auto px-4 sm:px-8 pt-16 pb-12 border-t border-zinc-200 mt-20">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 pb-12 border-b border-zinc-200">
            <div class="flex items-center gap-4 text-xs font-semibold uppercase tracking-wider text-zinc-500">
                <span>KAI Rail Maintenance</span>
                <span>•</span>
                <span>Trolley Full ASM v14</span>
                <span>•</span>
                <span>4-Nozzle Airless System</span>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}#pengujian" class="px-5 py-2.5 rounded-full bg-zinc-900 text-white text-xs font-bold flex items-center gap-2 hover:bg-zinc-800 transition">
                    <span>Lihat Data Pengujian</span>
                    <span class="w-5 h-5 rounded-full bg-rail-500 text-white flex items-center justify-center text-[10px]">
                        <i class="fa-solid fa-arrow-right"></i>
                    </span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 pt-10 text-sm">
            <div class="md:col-span-5 space-y-3">
                <div class="flex items-center gap-2 font-extrabold text-lg">
                    <span class="w-6 h-6 rounded bg-rail-500 text-white flex items-center justify-center text-xs">
                        <i class="fa-solid fa-train"></i>
                    </span>
                    <span>{{ $settings['brand_name'] ?? 'HI 102' }}</span>
                </div>
                <p class="text-zinc-500 max-w-sm leading-relaxed">
                    {{ $settings['brand_subtitle'] ?? 'Electric Trolley Machine for Rail Painting' }}. Dirancang khusus untuk efisiensi, keseragaman pengecatan rel kereta api, dan keselamatan kerja operator.
                </p>
            </div>
            <div class="md:col-span-2 space-y-2">
                <h4 class="font-bold text-zinc-900">Navigasi</h4>
                <ul class="space-y-1.5 text-zinc-500 text-xs">
                    <li><a href="{{ route('home') }}#dimensi" class="hover:text-rail-500">Dimensi</a></li>
                    <li><a href="{{ route('home') }}#kecepatan" class="hover:text-rail-500">Kecepatan</a></li>
                    <li><a href="{{ route('home') }}#komponen" class="hover:text-rail-500">Komponen</a></li>
                    <li><a href="{{ route('home') }}#pengujian" class="hover:text-rail-500">Pengujian</a></li>
                    <li><a href="{{ route('home') }}#grafik" class="hover:text-rail-500">Grafik Data</a></li>
                </ul>
            </div>
            <div class="md:col-span-3 space-y-2">
                <h4 class="font-bold text-zinc-900">Spesifikasi CAD v14</h4>
                <ul class="space-y-1.5 text-zinc-500 text-xs font-mono">
                    <li>Dimensi: 1350 x 1000 mm</li>
                    <li>Track Gauge: 930 mm (R54-70)</li>
                    <li>Penggerak: BLDC Motor v5</li>
                    <li>Sprayer: 4x Airless Möllar</li>
                </ul>
            </div>
            <div class="md:col-span-2 space-y-2">
                <h4 class="font-bold text-zinc-900">Akses</h4>
                <ul class="space-y-1.5 text-zinc-500 text-xs">
                    <li><a href="{{ route('team') }}" class="hover:text-rail-500">Tim Pengembang</a></li>
                </ul>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between text-xs text-zinc-400 pt-12">
            <p>©2026 {{ $settings['brand_name'] ?? 'HI 102' }} Electric Railway Trolley. All rights reserved.</p>
            <p>Ditenagai oleh Laravel & Three.js WebGL 3D</p>
        </div>
    </footer>

    <!-- Floating Quick Action on Mobile/Tablet -->
    <div x-data="{ showTop: false }" @scroll.window="showTop = (window.pageYOffset > 400)" class="fixed bottom-5 right-5 z-40 flex flex-col gap-2">
        <button x-show="showTop" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" @click="window.scrollTo({ top: 0, behavior: 'smooth' })" class="w-11 h-11 rounded-full bg-zinc-900/90 hover:bg-rail-500 text-white shadow-xl backdrop-blur border border-zinc-700/50 flex items-center justify-center transition active:scale-95" aria-label="Kembali ke atas">
            <i class="fa-solid fa-arrow-up text-sm"></i>
        </button>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            const el = document.getElementById('live-clock');
            if (el) el.textContent = now.toTimeString().split(' ')[0];
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>
</html>
