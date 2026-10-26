@extends('layouts.app')

@section('content')
<div class="max-w-[1400px] mx-auto px-3 sm:px-6 lg:px-8 space-y-12 sm:space-y-16 lg:space-y-20">

    <!-- ===================================================================== -->
    <!-- HERO SECTION: INTERACTIVE 3D RAILWAY TROLLEY (BENTO REFERENCE LAYOUT) -->
    <!-- ===================================================================== -->
    <section class="relative rounded-2xl sm:rounded-[32px] bg-zinc-900 text-white overflow-hidden shadow-2xl border border-zinc-800 min-h-[560px] sm:min-h-[640px] flex flex-col justify-between p-4 sm:p-7 md:p-10">
        
        <!-- Kanvas 3D Interaktif Three.js (Merekonstruksi Trolley full ASM v14 dari DXF & Foto) -->
        <div id="trolley-3d-canvas" class="absolute inset-0 w-full h-full z-0 cursor-grab active:cursor-grabbing"></div>
        
        <!-- Gradient Overlay Halus agar Teks Tetap Terbaca Jelas -->
        <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/95 via-zinc-950/30 to-zinc-950/60 pointer-events-none z-10"></div>

        <!-- Baris Atas Hero (Pills Kiri & Kontrol Kamera 3D Kanan) -->
        <div class="relative z-20 flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
            <div class="flex flex-wrap items-center gap-1.5 sm:gap-2">
                <span class="px-3 py-1 sm:px-3.5 sm:py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-[11px] sm:text-xs font-semibold tracking-wide">
                    {{ $settings['hero_badge_1'] ?? 'Rail Tech' }}
                </span>
                <span class="px-3 py-1 sm:px-3.5 sm:py-1.5 rounded-full bg-rail-500/90 text-white text-[11px] sm:text-xs font-bold tracking-wide shadow-lg shadow-rail-500/30">
                    {{ $settings['hero_badge_2'] ?? '4-Nozzle Airless' }}
                </span>
                <span class="px-3 py-1 sm:px-3.5 sm:py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-[11px] sm:text-xs font-semibold tracking-wide">
                    {{ $settings['hero_badge_3'] ?? 'BLDC In-Wheel 200' }}
                </span>
            </div>

            <!-- Kontrol Interaktif 3D View (Touch-friendly & Horizontal Scroll di Layar Kecil) -->
            <div class="flex items-center gap-1.5 sm:gap-2 bg-zinc-900/85 backdrop-blur-md border border-white/15 rounded-2xl sm:rounded-full p-1 sm:p-1.5 text-[11px] sm:text-xs overflow-x-auto no-scrollbar max-w-full">
                <button onclick="setCameraView('iso')" class="px-2.5 sm:px-3 py-1 rounded-xl sm:rounded-full bg-rail-500 text-white font-bold hover:bg-rail-600 transition whitespace-nowrap min-h-[30px] flex items-center justify-center active:scale-95">3D Orbit</button>
                <button onclick="setCameraView('front')" class="px-2.5 sm:px-3 py-1 rounded-xl sm:rounded-full hover:bg-white/10 text-zinc-200 transition whitespace-nowrap min-h-[30px] flex items-center justify-center active:scale-95">Depan (Sprayer)</button>
                <button onclick="setCameraView('top')" class="px-2.5 sm:px-3 py-1 rounded-xl sm:rounded-full hover:bg-white/10 text-zinc-200 transition whitespace-nowrap min-h-[30px] flex items-center justify-center active:scale-95">Atas (1350mm)</button>
                <button onclick="toggleSprayAnimation()" id="btn-spray" class="px-2.5 sm:px-3 py-1 rounded-xl sm:rounded-full bg-amber-500/20 text-amber-300 border border-amber-400/30 font-semibold hover:bg-amber-500/30 transition inline-flex items-center gap-1.5 whitespace-nowrap min-h-[30px] active:scale-95">
                    <i class="fa-solid fa-droplet text-xs"></i> <span>Simulasi Semprot: ON</span>
                </button>
            </div>
        </div>

        <!-- Baris Tengah Hero (Angka Besar 1350mm Kiri & Petunjuk 3D Kanan) -->
        <div class="relative z-20 grid grid-cols-1 md:grid-cols-12 gap-4 sm:gap-6 my-auto py-6 sm:py-8 pointer-events-none">
            <div class="md:col-span-6 lg:col-span-5 space-y-1 sm:space-y-1.5">
                <div class="text-4xl sm:text-6xl md:text-7xl font-extrabold tracking-tight text-white drop-shadow">
                    {{ $settings['hero_stat_big'] ?? '1350mm' }}
                </div>
                <p class="text-xs sm:text-sm text-zinc-300 font-medium leading-relaxed">
                    {{ $settings['hero_stat_label'] ?? 'Dimensi Lebar Presisi (Track Gauge 930mm)' }}
                </p>
                <!-- <div class="pt-2 inline-flex items-center gap-2 text-[10px] sm:text-[11px] font-mono text-rail-300 bg-zinc-900/80 px-2.5 sm:px-3 py-1 rounded-full border border-rail-500/30">
                    <i class="fa-solid fa-arrows-rotate text-rail-400"></i>
                    <span>Putar 360° dengan Mouse / Sentuhan Layar</span>
                </div> -->
            </div>
        </div>

        <!-- Baris Bawah Hero (Floating Card Kiri & Judul Besar Kanan seperti Referensi) -->
        <div class="relative z-20 grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8 items-end">
            <!-- Floating White Card (Kiri Bawah) -->
            <div class="lg:col-span-5 xl:col-span-4 bg-white text-zinc-900 rounded-2xl sm:rounded-3xl p-3.5 sm:p-4 shadow-2xl border border-zinc-100">
                <div class="relative rounded-xl sm:rounded-2xl overflow-hidden h-36 sm:h-44 bg-zinc-100">
                    <img src="{{ asset($settings['hero_image'] ?? 'images/trolley/img1.jpg') }}" alt="Implementasi HI 102" class="w-full h-full object-cover">
                    <span class="absolute top-2.5 left-2.5 sm:top-3 sm:left-3 px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-full bg-zinc-900/85 text-white text-[9px] sm:text-[10px] font-mono">
                        Trolley full ASM v14
                    </span>
                </div>
                <div class="pt-3 sm:pt-4 space-y-2.5 sm:space-y-3">
                    <div class="flex items-start gap-2.5">
                        <span class="w-6 h-6 rounded-full bg-rail-500 text-white flex-shrink-0 flex items-center justify-center text-[10px] font-bold mt-0.5"><i class="fa-solid fa-bolt"></i></span>
                        <p class="text-xs text-zinc-600 leading-relaxed">
                            {{ $settings['hero_floating_card_text'] ?? 'Inovasi wahana elektrik otomatis untuk pengecatan dan perawatan rel kereta api R54-70 dengan presisi tinggi.' }}
                        </p>
                    </div>
                    <div class="flex items-center justify-between pt-2 border-t border-zinc-100 text-[10px] sm:text-[11px] font-mono text-zinc-500">
                        <span class="font-bold text-zinc-900">{{ $settings['hero_floating_year'] ?? '©2026 HI 102' }}</span>
                        <span>Dual Battery • 4 Sprayer</span>
                    </div>
                </div>
            </div>

            <!-- Headline Besar (Kanan Bawah) -->
            <div class="lg:col-span-7 xl:col-span-8 lg:text-right space-y-2 sm:space-y-3 pointer-events-none">
                <div class="inline-flex items-center gap-2 px-3.5 sm:px-4 py-1 sm:py-1.5 rounded-full bg-rail-500 text-white text-[11px] sm:text-xs font-extrabold tracking-wider uppercase shadow-lg shadow-rail-500/40">
                    <i class="fa-solid fa-train text-xs"></i>
                    <span>{{ $settings['brand_name'] ?? 'HI 102' }} RAILWAY ELECTRIC</span>
                </div>
                <h1 class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight lg:leading-none text-white">
                    {{ $settings['hero_title'] ?? 'PARTNER IN RAILWAY INNOVATION' }}
                </h1>
            </div>
        </div>
    </section>

    <!-- ===================================================================== -->
    <!-- SECTION 01: DIMENSI TROLLEY (P × L × T & BERAT)                      -->
    <!-- ===================================================================== -->
    <section id="dimensi" class="space-y-6 sm:space-y-10">
        <div class="flex items-start sm:items-center justify-between gap-3 sm:gap-4">
            <div class="flex flex-col sm:flex-row sm:items-baseline gap-1 sm:gap-4 md:gap-6">
                <span class="text-[11px] sm:text-xs font-mono text-zinc-400 font-bold uppercase">01 / DIMENSI TROLLEY</span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-zinc-900 leading-tight">Dimensi & Berat</h2>
            </div>
            <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-zinc-900 text-rail-400 flex items-center justify-center font-bold flex-shrink-0 text-sm sm:text-base shadow-sm">
                <i class="fa-solid fa-ruler-combined"></i>
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-8">
            <!-- Blueprint Image Card -->
            <div class="lg:col-span-7 relative rounded-2xl sm:rounded-[32px] overflow-hidden bg-white border border-zinc-200 shadow-md p-4 sm:p-6 md:p-8">
                <div class="flex flex-wrap items-center gap-2 mb-4 sm:mb-6">
                    <span class="px-2.5 sm:px-3 py-1 rounded-full bg-rail-100 text-rail-700 text-[11px] sm:text-xs font-mono font-bold">CAD Trolley full ASM v14</span>
                    <span class="px-2.5 sm:px-3 py-1 rounded-full bg-zinc-100 text-zinc-600 text-[11px] sm:text-xs font-mono">AutoCAD AC1027</span>
                </div>
                <img src="{{ asset($settings['blueprint_image'] ?? 'images/trolley/blueprint_dimensi.png') }}" alt="Blueprint Dimensi HI 102" class="w-full h-auto rounded-xl sm:rounded-2xl">
            </div>

            <!-- Dimension Specs Cards -->
            <div class="lg:col-span-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-3.5 sm:gap-5">
                <!-- Panjang -->
                <div class="bento-card bg-white rounded-2xl sm:rounded-[28px] p-4 sm:p-6 border border-zinc-200/80 shadow-sm">
                    <div class="flex items-center gap-3.5 sm:gap-4">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl sm:rounded-2xl bg-rail-500/10 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-arrows-left-right text-rail-500 text-lg sm:text-xl"></i>
                        </div>
                        <div>
                            <span class="text-[9px] sm:text-[10px] font-mono uppercase text-zinc-400 block font-bold">PANJANG (P)</span>
                            <span class="text-2xl sm:text-3xl font-extrabold text-zinc-900">1050 <span class="text-sm sm:text-base font-semibold text-zinc-400">mm</span></span>
                        </div>
                    </div>
                </div>

                <!-- Lebar -->
                <div class="bento-card bg-white rounded-2xl sm:rounded-[28px] p-4 sm:p-6 border border-zinc-200/80 shadow-sm">
                    <div class="flex items-center gap-3.5 sm:gap-4">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl sm:rounded-2xl bg-rail-500/10 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-arrows-left-right-to-line text-rail-500 text-lg sm:text-xl"></i>
                        </div>
                        <div>
                            <span class="text-[9px] sm:text-[10px] font-mono uppercase text-zinc-400 block font-bold">LEBAR (L)</span>
                            <span class="text-2xl sm:text-3xl font-extrabold text-zinc-900">1350 <span class="text-sm sm:text-base font-semibold text-zinc-400">mm</span></span>
                        </div>
                    </div>
                </div>

                <!-- Tinggi -->
                <div class="bento-card bg-white rounded-2xl sm:rounded-[28px] p-4 sm:p-6 border border-zinc-200/80 shadow-sm">
                    <div class="flex items-center gap-3.5 sm:gap-4">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl sm:rounded-2xl bg-rail-500/10 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-arrows-up-down text-rail-500 text-lg sm:text-xl"></i>
                        </div>
                        <div>
                            <span class="text-[9px] sm:text-[10px] font-mono uppercase text-zinc-400 block font-bold">TINGGI (T)</span>
                            <span class="text-2xl sm:text-3xl font-extrabold text-zinc-900">1000 <span class="text-sm sm:text-base font-semibold text-zinc-400">mm</span></span>
                        </div>
                    </div>
                </div>

                <!-- Berat -->
                <div class="bento-card bg-zinc-900 rounded-2xl sm:rounded-[28px] p-4 sm:p-6 shadow-lg sm:col-span-2 lg:col-span-1">
                    <div class="flex items-center gap-3.5 sm:gap-4">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl sm:rounded-2xl bg-rail-500/20 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-weight-hanging text-rail-400 text-lg sm:text-xl"></i>
                        </div>
                        <div>
                            <span class="text-[9px] sm:text-[10px] font-mono uppercase text-zinc-500 block font-bold">BERAT TOTAL</span>
                            <span class="text-2xl sm:text-3xl font-extrabold text-white">120 <span class="text-sm sm:text-base font-semibold text-zinc-400">kg</span></span>
                        </div>
                    </div>
                    <div class="mt-3.5 flex flex-wrap items-center gap-2">
                        <span class="px-2.5 py-1 rounded-full bg-rail-500/20 text-rail-300 text-[10px] font-mono font-bold">Track Gauge 930mm</span>
                        <span class="px-2.5 py-1 rounded-full bg-white/10 text-zinc-400 text-[10px] font-mono">Rail R54-70</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================================================================== -->
    <!-- SECTION 02: KECEPATAN TROLLEY                                         -->
    <!-- ===================================================================== -->
    <section id="kecepatan" class="space-y-6 sm:space-y-10">
        <div class="flex items-start sm:items-center justify-between gap-3 sm:gap-4">
            <div class="flex flex-col sm:flex-row sm:items-baseline gap-1 sm:gap-4 md:gap-6">
                <span class="text-[11px] sm:text-xs font-mono text-zinc-400 font-bold uppercase">02 / KECEPATAN TROLLEY</span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-zinc-900 leading-tight">Mode Kecepatan</h2>
            </div>
            <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-zinc-900 text-rail-400 flex items-center justify-center font-bold flex-shrink-0 text-sm sm:text-base shadow-sm">
                <i class="fa-solid fa-gauge-high"></i>
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <!-- Mode 1 -->
            <div class="bento-card bg-white rounded-2xl sm:rounded-[28px] p-6 sm:p-8 border border-zinc-200/80 shadow-sm relative overflow-hidden group flex flex-col justify-between">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-rail-100/40 to-transparent rounded-bl-full pointer-events-none"></div>
                <div>
                    <span class="relative inline-block px-3 py-1 rounded-full bg-zinc-100 text-zinc-600 text-xs font-mono font-bold mb-3 sm:mb-4">MODE 1</span>
                    <div class="relative">
                        <span class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-zinc-900 block leading-none">5</span>
                        <span class="text-base sm:text-lg font-bold text-zinc-400">km/jam</span>
                    </div>
                    <p class="text-xs text-zinc-500 mt-3 sm:mt-4 leading-relaxed">Kecepatan rendah untuk pengecatan presisi. Optimal untuk kontrol distribusi cat pada rel.</p>
                </div>
                <div class="mt-5 sm:mt-6 flex items-center gap-2 pt-3 border-t border-zinc-100">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span class="text-[10px] font-mono text-zinc-400 font-bold">LOW SPEED • PAINTING MODE</span>
                </div>
            </div>

            <!-- Mode 2 -->
            <div class="bento-card bg-rail-500 rounded-2xl sm:rounded-[28px] p-6 sm:p-8 shadow-lg shadow-rail-500/25 relative overflow-hidden group flex flex-col justify-between">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-white/10 to-transparent rounded-bl-full pointer-events-none"></div>
                <div>
                    <span class="relative inline-block px-3 py-1 rounded-full bg-white/20 text-white text-xs font-mono font-bold mb-3 sm:mb-4">MODE 2</span>
                    <div class="relative">
                        <span class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-white block leading-none">10</span>
                        <span class="text-base sm:text-lg font-bold text-rail-100">km/jam</span>
                    </div>
                    <p class="text-xs text-rail-100 mt-3 sm:mt-4 leading-relaxed">Kecepatan sedang untuk transit antar titik pengecatan. Keseimbangan speed & kontrol.</p>
                </div>
                <div class="mt-5 sm:mt-6 flex items-center gap-2 pt-3 border-t border-white/15">
                    <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                    <span class="text-[10px] font-mono text-rail-100 font-bold">MID SPEED • TRANSIT MODE</span>
                </div>
            </div>

            <!-- Mode 3 -->
            <div class="bento-card bg-zinc-900 rounded-2xl sm:rounded-[28px] p-6 sm:p-8 shadow-lg relative overflow-hidden group flex flex-col justify-between sm:col-span-2 lg:col-span-1">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-rail-500/20 to-transparent rounded-bl-full pointer-events-none"></div>
                <div>
                    <span class="relative inline-block px-3 py-1 rounded-full bg-white/10 text-zinc-300 text-xs font-mono font-bold mb-3 sm:mb-4">MODE 3</span>
                    <div class="relative">
                        <span class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-white block leading-none">15</span>
                        <span class="text-base sm:text-lg font-bold text-zinc-500">km/jam</span>
                    </div>
                    <p class="text-xs text-zinc-400 mt-3 sm:mt-4 leading-relaxed">Kecepatan maksimum untuk perpindahan jarak jauh antar lokasi tanpa beban pengecatan.</p>
                </div>
                <div class="mt-5 sm:mt-6 flex items-center gap-2 pt-3 border-t border-zinc-800">
                    <span class="w-2 h-2 rounded-full bg-rail-500 animate-pulse"></span>
                    <span class="text-[10px] font-mono text-zinc-500 font-bold">HIGH SPEED • MAX MODE</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================================================================== -->
    <!-- SECTION 03: DURABILITAS TROLLEY DAN SPRAYER                           -->
    <!-- ===================================================================== -->
    <section id="durabilitas" class="space-y-6 sm:space-y-10">
        <div class="flex items-start sm:items-center justify-between gap-3 sm:gap-4">
            <div class="flex flex-col sm:flex-row sm:items-baseline gap-1 sm:gap-4 md:gap-6">
                <span class="text-[11px] sm:text-xs font-mono text-zinc-400 font-bold uppercase">03 / DURABILITAS</span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-zinc-900 leading-tight">Durabilitas Trolley & Sprayer</h2>
            </div>
            <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-zinc-900 text-rail-400 flex items-center justify-center font-bold flex-shrink-0 text-sm sm:text-base shadow-sm">
                <i class="fa-solid fa-shield-halved"></i>
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
            <!-- Durabilitas Trolley -->
            <div class="bento-card bg-white rounded-2xl sm:rounded-[32px] p-5 sm:p-8 border border-zinc-200/80 shadow-sm space-y-5 sm:space-y-6">
                <div class="flex items-center gap-3.5 sm:gap-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl sm:rounded-2xl bg-zinc-900 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-train text-rail-400 text-lg sm:text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg sm:text-xl font-extrabold text-zinc-900">Durabilitas Trolley</h3>
                        <span class="text-[11px] sm:text-xs font-mono text-zinc-400 font-bold">CHASSIS & FRAME INTEGRITY</span>
                    </div>
                </div>

                <div class="space-y-3 sm:space-y-4">
                    <div class="flex items-center justify-between p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-zinc-50 border border-zinc-100 text-xs sm:text-sm">
                        <div class="flex items-center gap-2.5 sm:gap-3">
                            <i class="fa-solid fa-layer-group text-rail-500"></i>
                            <span class="font-semibold text-zinc-700">Material Sasis</span>
                        </div>
                        <span class="px-2.5 sm:px-3 py-1 rounded-full bg-rail-100 text-rail-700 text-[11px] sm:text-xs font-bold">Baja Konstruksi</span>
                    </div>
                    <div class="flex items-center justify-between p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-zinc-50 border border-zinc-100 text-xs sm:text-sm">
                        <div class="flex items-center gap-2.5 sm:gap-3">
                            <i class="fa-solid fa-road text-rail-500"></i>
                            <span class="font-semibold text-zinc-700">Plat Dek</span>
                        </div>
                        <span class="px-2.5 sm:px-3 py-1 rounded-full bg-rail-100 text-rail-700 text-[11px] sm:text-xs font-bold">Bordes Aluminium</span>
                    </div>
                    <div class="flex items-center justify-between p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-zinc-50 border border-zinc-100 text-xs sm:text-sm">
                        <div class="flex items-center gap-2.5 sm:gap-3">
                            <i class="fa-solid fa-shield text-rail-500"></i>
                            <span class="font-semibold text-zinc-700">Pagar Pengaman</span>
                        </div>
                        <span class="px-2.5 sm:px-3 py-1 rounded-full bg-rail-100 text-rail-700 text-[11px] sm:text-xs font-bold">Besi Hollow 1000mm</span>
                    </div>
                    <div class="flex items-center justify-between p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-zinc-50 border border-zinc-100 text-xs sm:text-sm">
                        <div class="flex items-center gap-2.5 sm:gap-3">
                            <i class="fa-solid fa-gears text-rail-500"></i>
                            <span class="font-semibold text-zinc-700">Roda In-Wheel</span>
                        </div>
                        <span class="px-2.5 sm:px-3 py-1 rounded-full bg-rail-100 text-rail-700 text-[11px] sm:text-xs font-bold">Flensa Baja + Nylon</span>
                    </div>
                    <div class="flex items-center justify-between p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-zinc-50 border border-zinc-100 text-xs sm:text-sm">
                        <div class="flex items-center gap-2.5 sm:gap-3">
                            <i class="fa-solid fa-droplet-slash text-rail-500"></i>
                            <span class="font-semibold text-zinc-700">Ketahanan Cuaca</span>
                        </div>
                        <span class="px-2.5 sm:px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[11px] sm:text-xs font-bold">Anti-Korosi Coating</span>
                    </div>
                </div>
            </div>

            <!-- Durabilitas Sprayer -->
            <div class="bento-card bg-white rounded-2xl sm:rounded-[32px] p-5 sm:p-8 border border-zinc-200/80 shadow-sm space-y-5 sm:space-y-6">
                <div class="flex items-center gap-3.5 sm:gap-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl sm:rounded-2xl bg-rail-500 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-spray-can text-white text-lg sm:text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg sm:text-xl font-extrabold text-zinc-900">Durabilitas Sprayer</h3>
                        <span class="text-[11px] sm:text-xs font-mono text-zinc-400 font-bold">AIRLESS SPRAY SYSTEM</span>
                    </div>
                </div>

                <div class="space-y-3 sm:space-y-4">
                    <div class="flex items-center justify-between p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-zinc-50 border border-zinc-100 text-xs sm:text-sm">
                        <div class="flex items-center gap-2.5 sm:gap-3">
                            <i class="fa-solid fa-wind text-rail-500"></i>
                            <span class="font-semibold text-zinc-700">Mesin Pompa</span>
                        </div>
                        <span class="px-2.5 sm:px-3 py-1 rounded-full bg-rail-100 text-rail-700 text-[11px] sm:text-xs font-bold">Möllar Airless</span>
                    </div>
                    <div class="flex items-center justify-between p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-zinc-50 border border-zinc-100 text-xs sm:text-sm">
                        <div class="flex items-center gap-2.5 sm:gap-3">
                            <i class="fa-solid fa-gauge text-rail-500"></i>
                            <span class="font-semibold text-zinc-700">Tekanan Operasi</span>
                        </div>
                        <span class="px-2.5 sm:px-3 py-1 rounded-full bg-rail-100 text-rail-700 text-[11px] sm:text-xs font-bold">3000 PSI Max</span>
                    </div>
                    <div class="flex items-center justify-between p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-zinc-50 border border-zinc-100 text-xs sm:text-sm">
                        <div class="flex items-center gap-2.5 sm:gap-3">
                            <i class="fa-solid fa-diagram-project text-rail-500"></i>
                            <span class="font-semibold text-zinc-700">Nozzle</span>
                        </div>
                        <span class="px-2.5 sm:px-3 py-1 rounded-full bg-rail-100 text-rail-700 text-[11px] sm:text-xs font-bold">4x Airless Tip</span>
                    </div>
                    <div class="flex items-center justify-between p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-zinc-50 border border-zinc-100 text-xs sm:text-sm">
                        <div class="flex items-center gap-2.5 sm:gap-3">
                            <i class="fa-solid fa-pipe-section text-rail-500"></i>
                            <span class="font-semibold text-zinc-700">Selang</span>
                        </div>
                        <span class="px-2.5 sm:px-3 py-1 rounded-full bg-rail-100 text-rail-700 text-[11px] sm:text-xs font-bold">High-Pressure Hose</span>
                    </div>
                    <div class="flex items-center justify-between p-3 sm:p-4 rounded-xl sm:rounded-2xl bg-zinc-50 border border-zinc-100 text-xs sm:text-sm">
                        <div class="flex items-center gap-2.5 sm:gap-3">
                            <i class="fa-solid fa-filter text-rail-500"></i>
                            <span class="font-semibold text-zinc-700">Drain Valve</span>
                        </div>
                        <span class="px-2.5 sm:px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[11px] sm:text-xs font-bold">Solenoid Auto-Flush</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================================================================== -->
    <!-- SECTION 04: PERFORMA SPRAYER (10 Liter → 630m)                        -->
    <!-- ===================================================================== -->
    <section id="performa" class="space-y-6 sm:space-y-10">
        <div class="flex items-start sm:items-center justify-between gap-3 sm:gap-4">
            <div class="flex flex-col sm:flex-row sm:items-baseline gap-1 sm:gap-4 md:gap-6">
                <span class="text-[11px] sm:text-xs font-mono text-zinc-400 font-bold uppercase">04 / PERFORMA SPRAYER</span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-zinc-900 leading-tight">Performa Penyemprotan</h2>
            </div>
            <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-zinc-900 text-rail-400 flex items-center justify-center font-bold flex-shrink-0 text-sm sm:text-base shadow-sm">
                <i class="fa-solid fa-spray-can-sparkles"></i>
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-6">
            <!-- Big Stat Card -->
            <div class="lg:col-span-5 bento-card bg-gradient-to-br from-rail-500 via-rail-600 to-rail-700 rounded-2xl sm:rounded-[32px] p-6 sm:p-8 md:p-10 text-white shadow-2xl shadow-rail-500/30 flex flex-col justify-between min-h-[320px] sm:min-h-[380px] relative overflow-hidden">
                <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-white/5 rounded-full pointer-events-none"></div>
                <div class="absolute top-10 right-10 w-24 h-24 bg-white/5 rounded-full pointer-events-none"></div>

                <div class="relative">
                    <span class="inline-block px-3 py-1 rounded-full bg-white/20 text-[11px] sm:text-xs font-mono font-bold tracking-wider uppercase mb-3 sm:mb-4">Kapasitas Cat</span>
                    <div class="text-6xl sm:text-7xl md:text-8xl font-extrabold tracking-tight leading-none">10</div>
                    <span class="text-xl sm:text-2xl font-bold text-rail-100">Liter</span>
                </div>

                <div class="relative mt-6 sm:mt-auto pt-4">
                    <div class="flex items-end gap-2">
                        <i class="fa-solid fa-arrow-right text-rail-200 text-xl sm:text-2xl mb-1"></i>
                        <span class="text-4xl sm:text-5xl md:text-6xl font-extrabold leading-none">630</span>
                        <span class="text-lg sm:text-xl font-bold text-rail-100 pb-0.5">meter</span>
                    </div>
                    <p class="text-xs sm:text-sm text-rail-100 mt-2 leading-relaxed">Jangkauan pengecatan dengan satu kali isi tangki penuh.</p>
                </div>
            </div>

            <!-- Detail Cards -->
            <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-3.5 sm:gap-5">
                <div class="bento-card bg-white rounded-2xl sm:rounded-[28px] p-5 sm:p-6 border border-zinc-200/80 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-rail-100 flex items-center justify-center mb-3 sm:mb-4">
                            <i class="fa-solid fa-droplet text-rail-600 text-base sm:text-lg"></i>
                        </div>
                        <h4 class="font-extrabold text-zinc-900 text-base sm:text-lg">4 Nozzle Aktif</h4>
                        <p class="text-xs text-zinc-500 mt-2 leading-relaxed">Menyemprot 2 rel sekaligus (kiri & kanan) melalui konfigurasi manifold Tee & Y pneumatik presisi.</p>
                    </div>
                </div>

                <div class="bento-card bg-white rounded-2xl sm:rounded-[28px] p-5 sm:p-6 border border-zinc-200/80 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-rail-100 flex items-center justify-center mb-3 sm:mb-4">
                            <i class="fa-solid fa-ruler text-rail-600 text-base sm:text-lg"></i>
                        </div>
                        <h4 class="font-extrabold text-zinc-900 text-base sm:text-lg">Lebar Semprotan</h4>
                        <p class="text-xs text-zinc-500 mt-2 leading-relaxed">Setiap nozzle menghasilkan fan pattern yang menutupi permukaan atas dan sisi rel R54-70.</p>
                    </div>
                </div>

                <div class="bento-card bg-white rounded-2xl sm:rounded-[28px] p-5 sm:p-6 border border-zinc-200/80 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-rail-100 flex items-center justify-center mb-3 sm:mb-4">
                            <i class="fa-solid fa-gauge-high text-rail-600 text-base sm:text-lg"></i>
                        </div>
                        <h4 class="font-extrabold text-zinc-900 text-base sm:text-lg">Tekanan Tinggi</h4>
                        <p class="text-xs text-zinc-500 mt-2 leading-relaxed">Pompa airless Möllar menghasilkan tekanan hingga 3000 PSI untuk atomisasi cat optimal.</p>
                    </div>
                </div>

                <div class="bento-card bg-white rounded-2xl sm:rounded-[28px] p-5 sm:p-6 border border-zinc-200/80 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-emerald-100 flex items-center justify-center mb-3 sm:mb-4">
                            <i class="fa-solid fa-chart-line text-emerald-600 text-base sm:text-lg"></i>
                        </div>
                        <h4 class="font-extrabold text-zinc-900 text-base sm:text-lg">Efisiensi 300%</h4>
                        <p class="text-xs text-zinc-500 mt-2 leading-relaxed">3x lebih cepat dibandingkan pengecatan manual konvensional dengan hasil distribusi cat yang merata.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================================================================== -->
    <!-- SECTION 05: MOTOR 750 WATT × 2                                        -->
    <!-- ===================================================================== -->
    <section id="motor" class="space-y-6 sm:space-y-10">
        <div class="flex items-start sm:items-center justify-between gap-3 sm:gap-4">
            <div class="flex flex-col sm:flex-row sm:items-baseline gap-1 sm:gap-4 md:gap-6">
                <span class="text-[11px] sm:text-xs font-mono text-zinc-400 font-bold uppercase">05 / MOTOR PENGGERAK</span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-zinc-900 leading-tight">Motor 750W × 2</h2>
            </div>
            <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-zinc-900 text-rail-400 flex items-center justify-center font-bold flex-shrink-0 text-sm sm:text-base shadow-sm">
                <i class="fa-solid fa-gear"></i>
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-6">
            <!-- Motor Illustration Card -->
            <div class="lg:col-span-7 bento-card bg-zinc-900 rounded-2xl sm:rounded-[32px] p-6 sm:p-8 md:p-10 text-white shadow-2xl relative overflow-hidden min-h-[340px] sm:min-h-[400px] flex flex-col justify-between">
                <div class="absolute inset-0 opacity-5" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.4&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                
                <div class="relative">
                    <span class="inline-block px-3 py-1 rounded-full bg-rail-500/20 border border-rail-500/30 text-rail-300 text-[11px] sm:text-xs font-mono font-bold uppercase mb-4 sm:mb-6">BLDC Hub Motor v5</span>
                    
                    <div class="flex items-baseline gap-2 sm:gap-3">
                        <span class="text-6xl sm:text-8xl md:text-9xl font-extrabold tracking-tighter text-white">2<span class="text-rail-500">×</span></span>
                        <div>
                            <div class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white">750<span class="text-lg sm:text-xl text-zinc-400 ml-1">W</span></div>
                            <span class="text-xs sm:text-sm text-zinc-400 font-medium">Total Daya: 1500 Watt</span>
                        </div>
                    </div>
                </div>

                <div class="relative grid grid-cols-3 gap-2 sm:gap-3 mt-6 sm:mt-8">
                    <div class="p-2.5 sm:p-4 rounded-xl sm:rounded-2xl bg-white/5 border border-white/10 text-center sm:text-left">
                        <span class="text-[9px] sm:text-[10px] font-mono text-zinc-500 block mb-0.5 sm:mb-1 font-bold">TIPE</span>
                        <span class="text-xs sm:text-sm font-bold text-white">BLDC Hub</span>
                    </div>
                    <div class="p-2.5 sm:p-4 rounded-xl sm:rounded-2xl bg-white/5 border border-white/10 text-center sm:text-left">
                        <span class="text-[9px] sm:text-[10px] font-mono text-zinc-500 block mb-0.5 sm:mb-1 font-bold">POSISI</span>
                        <span class="text-xs sm:text-sm font-bold text-white">Belakang</span>
                    </div>
                    <div class="p-2.5 sm:p-4 rounded-xl sm:rounded-2xl bg-white/5 border border-white/10 text-center sm:text-left">
                        <span class="text-[9px] sm:text-[10px] font-mono text-zinc-500 block mb-0.5 sm:mb-1 font-bold">KONTROL</span>
                        <span class="text-xs sm:text-sm font-bold text-white">PWM Driver</span>
                    </div>
                </div>
            </div>

            <!-- Motor Detail Cards -->
            <div class="lg:col-span-5 space-y-3.5 sm:space-y-5">
                <div class="bento-card bg-white rounded-2xl sm:rounded-[28px] p-4 sm:p-6 border border-zinc-200/80 shadow-sm flex flex-col sm:flex-row items-start sm:items-center gap-3.5 sm:gap-4">
                    <img src="{{ asset($settings['motor_img_1'] ?? 'images/trolley/img4_motor_handbrake.jpeg') }}" class="w-full sm:w-28 h-40 sm:h-28 rounded-xl sm:rounded-2xl object-cover flex-shrink-0" alt="Motor BLDC">
                    <div class="space-y-1">
                        <span class="text-[9px] sm:text-[10px] font-mono uppercase px-2 py-0.5 rounded bg-rail-100 text-rail-700 font-bold">Motor v5</span>
                        <h4 class="font-bold text-sm sm:text-base text-zinc-900">BLDC Hub Motor 200mm</h4>
                        <p class="text-xs text-zinc-500 leading-relaxed">Motor brushless DC terintegrasi di dalam roda untuk efisiensi tinggi & minim perawatan.</p>
                    </div>
                </div>

                <div class="bento-card bg-white rounded-2xl sm:rounded-[28px] p-4 sm:p-6 border border-zinc-200/80 shadow-sm flex flex-col sm:flex-row items-start sm:items-center gap-3.5 sm:gap-4">
                    <img src="{{ asset($settings['motor_img_2'] ?? 'images/trolley/img5_rear_wheels.jpeg') }}" class="w-full sm:w-28 h-40 sm:h-28 rounded-xl sm:rounded-2xl object-cover flex-shrink-0" alt="Roda In-Wheel">
                    <div class="space-y-1">
                        <span class="text-[9px] sm:text-[10px] font-mono uppercase px-2 py-0.5 rounded bg-rail-100 text-rail-700 font-bold">In-Wheel v10</span>
                        <h4 class="font-bold text-sm sm:text-base text-zinc-900">Dual Rear-Wheel Drive</h4>
                        <p class="text-xs text-zinc-500 leading-relaxed">Konfigurasi 2-motor belakang memberikan traksi optimal di rel basah maupun berkarat.</p>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-rail-50 to-amber-50 rounded-2xl sm:rounded-[28px] p-4 sm:p-6 border border-rail-200/60 space-y-2.5 sm:space-y-3">
                    <h4 class="font-extrabold text-zinc-900 flex items-center gap-2 text-xs sm:text-sm">
                        <i class="fa-solid fa-bolt text-rail-500"></i>
                        <span>Keunggulan BLDC Motor</span>
                    </h4>
                    <ul class="space-y-1.5 sm:space-y-2 text-xs text-zinc-600">
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-check-circle text-emerald-500 mt-0.5 flex-shrink-0"></i>
                            <span>Tanpa sikat (brushless) — umur panjang & minim perawatan</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-check-circle text-emerald-500 mt-0.5 flex-shrink-0"></i>
                            <span>Efisiensi energi >90% untuk jangkauan baterai maksimal</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-check-circle text-emerald-500 mt-0.5 flex-shrink-0"></i>
                            <span>Torsi tinggi pada putaran rendah — respons start stabil</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================================================================== -->
    <!-- SECTION 06: BATERAI 58V 15AH                                          -->
    <!-- ===================================================================== -->
    <section id="baterai" class="space-y-6 sm:space-y-10">
        <div class="flex items-start sm:items-center justify-between gap-3 sm:gap-4">
            <div class="flex flex-col sm:flex-row sm:items-baseline gap-1 sm:gap-4 md:gap-6">
                <span class="text-[11px] sm:text-xs font-mono text-zinc-400 font-bold uppercase">06 / BATERAI</span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-zinc-900 leading-tight">Baterai 58V 15Ah</h2>
            </div>
            <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-zinc-900 text-rail-400 flex items-center justify-center font-bold flex-shrink-0 text-sm sm:text-base shadow-sm">
                <i class="fa-solid fa-battery-full"></i>
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-6">
            <!-- Battery Visual -->
            <div class="lg:col-span-6 bento-card relative rounded-2xl sm:rounded-[32px] overflow-hidden min-h-[320px] sm:min-h-[400px] shadow-lg group">
                <img src="{{ asset($settings['battery_image'] ?? 'images/trolley/img1_pump_battery.jpeg') }}" alt="Baterai HI 102" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/85 via-zinc-950/20 to-zinc-950/30"></div>
                
                <div class="absolute top-4 right-4 sm:top-5 sm:right-5 flex gap-2">
                    <span class="px-2.5 sm:px-3 py-1 rounded-full bg-emerald-500/90 text-white text-[11px] sm:text-xs font-bold shadow"><i class="fa-solid fa-leaf mr-1"></i>Lithium-Ion</span>
                </div>

                <div class="absolute bottom-4 left-4 right-4 sm:bottom-6 sm:left-6 sm:right-6">
                    <div class="bg-zinc-900/80 backdrop-blur-xl rounded-xl sm:rounded-2xl p-3.5 sm:p-5 border border-white/20">
                        <div class="grid grid-cols-3 gap-2 sm:gap-4 text-center">
                            <div>
                                <span class="text-2xl sm:text-3xl font-extrabold text-white">58</span>
                                <span class="text-[10px] sm:text-xs text-zinc-300 block">Volt</span>
                            </div>
                            <div>
                                <span class="text-2xl sm:text-3xl font-extrabold text-rail-300">15</span>
                                <span class="text-[10px] sm:text-xs text-zinc-300 block">Ampere-hour</span>
                            </div>
                            <div>
                                <span class="text-2xl sm:text-3xl font-extrabold text-white">870</span>
                                <span class="text-[10px] sm:text-xs text-zinc-300 block">Watt-hour</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Battery Specs -->
            <div class="lg:col-span-6 space-y-3.5 sm:space-y-5">
                <div class="bento-card bg-white rounded-2xl sm:rounded-[28px] p-4 sm:p-6 border border-zinc-200/80 shadow-sm">
                    <div class="flex items-center justify-between mb-3 sm:mb-4">
                        <h4 class="font-extrabold text-zinc-900 text-sm sm:text-base">Konfigurasi Dual Battery</h4>
                        <span class="px-2.5 sm:px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[11px] sm:text-xs font-bold">2 × Pack</span>
                    </div>
                    <p class="text-xs text-zinc-500 leading-relaxed mb-3 sm:mb-4">Sistem baterai ganda di bawah kedua kursi operator untuk distribusi berat simetris dan kapasitas berlipat.</p>
                    
                    <div class="grid grid-cols-2 gap-2 sm:gap-3">
                        <div class="p-2.5 sm:p-3 rounded-xl sm:rounded-2xl bg-zinc-50 border border-zinc-200">
                            <span class="text-zinc-400 block text-[9px] sm:text-[10px] font-mono font-bold">TEGANGAN</span>
                            <span class="font-bold text-zinc-900 text-base sm:text-lg">58V</span>
                        </div>
                        <div class="p-2.5 sm:p-3 rounded-xl sm:rounded-2xl bg-zinc-50 border border-zinc-200">
                            <span class="text-zinc-400 block text-[9px] sm:text-[10px] font-mono font-bold">KAPASITAS</span>
                            <span class="font-bold text-zinc-900 text-base sm:text-lg">15Ah</span>
                        </div>
                        <div class="p-2.5 sm:p-3 rounded-xl sm:rounded-2xl bg-zinc-50 border border-zinc-200">
                            <span class="text-zinc-400 block text-[9px] sm:text-[10px] font-mono font-bold">ENERGI</span>
                            <span class="font-bold text-zinc-900 text-base sm:text-lg">870Wh</span>
                        </div>
                        <div class="p-2.5 sm:p-3 rounded-xl sm:rounded-2xl bg-zinc-50 border border-zinc-200">
                            <span class="text-zinc-400 block text-[9px] sm:text-[10px] font-mono font-bold">JENIS SEL</span>
                            <span class="font-bold text-zinc-900 text-base sm:text-lg">Li-Ion</span>
                        </div>
                    </div>
                </div>

                <div class="bento-card bg-white rounded-2xl sm:rounded-[28px] p-4 sm:p-6 border border-zinc-200/80 shadow-sm">
                    <h4 class="font-extrabold text-zinc-900 mb-3 sm:mb-4 flex items-center gap-2 text-xs sm:text-sm">
                        <i class="fa-solid fa-microchip text-rail-500"></i>
                        <span>Battery Management System (BMS)</span>
                    </h4>
                    <div class="space-y-2 sm:space-y-2.5 text-xs text-zinc-600">
                        <div class="flex items-center gap-2.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 flex-shrink-0"></span>
                            <span>Proteksi Overcharge & Overdischarge otomatis</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 flex-shrink-0"></span>
                            <span>Monitoring suhu real-time (BMS + Thermometer)</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 flex-shrink-0"></span>
                            <span>Cell balancing untuk ketahanan umur baterai panjang</span>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-emerald-50 to-cyan-50 rounded-2xl sm:rounded-[28px] p-4 sm:p-5 border border-emerald-200/60 flex items-center gap-3.5 sm:gap-4">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-emerald-500 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-plug text-white text-base sm:text-lg"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-zinc-900 text-xs sm:text-sm">Charging Time</h4>
                        <p class="text-xs text-zinc-500">Full charge ± 4 jam menggunakan charger standar 58V Li-Ion.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

