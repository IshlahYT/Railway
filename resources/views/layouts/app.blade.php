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
        body { background-color: #FAFAFA; color: #18181B; overflow-x: hidden; }
        .bento-card { transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1); }
        .bento-card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px -15px rgba(249, 115, 22, 0.15); }
        @keyframes marquee {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee { display: flex; width: max-content; animation: marquee 28s linear infinite; }
        .animate-marquee:hover { animation-play-state: paused; }
    </style>
</head>
<body class="antialiased selection:bg-rail-500 selection:text-white">

    <!-- Top Navigation Bar (Persis Referensi Desain) -->
    <header class="max-w-[1400px] mx-auto px-4 sm:px-8 pt-6 pb-4 flex items-center justify-between text-sm">
        <div class="flex items-center gap-8">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 font-extrabold text-xl tracking-tight text-zinc-900">
                <span class="w-8 h-8 rounded-lg bg-rail-500 text-white flex items-center justify-center font-mono text-sm shadow-md shadow-rail-500/30">HI</span>
                <span>{{ $settings['brand_name'] ?? 'HI 102' }}</span>
            </a>
            <div class="hidden md:flex items-center gap-2 text-zinc-500 font-mono text-xs bg-zinc-100 px-3 py-1.5 rounded-full">
                <span class="w-2 h-2 rounded-full bg-rail-500 animate-pulse"></span>
                <span>{{ $settings['location_tag'] ?? 'Indonesia • R54-70 Track Standard' }}</span>
                <span id="live-clock" class="ml-2 text-zinc-800 font-semibold"></span>
            </div>
        </div>

        <nav class="flex items-center gap-6 font-medium text-zinc-600">
            <a href="{{ route('home') }}" class="hover:text-rail-600 transition {{ request()->routeIs('home') ? 'text-rail-600 font-bold' : '' }}">Produk HI 102</a>
            <a href="{{ route('home') }}#pengujian" class="hover:text-rail-600 transition">Data Pengujian</a>
            <a href="{{ route('home') }}#komponen" class="hover:text-rail-600 transition">Implementasi & CAD</a>
            <a href="{{ route('team') }}" class="hover:text-rail-600 transition {{ request()->routeIs('team') ? 'text-rail-600 font-bold' : '' }}">Tim Pengembang</a>
        </nav>
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
                    <li><a href="{{ route('home') }}#problem" class="hover:text-rail-500">Problem</a></li>
                    <li><a href="{{ route('home') }}#solution" class="hover:text-rail-500">Solution</a></li>
                    <li><a href="{{ route('home') }}#pengujian" class="hover:text-rail-500">Hasil Pengujian</a></li>
                    <li><a href="{{ route('home') }}#komponen" class="hover:text-rail-500">Galeri Komponen</a></li>
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