<!-- ========================================================================= -->
<!-- MARQUEE TEXT BANNER (PERSIS REFERENSI DESAIN)                             -->
<!-- ========================================================================= -->
<div class="my-10 sm:my-16 lg:my-20 py-4 sm:py-8 border-y border-zinc-200 bg-white overflow-hidden">
    <div class="animate-marquee">
        <span class="text-2xl sm:text-4xl md:text-6xl font-extrabold tracking-tight text-zinc-900 mx-3 sm:mx-4">
            {{ $settings['marquee_text'] ?? 'HI 102 — Partner In Railway Maintenance Innovation ❖ Electric Trolley Machine for Rail Painting ❖ ' }}
        </span>
        <span class="text-2xl sm:text-4xl md:text-6xl font-extrabold tracking-tight text-rail-500 mx-3 sm:mx-4">
            {{ $settings['marquee_text'] ?? 'HI 102 — Partner In Railway Maintenance Innovation ❖ Electric Trolley Machine for Rail Painting ❖ ' }}
        </span>
    </div>
</div>

<div class="max-w-[1400px] mx-auto px-3 sm:px-6 lg:px-8 space-y-12 sm:space-y-16 lg:space-y-20">

    <!-- ===================================================================== -->
    <!-- SECTION 07: BAGIAN-BAGIAN TROLLEY (KOMPONEN & FOTO IMPLEMENTASI)      -->
    <!-- ===================================================================== -->
    <section id="komponen" class="space-y-6 sm:space-y-8">
        <div class="flex items-start sm:items-center justify-between gap-3 sm:gap-4">
            <div class="flex flex-col sm:flex-row sm:items-baseline gap-1 sm:gap-4 md:gap-6">
                <span class="text-[11px] sm:text-xs font-mono text-zinc-400 font-bold uppercase">07 / BAGIAN-BAGIAN TROLLEY</span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-zinc-900 leading-tight">Komponen & Implementasi</h2>
            </div>
            <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-zinc-900 text-rail-400 flex items-center justify-center font-bold flex-shrink-0 text-sm sm:text-base shadow-sm">
                <i class="fa-solid fa-cubes"></i>
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @foreach($components as $index => $comp)
            <div class="bento-card bg-white rounded-2xl sm:rounded-[28px] overflow-hidden border border-zinc-200/80 shadow-sm flex flex-col justify-between {{ $index === 0 ? 'sm:col-span-2 lg:col-span-2' : '' }}">
                <div>
                    <div class="relative h-48 sm:h-64 overflow-hidden bg-zinc-100">
                        <img src="{{ asset($comp->image_path) }}" alt="{{ $comp->name }}" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                        <div class="absolute top-2.5 left-2.5 sm:top-3 sm:left-3 flex flex-wrap gap-1.5 sm:gap-2">
                            <span class="px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full bg-zinc-900/85 backdrop-blur-md text-white text-[10px] sm:text-[11px] font-semibold">
                                {{ $comp->category }}
                            </span>
                            @if($comp->code)
                            <span class="px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full bg-rail-500 text-white text-[10px] sm:text-[11px] font-mono font-bold">
                                {{ $comp->code }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="p-4 sm:p-6 space-y-1.5 sm:space-y-2">
                        <h3 class="text-base sm:text-lg font-extrabold text-zinc-900">{{ $comp->name }}</h3>
                        <p class="text-xs text-zinc-500 leading-relaxed">{{ $comp->description }}</p>
                    </div>
                </div>
                <div class="px-4 sm:px-6 pb-4 sm:pb-5 pt-3 border-t border-zinc-100 flex items-center justify-between text-[11px] sm:text-xs font-mono text-zinc-500">
                    <span class="truncate max-w-[200px]">{{ $comp->specification }}</span>
                    <span class="text-rail-600 font-bold flex-shrink-0">#0{{ $index + 1 }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- ===================================================================== -->
    <!-- ===================================================================== -->
    <!-- SECTION 08: PENGUJIAN TROLLEY (5 VIDEO)                               -->
    <!-- ===================================================================== -->
    <section id="pengujian" class="space-y-6 sm:space-y-10">
        <div class="flex items-start sm:items-center justify-between gap-3 sm:gap-4">
            <div class="flex flex-col sm:flex-row sm:items-baseline gap-1 sm:gap-4 md:gap-6">
                <span class="text-[11px] sm:text-xs font-mono text-zinc-400 font-bold uppercase">08 / PENGUJIAN TROLLEY</span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-zinc-900 leading-tight">Video Pengujian Trolley</h2>
            </div>
            <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-zinc-900 text-rail-400 flex items-center justify-center font-bold flex-shrink-0 text-sm sm:text-base shadow-sm">
                <i class="fa-solid fa-video"></i>
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @php
                $vLurus = $videos['lurus'] ?? null;
                $vBelok = $videos['belok'] ?? null;
                $vWessel = $videos['wessel'] ?? null;
                $vRelpaksa = $videos['relpaksa'] ?? null;
                $vMundur = $videos['mundur'] ?? null;
            @endphp

            <!-- Jalan Lurus 3 Mode (Lebar 2 Kolom) -->
            <div class="bento-card bg-white rounded-2xl sm:rounded-[28px] overflow-hidden border border-zinc-200/80 shadow-sm sm:col-span-2 lg:col-span-2">
                <div class="relative bg-zinc-900 aspect-video flex items-center justify-center overflow-hidden group" id="video-container-lurus">
                    @if($vLurus && $vLurus->poster_image)
                        <img src="{{ asset($vLurus->poster_image) }}" alt="Poster {{ $vLurus->title }}" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:scale-105 transition duration-700">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/85 via-zinc-950/30 to-zinc-950/60 pointer-events-none z-10"></div>
                    
                    <div class="relative z-20 text-center space-y-3 sm:space-y-4 group-hover:scale-105 transition duration-500">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-rail-500/90 flex items-center justify-center mx-auto shadow-2xl shadow-rail-500/50 cursor-pointer hover:bg-rail-600 active:scale-95 transition" onclick="playVideo('lurus')">
                            <i class="fa-solid fa-play text-white text-xl sm:text-2xl ml-1"></i>
                        </div>
                        <div class="space-y-1">
                            <p class="text-white text-xs sm:text-sm font-bold">Putar Video Pengujian</p>
                            @if($vLurus && $vLurus->play_source)
                                <span class="px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full bg-emerald-500/90 text-white text-[10px] sm:text-[11px] font-bold tracking-wide shadow inline-flex items-center gap-1">
                                    <i class="fa-solid fa-circle-check"></i> Siap Diputar
                                </span>
                            @else
                                <span class="px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full bg-white/20 text-zinc-300 text-[10px] sm:text-[11px] font-mono inline-block">
                                    Belum Diunggah
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="p-4 sm:p-6">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full bg-rail-100 text-rail-700 text-[11px] sm:text-xs font-mono font-bold">{{ $vLurus->badge ?? 'UJI-01 • 3 Mode Kecepatan' }}</span>
                    </div>
                    <h3 class="text-lg sm:text-xl font-extrabold text-zinc-900">{{ $vLurus->title ?? 'Pengujian Jalan Lurus 3 Mode' }}</h3>
                    <p class="text-xs text-zinc-500 mt-1.5 sm:mt-2 leading-relaxed">{{ $vLurus->description ?? 'Trolley diuji pada rel lurus dengan mode kecepatan 1, 2, dan 3.' }}</p>
                </div>
            </div>

            <!-- Jalan Belok -->
            <div class="bento-card bg-white rounded-2xl sm:rounded-[28px] overflow-hidden border border-zinc-200/80 shadow-sm flex flex-col justify-between">
                <div class="relative bg-zinc-900 aspect-video flex items-center justify-center overflow-hidden group" id="video-container-belok">
                    @if($vBelok && $vBelok->poster_image)
                        <img src="{{ asset($vBelok->poster_image) }}" alt="Poster {{ $vBelok->title }}" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:scale-105 transition duration-700">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/85 via-transparent to-zinc-950/50 pointer-events-none z-10"></div>
                    <div class="relative z-20 text-center space-y-2.5">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-rail-500/90 flex items-center justify-center mx-auto shadow-xl shadow-rail-500/40 cursor-pointer hover:bg-rail-600 active:scale-95 transition" onclick="playVideo('belok')">
                            <i class="fa-solid fa-play text-white text-lg sm:text-xl ml-0.5"></i>
                        </div>
                    </div>
                </div>
                <div class="p-4 sm:p-5">
                    <span class="px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full bg-rail-100 text-rail-700 text-[11px] sm:text-xs font-mono font-bold">{{ $vBelok->badge ?? 'UJI-02' }}</span>
                    <h3 class="text-base sm:text-lg font-extrabold text-zinc-900 mt-2">{{ $vBelok->title ?? 'Jalan Belok' }}</h3>
                    <p class="text-xs text-zinc-500 mt-1 leading-relaxed">{{ $vBelok->description ?? 'Evaluasi stabilitas saat melewati tikungan rel.' }}</p>
                </div>
            </div>

            <!-- Jalan Lewat Wessel -->
            <div class="bento-card bg-white rounded-2xl sm:rounded-[28px] overflow-hidden border border-zinc-200/80 shadow-sm flex flex-col justify-between">
                <div class="relative bg-zinc-900 aspect-video flex items-center justify-center overflow-hidden group" id="video-container-wessel">
                    @if($vWessel && $vWessel->poster_image)
                        <img src="{{ asset($vWessel->poster_image) }}" alt="Poster {{ $vWessel->title }}" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:scale-105 transition duration-700">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/85 via-transparent to-zinc-950/50 pointer-events-none z-10"></div>
                    <div class="relative z-20 text-center space-y-2.5">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-rail-500/90 flex items-center justify-center mx-auto shadow-xl shadow-rail-500/40 cursor-pointer hover:bg-rail-600 active:scale-95 transition" onclick="playVideo('wessel')">
                            <i class="fa-solid fa-play text-white text-lg sm:text-xl ml-0.5"></i>
                        </div>
                    </div>
                </div>
                <div class="p-4 sm:p-5">
                    <span class="px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full bg-rail-100 text-rail-700 text-[11px] sm:text-xs font-mono font-bold">{{ $vWessel->badge ?? 'UJI-03' }}</span>
                    <h3 class="text-base sm:text-lg font-extrabold text-zinc-900 mt-2">{{ $vWessel->title ?? 'Lewat Wessel' }}</h3>
                    <p class="text-xs text-zinc-500 mt-1 leading-relaxed">{{ $vWessel->description ?? 'Kemampuan melewati wessel rel.' }}</p>
                </div>
            </div>

            <!-- Jalan Lewat Rel Paksa -->
            <div class="bento-card bg-white rounded-2xl sm:rounded-[28px] overflow-hidden border border-zinc-200/80 shadow-sm flex flex-col justify-between">
                <div class="relative bg-zinc-900 aspect-video flex items-center justify-center overflow-hidden group" id="video-container-relpaksa">
                    @if($vRelpaksa && $vRelpaksa->poster_image)
                        <img src="{{ asset($vRelpaksa->poster_image) }}" alt="Poster {{ $vRelpaksa->title }}" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:scale-105 transition duration-700">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/85 via-transparent to-zinc-950/50 pointer-events-none z-10"></div>
                    <div class="relative z-20 text-center space-y-2.5">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-amber-500/90 flex items-center justify-center mx-auto shadow-xl shadow-amber-500/40 cursor-pointer hover:bg-amber-600 active:scale-95 transition" onclick="playVideo('relpaksa')">
                            <i class="fa-solid fa-play text-white text-lg sm:text-xl ml-0.5"></i>
                        </div>
                    </div>
                </div>
                <div class="p-4 sm:p-5">
                    <span class="px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full bg-amber-100 text-amber-700 text-[11px] sm:text-xs font-mono font-bold">{{ $vRelpaksa->badge ?? 'UJI-04' }}</span>
                    <h3 class="text-base sm:text-lg font-extrabold text-zinc-900 mt-2">{{ $vRelpaksa->title ?? 'Lewat Rel Paksa' }}</h3>
                    <p class="text-xs text-zinc-500 mt-1 leading-relaxed">{{ $vRelpaksa->description ?? 'Ketahanan roda saat melewati sambungan rel paksa.' }}</p>
                </div>
            </div>

            <!-- Jalan Mundur -->
            <div class="bento-card bg-white rounded-2xl sm:rounded-[28px] overflow-hidden border border-zinc-200/80 shadow-sm flex flex-col justify-between">
                <div class="relative bg-zinc-900 aspect-video flex items-center justify-center overflow-hidden group" id="video-container-mundur">
                    @if($vMundur && $vMundur->poster_image)
                        <img src="{{ asset($vMundur->poster_image) }}" alt="Poster {{ $vMundur->title }}" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:scale-105 transition duration-700">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/85 via-transparent to-zinc-950/50 pointer-events-none z-10"></div>
                    <div class="relative z-20 text-center space-y-2.5">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-rail-500/90 flex items-center justify-center mx-auto shadow-xl shadow-rail-500/40 cursor-pointer hover:bg-rail-600 active:scale-95 transition" onclick="playVideo('mundur')">
                            <i class="fa-solid fa-play text-white text-lg sm:text-xl ml-0.5"></i>
                        </div>
                    </div>
                </div>
                <div class="p-4 sm:p-5">
                    <span class="px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full bg-rail-100 text-rail-700 text-[11px] sm:text-xs font-mono font-bold">{{ $vMundur->badge ?? 'UJI-05' }}</span>
                    <h3 class="text-base sm:text-lg font-extrabold text-zinc-900 mt-2">{{ $vMundur->title ?? 'Jalan Mundur' }}</h3>
                    <p class="text-xs text-zinc-500 mt-1 leading-relaxed">{{ $vMundur->description ?? 'Pengujian reverse drive & respons kontrol mundur.' }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================================================================== -->
    <!-- SECTION 09: VIDEO PENGUJIAN NGECAT                                    -->
    <!-- ===================================================================== -->
    @php
        $vNgecat = $videos['ngecat'] ?? null;
    @endphp
    <section id="video-ngecat" class="space-y-6 sm:space-y-10">
        <div class="flex items-start sm:items-center justify-between gap-3 sm:gap-4">
            <div class="flex flex-col sm:flex-row sm:items-baseline gap-1 sm:gap-4 md:gap-6">
                <span class="text-[11px] sm:text-xs font-mono text-zinc-400 font-bold uppercase">09 / PENGUJIAN PENGECATAN</span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-zinc-900 leading-tight">{{ $vNgecat->title ?? 'Video Pengujian Ngecat' }}</h2>
            </div>
            <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-zinc-900 text-rail-400 flex items-center justify-center font-bold flex-shrink-0 text-sm sm:text-base shadow-sm">
                <i class="fa-solid fa-paint-roller"></i>
            </span>
        </div>

        <div class="bento-card bg-white rounded-2xl sm:rounded-[32px] overflow-hidden border border-zinc-200/80 shadow-lg">
            <div class="relative bg-zinc-900 aspect-video flex items-center justify-center overflow-hidden group" id="video-container-ngecat">
                @if($vNgecat && $vNgecat->poster_image)
                    <img src="{{ asset($vNgecat->poster_image) }}" alt="Poster {{ $vNgecat->title }}" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:scale-105 transition duration-700">
                @endif

                <!-- Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/85 via-zinc-950/30 to-zinc-950/50 z-10 pointer-events-none"></div>
                
                <div class="relative z-20 text-center space-y-4 sm:space-y-6 group-hover:scale-105 transition duration-500 p-4">
                    <div class="w-18 h-18 sm:w-24 sm:h-24 rounded-full bg-rail-500/90 flex items-center justify-center mx-auto shadow-2xl shadow-rail-500/50 cursor-pointer hover:bg-rail-600 active:scale-95 transition ring-4 ring-rail-500/20" onclick="playVideo('ngecat')">
                        <i class="fa-solid fa-play text-white text-2xl sm:text-3xl ml-1 sm:ml-1.5"></i>
                    </div>
                    <div>
                        <p class="text-white text-base sm:text-lg font-bold">{{ $vNgecat->title ?? 'Pengujian Pengecatan Rel Kereta Api' }}</p>
                        <p class="text-zinc-300 text-xs sm:text-sm mt-1 max-w-lg mx-auto leading-relaxed">{{ $vNgecat->description ?? 'Demonstrasi sprayer airless 4-nozzle pada rel R54-70' }}</p>
                    </div>
                </div>

                <!-- Bottom Info Bar -->
                <div class="absolute bottom-0 left-0 right-0 z-20 p-3.5 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div class="flex items-center gap-2 sm:gap-3">
                            <span class="px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full bg-rail-500 text-white text-[10px] sm:text-xs font-bold">{{ $vNgecat->badge ?? 'LIVE TEST' }}</span>
                            @if($vNgecat && $vNgecat->play_source)
                                <span class="px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full bg-emerald-500/90 text-white text-[10px] sm:text-xs font-bold inline-flex items-center gap-1">
                                    <i class="fa-solid fa-circle-check"></i> Video Siap Diputar
                                </span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2 text-zinc-400 text-[11px] sm:text-xs font-mono">
                            <i class="fa-solid fa-circle text-red-500 animate-pulse text-[8px]"></i>
                            <span>Field Test Recording</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Below Video -->
            <div class="p-4 sm:p-8 grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6 border-t border-zinc-100">
                <div class="text-center">
                    <span class="text-2xl sm:text-3xl font-extrabold text-zinc-900">4</span>
                    <span class="text-[11px] sm:text-xs text-zinc-500 block mt-1 font-medium">Nozzle Airless Aktif</span>
                </div>
                <div class="text-center">
                    <span class="text-2xl sm:text-3xl font-extrabold text-rail-500">10L</span>
                    <span class="text-[11px] sm:text-xs text-zinc-500 block mt-1 font-medium">Kapasitas Tangki Cat</span>
                </div>
                <div class="text-center">
                    <span class="text-2xl sm:text-3xl font-extrabold text-zinc-900">630m</span>
                    <span class="text-[11px] sm:text-xs text-zinc-500 block mt-1 font-medium">Jarak Jangkauan</span>
                </div>
                <div class="text-center">
                    <span class="text-2xl sm:text-3xl font-extrabold text-emerald-500">86%</span>
                    <span class="text-[11px] sm:text-xs text-zinc-500 block mt-1 font-medium">Keseragaman Distribusi</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================================================================== -->
    <!-- SECTION 10: GRAFIK PERCOBAAN (LINE CHART REPRESENTATIVE)              -->
    <!-- ===================================================================== -->
    <section id="grafik" class="space-y-6 sm:space-y-10">
        <div class="flex items-start sm:items-center justify-between gap-3 sm:gap-4">
            <div class="flex flex-col sm:flex-row sm:items-baseline gap-1 sm:gap-4 md:gap-6">
                <span class="text-[11px] sm:text-xs font-mono text-zinc-400 font-bold uppercase">10 / GRAFIK PERCOBAAN</span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-zinc-900 leading-tight">Data Monitoring Real-Time</h2>
            </div>
            <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-zinc-900 text-rail-400 flex items-center justify-center font-bold flex-shrink-0 text-sm sm:text-base shadow-sm">
                <i class="fa-solid fa-chart-line"></i>
            </span>
        </div>

        <!-- Charts Container -->
        <div class="space-y-4 sm:space-y-6">
            <!-- Chart 1: Kecepatan (Tacho & Aplikasi RPM) -->
            <div class="bento-card bg-white rounded-2xl sm:rounded-[32px] p-4 sm:p-6 md:p-8 border border-zinc-200/80 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4 mb-4 sm:mb-6">
                    <div>
                        <span class="px-2.5 sm:px-3 py-1 rounded-full bg-zinc-900 text-white text-[10px] sm:text-xs font-mono font-bold">KECEPATAN</span>
                        <h3 class="text-base sm:text-xl font-extrabold text-zinc-900 mt-2">Kecepatan Alat Ukur (Tacho) & Kecepatan Aplikasi (RPM)</h3>
                    </div>
                    <div class="flex flex-wrap items-center gap-3 sm:gap-4 text-xs font-semibold text-zinc-600">
                        <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-[#f97316]"></span> Tacho (RPM)</span>
                        <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-[#3b82f6]"></span> Aplikasi (RPM)</span>
                    </div>
                </div>
                <div class="relative w-full h-[240px] sm:h-[300px] md:h-[350px]">
                    <canvas id="chart-kecepatan"></canvas>
                </div>
            </div>

            <!-- Chart 2: Tegangan & Arus Baterai -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
                <div class="bento-card bg-white rounded-2xl sm:rounded-[32px] p-4 sm:p-6 md:p-8 border border-zinc-200/80 shadow-sm">
                    <div class="flex items-center justify-between gap-4 mb-4 sm:mb-6">
                        <div>
                            <span class="px-2.5 sm:px-3 py-1 rounded-full bg-emerald-600 text-white text-[10px] sm:text-xs font-mono font-bold">TEGANGAN</span>
                            <h3 class="text-base sm:text-lg font-extrabold text-zinc-900 mt-2">V Baterai (Volt)</h3>
                        </div>
                    </div>
                    <div class="relative w-full h-[200px] sm:h-[240px] md:h-[280px]">
                        <canvas id="chart-voltage"></canvas>
                    </div>
                </div>

                <div class="bento-card bg-white rounded-2xl sm:rounded-[32px] p-4 sm:p-6 md:p-8 border border-zinc-200/80 shadow-sm">
                    <div class="flex items-center justify-between gap-4 mb-4 sm:mb-6">
                        <div>
                            <span class="px-2.5 sm:px-3 py-1 rounded-full bg-red-500 text-white text-[10px] sm:text-xs font-mono font-bold">ARUS</span>
                            <h3 class="text-base sm:text-lg font-extrabold text-zinc-900 mt-2">I Baterai (Ampere)</h3>
                        </div>
                    </div>
                    <div class="relative w-full h-[200px] sm:h-[240px] md:h-[280px]">
                        <canvas id="chart-current"></canvas>
                    </div>
                </div>
            </div>

            <!-- Chart 3: Temperatur Baterai -->
            <div class="bento-card bg-white rounded-2xl sm:rounded-[32px] p-4 sm:p-6 md:p-8 border border-zinc-200/80 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4 mb-4 sm:mb-6">
                    <div>
                        <span class="px-2.5 sm:px-3 py-1 rounded-full bg-amber-500 text-white text-[10px] sm:text-xs font-mono font-bold">TEMPERATUR</span>
                        <h3 class="text-base sm:text-xl font-extrabold text-zinc-900 mt-2">Suhu Baterai (°C)</h3>
                    </div>
                    <div class="flex flex-wrap items-center gap-3 sm:gap-4 text-xs font-semibold text-zinc-600">
                        <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-[#ef4444]"></span> BMS</span>
                        <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-[#f59e0b]"></span> Thermometer</span>
                        <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-[#8b5cf6]"></span> Controller</span>
                    </div>
                </div>
                <div class="relative w-full h-[220px] sm:h-[260px] md:h-[300px]">
                    <canvas id="chart-temperature"></canvas>
                </div>
            </div>

            <!-- Chart 4: Daya (Watt) -->
            <div class="bento-card bg-white rounded-2xl sm:rounded-[32px] p-4 sm:p-6 md:p-8 border border-zinc-200/80 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4 mb-4 sm:mb-6">
                    <div>
                        <span class="px-2.5 sm:px-3 py-1 rounded-full bg-violet-600 text-white text-[10px] sm:text-xs font-mono font-bold">DAYA</span>
                        <h3 class="text-base sm:text-xl font-extrabold text-zinc-900 mt-2">Konsumsi Daya (Watt)</h3>
                    </div>
                    <div class="flex items-center gap-4 text-xs font-semibold text-zinc-600">
                        <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-[#8b5cf6]"></span> Daya (W)</span>
                    </div>
                </div>
                <div class="relative w-full h-[220px] sm:h-[260px] md:h-[300px]">
                    <canvas id="chart-power"></canvas>
                </div>
            </div>
        </div>

        <!-- Data Table (Collapsible) -->
        <!-- <div x-data="{ showTable: false }" class="bento-card bg-white rounded-[32px] p-6 sm:p-8 border border-zinc-200/80 shadow-sm">
            <div class="flex items-center justify-between cursor-pointer" @click="showTable = !showTable">
                <div>
                    <span class="text-xs font-mono uppercase text-rail-600 font-bold">Data Mentah</span>
                    <h3 class="text-xl font-extrabold text-zinc-900">Tabel Lengkap Data Percobaan</h3>
                </div>
                <button class="w-10 h-10 rounded-full bg-zinc-100 flex items-center justify-center hover:bg-rail-100 transition">
                    <i class="fa-solid fa-chevron-down text-zinc-600 transition-transform" :class="showTable ? 'rotate-180' : ''"></i>
                </button>
            </div>

            <div x-show="showTable" x-collapse class="mt-6 overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="border-b border-zinc-200 text-xs font-mono uppercase text-zinc-400">
                            <th class="py-3 px-3 sticky left-0 bg-white">Waktu (min)</th>
                            <th class="py-3 px-3">Tacho (RPM)</th>
                            <th class="py-3 px-3">Aplikasi (RPM)</th>
                            <th class="py-3 px-3">V Baterai (V)</th>
                            <th class="py-3 px-3">I Baterai (A)</th>
                            <th class="py-3 px-3">T BMS (°C)</th>
                            <th class="py-3 px-3">T Thermo (°C)</th>
                            <th class="py-3 px-3">T Controller (°C)</th>
                            <th class="py-3 px-3">Mode</th>
                            <th class="py-3 px-3">Daya (W)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 font-mono text-xs">
                        @php
                        $tableData = [
                            [0, 0, '', 53.4, 0, 35.6, 40.9, 40, '', ''],
                            [1, 1200, 350, 53.1, 0.5, 35.1, 40.7, 40, '1', 13],
                            [2, 2400, 776, 53.2, 3, 35.7, 40.4, 40, '2', 169],
                            [3, 1700, 690, 53.2, 0.4, 35.8, 41.2, 40, '1', 13],
                            [4, 1200, 340, 53.1, 0.6, 35.9, 41.7, 40, '1', 13],
                            [5, 1057, 340, 53.1, 0.6, 35.9, 41.9, 40, '', 13],
                            [6, 2340, 770, 52.6, 4.9, 35.9, 41.8, 41, '2', 180],
                            [7, 2410, 770, 52.5, 5, 36, 41.6, 41, '2', 155],
                            [8, 1085, 330, 53.2, 0.6, 36, 42.1, 41, '', 13],
                            [9, 1145, 350, 53.1, 0.5, 36.1, 42.3, 41, '', 13],
                            [10, 1082, 340, 53.2, 0.5, 36.2, 42.2, 41, '', 13],
                            [11, 2336, 760, 52.6, 3, 36.2, 42, 41.8, '', 150],
                            [12, 2530, 750, 52.2, 3.3, 36.3, 42, 41.6, '', 140],
                            [13, 1110, 330, 53.1, 0.5, 36.3, 42, 41.2, '', ''],
                            [14, 920, 300, 53.1, 0.6, 36.4, 42, 40.6, '', 13],
                            [15, 1200, 370, 52.6, 0.6, 36.4, 42, 40.9, '', 13],
                            [16, 960, 550, 53.1, 0.46, 35.5, 43, 41.3, '', 13],
                            [17, 1270, 280, 53.6, 0.7, 36.1, 43, 41.4, '', 13],
                            [18, 1106, 350, 53.1, 0.6, 36.5, 43, 41.4, '', 13],
                            [19, 1131, 358, 53.1, 0.6, 36.6, 43, 41.4, '', 13],
                            [20, 2300, 350, 53.2, 0.6, 36.6, 43, 41.4, '', 13],
                            [21, 2154, 760, 52.6, 3.3, 36.7, 43, 40.9, '', 168],
                            [22, 1152, 377, 53.1, 0.9, 36.8, 43, 40.3, '', 13],
                            [23, 1097, 333, 53.1, 0.69, 36.8, 43, 40.2, '', 13],
                            [24, 1192, 325, 53.2, 0.6, 36.8, 43, 40.9, '', 13],
                            [25, 2663, 850, 52.7, 3, 36.9, 43, 41, '2', 130],
                            [26, 1063, 330, 53.1, 0.63, 36.9, 43, 41.4, '', 13],
                            [27, 1058, 340, 53.2, 0.6, 37, 43, 41.7, '', 13],
                            [28, '', '', 53.3, 0, 37, 43, 41.5, '', ''],
                        ];
                        @endphp
                        @foreach($tableData as $row)
                        <tr class="hover:bg-rail-50/40 transition">
                            <td class="py-2.5 px-3 font-bold text-zinc-900 sticky left-0 bg-white">{{ $row[0] }}</td>
                            <td class="py-2.5 px-3 text-zinc-700">{{ $row[1] !== '' ? $row[1] : '-' }}</td>
                            <td class="py-2.5 px-3 text-zinc-700">{{ $row[2] !== '' ? $row[2] : '-' }}</td>
                            <td class="py-2.5 px-3 text-emerald-600 font-semibold">{{ $row[3] }}</td>
                            <td class="py-2.5 px-3 text-red-600 font-semibold">{{ $row[4] }}</td>
                            <td class="py-2.5 px-3 text-amber-600">{{ $row[5] }}</td>
                            <td class="py-2.5 px-3 text-amber-600">{{ $row[6] }}</td>
                            <td class="py-2.5 px-3 text-violet-600">{{ $row[7] }}</td>
                            <td class="py-2.5 px-3">
                                @if($row[8] !== '')
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $row[8] == '2' ? 'bg-rail-100 text-rail-700' : 'bg-zinc-100 text-zinc-600' }}">
                                    Mode {{ $row[8] }}
                                </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="py-2.5 px-3 text-violet-600 font-semibold">{{ $row[9] !== '' ? $row[9] . 'W' : '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> -->
    </section>

    <!-- ===================================================================== -->
    <!-- SECTION: EVALUASI LAPANGAN & LINK KE HALAMAN TIM PENGEMBANG           -->
    <!-- ===================================================================== -->
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-10 items-center">
        <div class="lg:col-span-7 space-y-4 sm:space-y-6">
            <div class="flex items-center gap-3">
                <span class="text-xs font-mono text-zinc-400">VALIDASI</span>
                <span class="text-sm font-bold text-zinc-900">{{ $settings['review_rating'] ?? '4.9' }}</span>
                <div class="flex text-rail-500 text-xs gap-1">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                </div>
            </div>

            <blockquote class="text-lg sm:text-xl md:text-2xl font-bold text-zinc-900 leading-relaxed">
                {{ $settings['review_quote'] ?? '' }}
            </blockquote>

            <div>
                <div class="font-extrabold text-zinc-900 text-sm sm:text-base">{{ $settings['review_author'] ?? 'Tim Penguji Lapangan HI 102' }}</div>
                <div class="text-xs text-zinc-500">{{ $settings['review_role'] ?? 'Divisi Rekayasa & Perawatan Jalan Rel' }}</div>
            </div>
        </div>

        <div class="lg:col-span-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="rounded-2xl sm:rounded-3xl overflow-hidden h-52 sm:h-64 shadow-md border border-zinc-200">
                <img src="{{ asset($settings['review_image'] ?? 'images/trolley/img6_top_seat.jpeg') }}" class="w-full h-full object-cover" alt="Detail Mesin">
            </div>
            <div class="rounded-2xl sm:rounded-3xl bg-zinc-900 text-white p-5 sm:p-6 flex flex-col justify-between h-52 sm:h-64">
                <span class="w-10 h-10 rounded-2xl bg-rail-500 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-users text-white"></i>
                </span>
                <div class="space-y-1.5 sm:space-y-2">
                    <div class="text-xl sm:text-2xl font-extrabold">{{ $teamCount }} Engineer</div>
                    <p class="text-xs text-zinc-400">Kenali tim perancang mekanis, elektrikal, dan fluida di balik HI 102.</p>
                    <a href="{{ route('team') }}" class="inline-flex items-center gap-1.5 pt-2 text-xs font-bold text-rail-400 hover:text-rail-300">
                        <span>Lihat Tim Pengembang</span> <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

</div>

<!-- ========================================================================= -->
<!-- THREE.JS 3D ENGINE: REKONSTRUKSI CAD TROLLEY FULL ASM v14 (HI 102)        -->
<!-- ========================================================================= -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>

<!-- Chart.js for Data Visualization -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<script>
    let scene, camera, renderer, controls, trolleyGroup, sprayParticles = [];
    let sprayActive = true;

    function createDiamondPlateTexture() {
        const canvas = document.createElement('canvas');
        canvas.width = 128;
        canvas.height = 128;
        const ctx = canvas.getContext('2d');
        ctx.fillStyle = '#d4d4d8';
        ctx.fillRect(0, 0, 128, 128);
        ctx.fillStyle = '#a1a1aa';
        for (let y = 0; y < 128; y += 16) {
            for (let x = 0; x < 128; x += 16) {
                ctx.beginPath();
                ctx.ellipse(x + 4, y + 4, 4, 1.5, Math.PI / 4, 0, Math.PI * 2);
                ctx.fill();
                ctx.beginPath();
                ctx.ellipse(x + 12, y + 12, 4, 1.5, -Math.PI / 4, 0, Math.PI * 2);
                ctx.fill();
            }
        }
        const texture = new THREE.CanvasTexture(canvas);
        texture.wrapS = THREE.RepeatWrapping;
        texture.wrapT = THREE.RepeatWrapping;
        texture.repeat.set(10, 8);
        return texture;
    }

    function initHI102ThreeJS() {
        const container = document.getElementById('trolley-3d-canvas');
        if (!container) return;

        scene = new THREE.Scene();
        camera = new THREE.PerspectiveCamera(42, container.clientWidth / container.clientHeight, 0.1, 100);
        camera.position.set(2.4, 1.65, 2.5);

        renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
        renderer.setSize(container.clientWidth, container.clientHeight);
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        renderer.shadowMap.enabled = true;
        container.appendChild(renderer.domElement);

        controls = new THREE.OrbitControls(camera, renderer.domElement);
        controls.enableDamping = true;
        controls.dampingFactor = 0.05;
        controls.target.set(0, 0.45, 0);
        controls.maxPolarAngle = Math.PI / 2 - 0.02;
        controls.minDistance = 1.4;
        controls.maxDistance = 6.0;

        // Pencahayaan Studio Industri
        const ambientLight = new THREE.AmbientLight(0xffffff, 0.75);
        scene.add(ambientLight);

        const dirLight1 = new THREE.DirectionalLight(0xffffff, 1.1);
        dirLight1.position.set(4, 6, 4);
        dirLight1.castShadow = true;
        scene.add(dirLight1);

        const orangeRimLight = new THREE.PointLight(0xf97316, 1.5, 8);
        orangeRimLight.position.set(-2, 1.5, -2);
        scene.add(orangeRimLight);

        // Material Sesuai Implementasi Fisik & Layer DXF
        const matOrangeFrame = new THREE.MeshStandardMaterial({ color: 0xf59e0b, roughness: 0.3, metalness: 0.3 });
        const matBordes = new THREE.MeshStandardMaterial({
            color: 0xe4e4e7,
            roughness: 0.35,
            metalness: 0.75,
            bumpMap: createDiamondPlateTexture(),
            bumpScale: 0.015
        });
        const matStainless = new THREE.MeshStandardMaterial({ color: 0xd4d4d8, roughness: 0.25, metalness: 0.85 });
        const matBatteryBlack = new THREE.MeshStandardMaterial({ color: 0x18181b, roughness: 0.5, metalness: 0.2 });
        const matWheel = new THREE.MeshStandardMaterial({ color: 0xf4f4f5, roughness: 0.4, metalness: 0.1 });
        const matBlueHose = new THREE.MeshStandardMaterial({ color: 0x0284c7, roughness: 0.3, metalness: 0.1 });
        const matRailSteel = new THREE.MeshStandardMaterial({ color: 0x52525b, roughness: 0.5, metalness: 0.8 });

        trolleyGroup = new THREE.Group();
        scene.add(trolleyGroup);

        // 1. REL KERETA API R54-70 (Track Gauge 930mm -> X = -0.465m dan +0.465m)
        [-0.465, 0.465].forEach(xPos => {
            const railGeo = new THREE.BoxGeometry(0.06, 0.08, 3.6);
            const railMesh = new THREE.Mesh(railGeo, matRailSteel);
            railMesh.position.set(xPos, 0.04, 0);
            trolleyGroup.add(railMesh);
        });
        // Bantalan Rel
        for (let z = -1.5; z <= 1.5; z += 0.5) {
            const sleeper = new THREE.Mesh(new THREE.BoxGeometry(1.4, 0.03, 0.12), new THREE.MeshStandardMaterial({ color: 0x27272a }));
            sleeper.position.set(0, 0.015, z);
            trolleyGroup.add(sleeper);
        }

        // 2. 4 RODA IN-WHEEL 200 v10 & TROMOL (X = ±0.465, Z = ±0.38)
        const wheelPositions = [
            [-0.465, 0.18, 0.38], [0.465, 0.18, 0.38],
            [-0.465, 0.18, -0.38], [0.465, 0.18, -0.38]
        ];
        wheelPositions.forEach(([wx, wy, wz]) => {
            const wGroup = new THREE.Group();
            const wheelCyl = new THREE.Mesh(new THREE.CylinderGeometry(0.10, 0.10, 0.09, 28), matWheel);
            wheelCyl.rotation.z = Math.PI / 2;
            wGroup.add(wheelCyl);

            // Flensa roda
            const flange = new THREE.Mesh(new THREE.CylinderGeometry(0.12, 0.12, 0.015, 28), matWheel);
            flange.rotation.z = Math.PI / 2;
            flange.position.x = wx < 0 ? -0.04 : 0.04;
            wGroup.add(flange);

            // Hub Motor BLDC v5
            const hub = new THREE.Mesh(new THREE.CylinderGeometry(0.06, 0.06, 0.10, 20), matBatteryBlack);
            hub.rotation.z = Math.PI / 2;
            wGroup.add(hub);

            wGroup.position.set(wx, wy, wz);
            trolleyGroup.add(wGroup);
        });

        // 3. DEK UTAMA PLAT BORDES ALUMINIUM (1350mm x 1050mm -> 1.35m x 1.05m)
        const deckMesh = new THREE.Mesh(new THREE.BoxGeometry(1.35, 0.08, 1.05), matBordes);
        deckMesh.position.set(0, 0.28, 0);
        trolleyGroup.add(deckMesh);

        // Lampu Indikator Bumper (Merah & Oranye seperti Foto 5)
        [-0.35, 0, 0.35].forEach((lx, idx) => {
            const lampColor = idx === 1 ? 0xdc2626 : 0xf97316;
            const lamp = new THREE.Mesh(
                new THREE.SphereGeometry(0.02, 16, 16),
                new THREE.MeshBasicMaterial({ color: lampColor })
            );
            lamp.position.set(lx, 0.28, -0.53);
            trolleyGroup.add(lamp);
        });

        // 4. KURSI OPERATOR KIRI & KANAN (chair v1: Tinggi 430mm di atas dek, ukuran 380x380mm)
        [-0.44, 0.44].forEach(seatX => {
            // Dudukan Plat Aluminium
            const seatTop = new THREE.Mesh(new THREE.BoxGeometry(0.38, 0.025, 0.38), matStainless);
            seatTop.position.set(seatX, 0.72, -0.05);
            trolleyGroup.add(seatTop);

            // 4 Kaki Rangka Kursi Kuning-Oranye
            [[-0.17, -0.17], [0.17, -0.17], [-0.17, 0.17], [0.17, 0.17]].forEach(([dx, dz]) => {
                const leg = new THREE.Mesh(new THREE.CylinderGeometry(0.012, 0.012, 0.40, 12), matOrangeFrame);
                leg.position.set(seatX + dx, 0.52, -0.05 + dz);
                trolleyGroup.add(leg);
            });

            // Boks Baterai Hitam di Bawah Kursi (Baterai v1)
            const battery = new THREE.Mesh(new THREE.BoxGeometry(0.32, 0.18, 0.24), matBatteryBlack);
            battery.position.set(seatX, 0.41, -0.05);
            trolleyGroup.add(battery);
        });

        // 5. KONSOL TENGAH & PANEL KONTROL (Panel assembly v1#87)
        const consoleBox = new THREE.Mesh(new THREE.BoxGeometry(0.34, 0.32, 0.42), matStainless);
        consoleBox.position.set(0, 0.80, -0.10);
        trolleyGroup.add(consoleBox);

        // Kaki penyangga konsol tengah
        [[-0.15, -0.19], [0.15, -0.19], [-0.15, 0.19], [0.15, 0.19]].forEach(([cx, cz]) => {
            const cLeg = new THREE.Mesh(new THREE.CylinderGeometry(0.014, 0.014, 0.65, 12), matOrangeFrame);
            cLeg.position.set(cx, 0.64, -0.10 + cz);
            trolleyGroup.add(cLeg);
        });

        // Permukaan Panel Putih + Tombol E-Stop Merah & Tuas Gas
        const panelTop = new THREE.Mesh(
            new THREE.BoxGeometry(0.35, 0.015, 0.43),
            new THREE.MeshStandardMaterial({ color: 0xffffff })
        );
        panelTop.position.set(0, 0.965, -0.10);
        trolleyGroup.add(panelTop);

        // Tombol Mushroom Red E-Stop
        const eStop = new THREE.Mesh(
            new THREE.CylinderGeometry(0.025, 0.02, 0.03, 16),
            new THREE.MeshStandardMaterial({ color: 0xef4444 })
        );
        eStop.position.set(0.08, 0.99, -0.05);
        trolleyGroup.add(eStop);

        // Tombol Hijau Start
        const greenBtn = new THREE.Mesh(
            new THREE.CylinderGeometry(0.02, 0.02, 0.02, 16),
            new THREE.MeshStandardMaterial({ color: 0x22c55e })
        );
        greenBtn.position.set(0.08, 0.985, -0.15);
        trolleyGroup.add(greenBtn);

        // Tuas Throttle / Lever Handle
        const lever = new THREE.Mesh(new THREE.CylinderGeometry(0.008, 0.008, 0.16, 12), matBatteryBlack);
        lever.position.set(0, 1.05, -0.12);
        trolleyGroup.add(lever);

        // 6. MESIN POMPA AIRLESS MÖLLAR (mesin airless v7 di tengah dek)
        const motorBody = new THREE.Mesh(
            new THREE.BoxGeometry(0.22, 0.22, 0.26),
            new THREE.MeshStandardMaterial({ color: 0x1d4ed8, roughness: 0.4 })
        );
        motorBody.position.set(0, 0.43, 0.12);
        trolleyGroup.add(motorBody);

        const pumpHead = new THREE.Mesh(new THREE.CylinderGeometry(0.08, 0.08, 0.22, 20), matStainless);
        pumpHead.position.set(0, 0.45, 0.28);
        trolleyGroup.add(pumpHead);

        // Selang Hisap Hitam Melengkung (Foto 8)
        const curve = new THREE.CatmullRomCurve3([
            new THREE.Vector3(0, 0.56, 0.28),
            new THREE.Vector3(0.12, 0.78, 0.32),
            new THREE.Vector3(0.25, 0.60, 0.35),
            new THREE.Vector3(0.28, 0.34, 0.35)
        ]);
        const hoseGeo = new THREE.TubeGeometry(curve, 24, 0.018, 12, false);
        const suctionHose = new THREE.Mesh(hoseGeo, matBatteryBlack);
        trolleyGroup.add(suctionHose);

        // 7. PAGAR PENGAMAN 1000mm (pagar v1 & pagar 2 v1)
        const railHeight = 1.02;
        // Tiang Vertikal Depan & Belakang
        [[-0.64, 0.48], [0.64, 0.48], [0, 0.48], [-0.64, -0.48], [0.64, -0.48], [0, -0.48]].forEach(([px, pz]) => {
            const post = new THREE.Mesh(new THREE.CylinderGeometry(0.016, 0.016, 0.74, 16), matOrangeFrame);
            post.position.set(px, 0.65, pz);
            trolleyGroup.add(post);
        });
        // Palang Horizontal Atas Depan & Belakang
        [0.48, -0.48].forEach(pz => {
            const topBar = new THREE.Mesh(new THREE.CylinderGeometry(0.016, 0.016, 1.28, 16), matOrangeFrame);
            topBar.rotation.z = Math.PI / 2;
            topBar.position.set(0, railHeight, pz);
            trolleyGroup.add(topBar);
        });

        // 8. BENTANGAN 4-NOZZLE AIRLESS SPRAYER BOOM DI DEPAN (sprayer new assembly v2)
        const boomBar = new THREE.Mesh(new THREE.BoxGeometry(1.30, 0.025, 0.025), matOrangeFrame);
        boomBar.position.set(0, 0.24, 0.65);
        trolleyGroup.add(boomBar);

        // 4 Titik Nozzle (Menyemprot Sisi Kiri-Kanan Rel Kiri & Kanan)
        const nozzleXPositions = [-0.58, -0.35, 0.35, 0.58];
        nozzleXPositions.forEach(nx => {
            const nozzleMount = new THREE.Mesh(new THREE.CylinderGeometry(0.012, 0.012, 0.10, 12), matStainless);
            nozzleMount.position.set(nx, 0.19, 0.65);
            trolleyGroup.add(nozzleMount);

            // Selang Biru Melengkung ke Tiap Nozzle
            const bCurve = new THREE.CatmullRomCurve3([
                new THREE.Vector3(nx * 0.4, 0.30, 0.52),
                new THREE.Vector3(nx * 0.8, 0.28, 0.60),
                new THREE.Vector3(nx, 0.22, 0.65)
            ]);
            const bTube = new THREE.Mesh(new THREE.TubeGeometry(bCurve, 16, 0.008, 8, false), matBlueHose);
            trolleyGroup.add(bTube);

            // Partikel Kabut Semprotan Cat Oranye ke Rel
            const coneGeo = new THREE.ConeGeometry(0.09, 0.16, 16, 1, true);
            const coneMat = new THREE.MeshBasicMaterial({
                color: 0xf97316,
                transparent: true,
                opacity: 0.35,
                side: THREE.DoubleSide
            });
            const sprayCone = new THREE.Mesh(coneGeo, coneMat);
            sprayCone.position.set(nx, 0.09, 0.65);
            trolleyGroup.add(sprayCone);
            sprayParticles.push(sprayCone);
        });

        // Responsif saat ukuran layar berubah
        window.addEventListener('resize', () => {
            if (!container) return;
            camera.aspect = container.clientWidth / container.clientHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(container.clientWidth, container.clientHeight);
        });

        animate3D();
    }

    function animate3D() {
        requestAnimationFrame(animate3D);
        if (trolleyGroup) {
            trolleyGroup.rotation.y += 0.0025;
        }
        if (sprayActive) {
            const pulse = 0.25 + Math.sin(Date.now() * 0.008) * 0.15;
            sprayParticles.forEach(sp => {
                sp.visible = true;
                sp.material.opacity = pulse;
            });
        } else {
            sprayParticles.forEach(sp => sp.visible = false);
        }
        if (controls) controls.update();
        if (renderer && scene && camera) renderer.render(scene, camera);
    }

    function setCameraView(mode) {
        if (!camera || !controls) return;
        if (mode === 'front') {
            camera.position.set(0, 0.7, 2.6);
        } else if (mode === 'top') {
            camera.position.set(0, 3.2, 0.01);
        } else {
            camera.position.set(2.4, 1.65, 2.5);
        }
        controls.target.set(0, 0.45, 0);
        controls.update();
    }

    function toggleSprayAnimation() {
        sprayActive = !sprayActive;
        const btn = document.getElementById('btn-spray');
        if (btn) {
            btn.innerHTML = sprayActive 
                ? '<i class="fa-solid fa-droplet text-xs"></i> <span>Simulasi Semprot: ON</span>' 
                : '<i class="fa-solid fa-droplet-slash text-xs"></i> <span>Simulasi Semprot: OFF</span>';
        }
    }

    // =========================================================================
    // CHART.JS — GRAFIK PERCOBAAN (LINE REPRESENTATIVE)
    // =========================================================================
    function initCharts() {
        // Raw Data from Experiment
        const timeLabels = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28];
        const tachoData = [0,1200,2400,1700,1200,1057,2340,2410,1085,1145,1082,2336,2530,1110,920,1200,960,1270,1106,1131,2300,2154,1152,1097,1192,2663,1063,1058,null];
        const appRPM = [null,350,776,690,340,340,770,770,330,350,340,760,750,330,300,370,550,280,350,358,350,760,377,333,325,850,330,340,null];
        const voltage = [53.4,53.1,53.2,53.2,53.1,53.1,52.6,52.5,53.2,53.1,53.2,52.6,52.2,53.1,53.1,52.6,53.1,53.6,53.1,53.1,53.2,52.6,53.1,53.1,53.2,52.7,53.1,53.2,53.3];
        const current = [0,0.5,3,0.4,0.6,0.6,4.9,5,0.6,0.5,0.5,3,3.3,0.5,0.6,0.6,0.46,0.7,0.6,0.6,0.6,3.3,0.9,0.69,0.6,3,0.63,0.6,0];
        const tempBMS = [35.6,35.1,35.7,35.8,35.9,35.9,35.9,36,36,36.1,36.2,36.2,36.3,36.3,36.4,36.4,35.5,36.1,36.5,36.6,36.6,36.7,36.8,36.8,36.8,36.9,36.9,37,37];
        const tempThermo = [40.9,40.7,40.4,41.2,41.7,41.9,41.8,41.6,42.1,42.3,42.2,42,42,42,42,42,43,43,43,43,43,43,43,43,43,43,43,43,43];
        const tempController = [40,40,40,40,40,40,41,41,41,41,41,41.8,41.6,41.2,40.6,40.9,41.3,41.4,41.4,41.4,41.4,40.9,40.3,40.2,40.9,41,41.4,41.7,41.5];
        const power = [null,13,169,13,13,13,180,155,13,13,13,150,140,null,13,13,13,13,13,13,13,168,13,13,13,130,13,13,null];

        const sharedTooltipOpts = {
            mode: 'index',
            intersect: false,
            backgroundColor: 'rgba(24,24,27,0.92)',
            titleFont: { family: "'Plus Jakarta Sans', sans-serif", weight: '700' },
            bodyFont: { family: "'JetBrains Mono', monospace", size: 11 },
            padding: 14,
            cornerRadius: 12,
            borderColor: 'rgba(249,115,22,0.3)',
            borderWidth: 1,
        };
        const sharedGridOpts = {
            color: 'rgba(228,228,231,0.5)',
            drawBorder: false,
        };
        const sharedScaleOpts = {
            ticks: { font: { family: "'JetBrains Mono', monospace", size: 10 }, color: '#a1a1aa' },
            grid: sharedGridOpts,
        };

        // Chart 1: Kecepatan
        new Chart(document.getElementById('chart-kecepatan'), {
            type: 'line',
            data: {
                labels: timeLabels,
                datasets: [
                    {
                        label: 'Tacho (RPM)',
                        data: tachoData,
                        borderColor: '#f97316',
                        backgroundColor: 'rgba(249,115,22,0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2.5,
                        pointRadius: 3,
                        pointBackgroundColor: '#f97316',
                        pointHoverRadius: 6,
                    },
                    {
                        label: 'Aplikasi (RPM)',
                        data: appRPM,
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59,130,246,0.08)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2.5,
                        pointRadius: 3,
                        pointBackgroundColor: '#3b82f6',
                        pointHoverRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    tooltip: sharedTooltipOpts,
                    legend: { display: false },
                },
                scales: {
                    x: { ...sharedScaleOpts, title: { display: true, text: 'Waktu (menit)', font: { family: "'Plus Jakarta Sans'", weight: '600', size: 11 }, color: '#71717a' } },
                    y: { ...sharedScaleOpts, title: { display: true, text: 'RPM', font: { family: "'Plus Jakarta Sans'", weight: '600', size: 11 }, color: '#71717a' } },
                }
            }
        });

        // Chart 2: Voltage
        new Chart(document.getElementById('chart-voltage'), {
            type: 'line',
            data: {
                labels: timeLabels,
                datasets: [{
                    label: 'V Baterai (Volt)',
                    data: voltage,
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16,185,129,0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2.5,
                    pointRadius: 3,
                    pointBackgroundColor: '#10b981',
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { tooltip: sharedTooltipOpts, legend: { display: false } },
                scales: {
                    x: { ...sharedScaleOpts, title: { display: true, text: 'Waktu (menit)', font: { family: "'Plus Jakarta Sans'", weight: '600', size: 11 }, color: '#71717a' } },
                    y: { ...sharedScaleOpts, min: 51.5, max: 54, title: { display: true, text: 'Volt', font: { family: "'Plus Jakarta Sans'", weight: '600', size: 11 }, color: '#71717a' } },
                }
            }
        });

        // Chart 3: Current
        new Chart(document.getElementById('chart-current'), {
            type: 'line',
            data: {
                labels: timeLabels,
                datasets: [{
                    label: 'I Baterai (A)',
                    data: current,
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239,68,68,0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2.5,
                    pointRadius: 3,
                    pointBackgroundColor: '#ef4444',
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { tooltip: sharedTooltipOpts, legend: { display: false } },
                scales: {
                    x: { ...sharedScaleOpts, title: { display: true, text: 'Waktu (menit)', font: { family: "'Plus Jakarta Sans'", weight: '600', size: 11 }, color: '#71717a' } },
                    y: { ...sharedScaleOpts, title: { display: true, text: 'Ampere', font: { family: "'Plus Jakarta Sans'", weight: '600', size: 11 }, color: '#71717a' } },
                }
            }
        });

        // Chart 4: Temperature
        new Chart(document.getElementById('chart-temperature'), {
            type: 'line',
            data: {
                labels: timeLabels,
                datasets: [
                    {
                        label: 'BMS (°C)',
                        data: tempBMS,
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239,68,68,0.05)',
                        fill: false,
                        tension: 0.4,
                        borderWidth: 2.5,
                        pointRadius: 3,
                        pointBackgroundColor: '#ef4444',
                        pointHoverRadius: 6,
                    },
                    {
                        label: 'Thermometer (°C)',
                        data: tempThermo,
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245,158,11,0.05)',
                        fill: false,
                        tension: 0.4,
                        borderWidth: 2.5,
                        pointRadius: 3,
                        pointBackgroundColor: '#f59e0b',
                        pointHoverRadius: 6,
                    },
                    {
                        label: 'Controller (°C)',
                        data: tempController,
                        borderColor: '#8b5cf6',
                        backgroundColor: 'rgba(139,92,246,0.05)',
                        fill: false,
                        tension: 0.4,
                        borderWidth: 2.5,
                        pointRadius: 3,
                        pointBackgroundColor: '#8b5cf6',
                        pointHoverRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: { tooltip: sharedTooltipOpts, legend: { display: false } },
                scales: {
                    x: { ...sharedScaleOpts, title: { display: true, text: 'Waktu (menit)', font: { family: "'Plus Jakarta Sans'", weight: '600', size: 11 }, color: '#71717a' } },
                    y: { ...sharedScaleOpts, title: { display: true, text: '°C', font: { family: "'Plus Jakarta Sans'", weight: '600', size: 11 }, color: '#71717a' } },
                }
            }
        });

        // Chart 5: Power
        new Chart(document.getElementById('chart-power'), {
            type: 'line',
            data: {
                labels: timeLabels,
                datasets: [{
                    label: 'Daya (Watt)',
                    data: power,
                    borderColor: '#8b5cf6',
                    backgroundColor: 'rgba(139,92,246,0.12)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2.5,
                    pointRadius: 3,
                    pointBackgroundColor: '#8b5cf6',
                    pointHoverRadius: 6,
                    spanGaps: true,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { tooltip: sharedTooltipOpts, legend: { display: false } },
                scales: {
                    x: { ...sharedScaleOpts, title: { display: true, text: 'Waktu (menit)', font: { family: "'Plus Jakarta Sans'", weight: '600', size: 11 }, color: '#71717a' } },
                    y: { ...sharedScaleOpts, title: { display: true, text: 'Watt', font: { family: "'Plus Jakarta Sans'", weight: '600', size: 11 }, color: '#71717a' } },
                }
            }
        });

        // Video Modal Handler
        const videoModal = document.getElementById('videoModal');
        const videoModalTitle = document.getElementById('videoModalTitle');
        const videoModalDesc = document.getElementById('videoModalDesc');
        const videoModalBadge = document.getElementById('videoModalBadge');
        const videoPlayerFrame = document.getElementById('videoPlayerFrame');
        const videoPlayerNative = document.getElementById('videoPlayerNative');
        const videoPlaceholderBox = document.getElementById('videoPlaceholderBox');

        @php
        $catalogData = [];
        if (isset($videos)) {
            foreach ($videos as $key => $v) {
                $catalogData[$key] = [
                    'title' => $v->title,
                    'badge' => $v->badge ?? 'DOKUMENTASI UJI',
                    'desc' => $v->description ?? '',
                    'src' => $v->play_source,
                    'is_local' => $v->isLocalFile(),
                    'poster' => $v->poster_image ? asset($v->poster_image) : null,
                ];
            }
        }
        @endphp
        const videoCatalog = @json($catalogData);

        window.playVideo = function(type) {
            const item = videoCatalog[type] || {
                title: 'Pengujian Trolley HI 102',
                badge: 'DOKUMENTASI UJI',
                desc: 'Video dokumentasi pengujian unit trolley.',
                src: '',
                is_local: false
            };

            videoModalTitle.textContent = item.title;
            videoModalBadge.textContent = item.badge;
            videoModalDesc.textContent = item.desc;

            // Reset kedua pemutar video
            videoPlayerFrame.classList.add('hidden');
            videoPlayerFrame.src = '';
            videoPlayerNative.classList.add('hidden');
            videoPlayerNative.pause();
            videoPlayerNative.src = '';
            videoPlaceholderBox.classList.add('hidden');

            if (item.src) {
                if (item.is_local) {
                    videoPlayerNative.src = item.src;
                    if (item.poster) videoPlayerNative.poster = item.poster;
                    videoPlayerNative.classList.remove('hidden');
                    videoPlayerNative.play().catch(e => console.log('Autoplay prevented', e));
                } else {
                    videoPlayerFrame.src = item.src;
                    videoPlayerFrame.classList.remove('hidden');
                }
            } else {
                videoPlaceholderBox.classList.remove('hidden');
            }

            videoModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        };

        window.closeVideoModal = function() {
            videoModal.classList.add('hidden');
            videoPlayerFrame.src = '';
            videoPlayerNative.pause();
            videoPlayerNative.src = '';
            document.body.style.overflow = 'auto';
        };

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !videoModal.classList.contains('hidden')) {
                closeVideoModal();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        initHI102ThreeJS();
        initCharts();
    });
</script>

<!-- Video Modal -->
<div id="videoModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-3 sm:p-6 bg-zinc-950/85 backdrop-blur-md transition-opacity">
    <div class="relative w-full max-w-4xl max-h-[94vh] flex flex-col bg-zinc-900 border border-zinc-800 rounded-2xl sm:rounded-[32px] overflow-hidden shadow-2xl">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-4 sm:p-6 border-b border-zinc-800 shrink-0">
            <div class="pr-3">
                <span id="videoModalBadge" class="px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-full bg-rail-500/20 text-rail-300 text-[11px] sm:text-xs font-mono font-bold"></span>
                <h3 id="videoModalTitle" class="text-base sm:text-xl font-extrabold text-white mt-1 sm:mt-2 line-clamp-1"></h3>
            </div>
            <button onclick="closeVideoModal()" aria-label="Tutup Modal" class="w-9 h-9 sm:w-10 sm:h-10 min-w-[36px] min-h-[36px] rounded-full bg-zinc-800 hover:bg-zinc-700 active:scale-95 text-zinc-400 hover:text-white flex items-center justify-center transition shrink-0">
                <i class="fa-solid fa-xmark text-base sm:text-lg"></i>
            </button>
        </div>

        <!-- Video Player / Placeholder Box -->
        <div class="relative aspect-video max-h-[58vh] sm:max-h-[68vh] bg-black flex items-center justify-center overflow-hidden shrink min-h-0">
            <!-- Native HTML5 Video Player untuk file MP4 lokal -->
            <video id="videoPlayerNative" controls playsinline class="w-full h-full hidden bg-black object-contain"></video>

            <!-- iFrame Player untuk link YouTube / embed eksternal -->
            <iframe id="videoPlayerFrame" class="w-full h-full hidden" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            
            <!-- Placeholder saat video belum tersedia -->
            <div id="videoPlaceholderBox" class="text-center p-4 sm:p-8 space-y-3 sm:space-y-4 overflow-y-auto max-h-full">
                <div class="w-14 h-14 sm:w-20 sm:h-20 rounded-full bg-rail-500/20 border border-rail-500/30 flex items-center justify-center mx-auto text-rail-400 text-2xl sm:text-3xl">
                    <i class="fa-solid fa-video"></i>
                </div>
                <div>
                    <h4 class="text-white font-bold text-base sm:text-lg">Dokumentasi Video Lapangan</h4>
                    <p id="videoModalDesc" class="text-zinc-400 text-xs max-w-lg mx-auto mt-1 leading-relaxed"></p>
                </div>
                <div class="pt-1">
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-zinc-800/80 text-zinc-400 text-[11px] sm:text-xs font-mono">
                        <i class="fa-solid fa-circle-info text-rail-400"></i>
                        File video dapat ditautkan melalui panel admin atau CMS
                    </span>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="p-3 sm:p-4 bg-zinc-900/90 border-t border-zinc-800 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-xs text-zinc-500 shrink-0">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-[11px] sm:text-xs">Electric Trolley HI 102 — Video Archive</span>
            </div>
            <button onclick="closeVideoModal()" class="w-full sm:w-auto px-4 py-2 min-h-[38px] rounded-xl bg-zinc-800 hover:bg-zinc-700 active:scale-95 text-white font-semibold transition text-center">
                Tutup
            </button>
        </div>
    </div>
</div>
@endsection
