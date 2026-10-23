@extends('layouts.app')

@section('content')
<div class="max-w-[1400px] mx-auto px-4 sm:px-8 space-y-20">

    <!-- ===================================================================== -->
    <!-- HERO SECTION: INTERACTIVE 3D RAILWAY TROLLEY (BENTO REFERENCE LAYOUT) -->
    <!-- ===================================================================== -->
    <section class="relative rounded-[32px] bg-zinc-900 text-white overflow-hidden shadow-2xl border border-zinc-800 min-h-[640px] flex flex-col justify-between p-6 sm:p-10">
        
        <!-- Kanvas 3D Interaktif Three.js (Merekonstruksi Trolley full ASM v14 dari DXF & Foto) -->
        <div id="trolley-3d-canvas" class="absolute inset-0 w-full h-full z-0 cursor-grab active:cursor-grabbing"></div>
        
        <!-- Gradient Overlay Halus agar Teks Tetap Terbaca Jelas -->
        <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/90 via-zinc-950/25 to-zinc-950/60 pointer-events-none z-10"></div>

        <!-- Baris Atas Hero (Pills Kiri & Kontrol Kamera 3D Kanan) -->
        <div class="relative z-20 flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-2">
                <span class="px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-xs font-semibold tracking-wide">
                    {{ $settings['hero_badge_1'] ?? 'Rail Tech' }}
                </span>
                <span class="px-3.5 py-1.5 rounded-full bg-rail-500/90 text-white text-xs font-bold tracking-wide shadow-lg shadow-rail-500/30">
                    {{ $settings['hero_badge_2'] ?? '4-Nozzle Airless' }}
                </span>
                <span class="px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-xs font-semibold tracking-wide">
                    {{ $settings['hero_badge_3'] ?? 'BLDC In-Wheel 200' }}
                </span>
            </div>

            <!-- Kontrol Interaktif 3D View -->
            <div class="flex items-center gap-2 bg-zinc-900/80 backdrop-blur-md border border-white/15 rounded-full p-1.5 text-xs">
                <button onclick="setCameraView('iso')" class="px-3 py-1 rounded-full bg-rail-500 text-white font-bold hover:bg-rail-600 transition">3D Orbit</button>
                <button onclick="setCameraView('front')" class="px-3 py-1 rounded-full hover:bg-white/10 text-zinc-200 transition">Depan (Sprayer)</button>
                <button onclick="setCameraView('top')" class="px-3 py-1 rounded-full hover:bg-white/10 text-zinc-200 transition">Atas (1350mm)</button>
                <button onclick="toggleSprayAnimation()" id="btn-spray" class="px-3 py-1 rounded-full bg-amber-500/20 text-amber-300 border border-amber-400/30 font-semibold hover:bg-amber-500/30 transition inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-droplet text-xs"></i> <span>Simulasi Semprot: ON</span>
                </button>
            </div>
        </div>

        <!-- Baris Tengah Hero (Angka Besar 1350mm Kiri & Petunjuk 3D Kanan) -->
        <div class="relative z-20 grid grid-cols-1 md:grid-cols-12 gap-6 my-auto py-8 pointer-events-none">
            <div class="md:col-span-5 space-y-1">
                <div class="text-5xl sm:text-7xl font-extrabold tracking-tight text-white drop-shadow">
                    {{ $settings['hero_stat_big'] ?? '1350mm' }}
                </div>
                <p class="text-sm text-zinc-300 font-medium">
                    {{ $settings['hero_stat_label'] ?? 'Dimensi Lebar Presisi (Track Gauge 930mm)' }}
                </p>
                <div class="pt-2 inline-flex items-center gap-2 text-[11px] font-mono text-rail-300 bg-zinc-900/70 px-3 py-1 rounded-full border border-rail-500/30">
                    <i class="fa-solid fa-arrows-rotate text-rail-400"></i>
                    <span>Putar 360° dengan Mouse / Sentuhan Layar</span>
                </div>
            </div>
        </div>

        <!-- Baris Bawah Hero (Floating Card Kiri & Judul Besar Kanan seperti Referensi) -->
        <div class="relative z-20 grid grid-cols-1 lg:grid-cols-12 gap-8 items-end">
            <!-- Floating White Card (Kiri Bawah) -->
            <div class="lg:col-span-4 bg-white text-zinc-900 rounded-3xl p-4 shadow-2xl border border-zinc-100">
                <div class="relative rounded-2xl overflow-hidden h-44 bg-zinc-100">
                    <img src="{{ asset('images/trolley/img8_full_front.jpeg') }}" alt="Implementasi HI 102" class="w-full h-full object-cover">
                    <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full bg-zinc-900/80 text-white text-[10px] font-mono">
                        Trolley full ASM v14
                    </span>
                </div>
                <div class="pt-4 space-y-3">
                    <div class="flex items-start gap-2.5">
                        <span class="w-6 h-6 rounded-full bg-rail-500 text-white flex-shrink-0 flex items-center justify-center text-[10px] font-bold mt-0.5"><i class="fa-solid fa-bolt"></i></span>
                        <p class="text-xs text-zinc-600 leading-relaxed">
                            {{ $settings['hero_floating_card_text'] ?? 'Inovasi wahana elektrik otomatis untuk pengecatan dan perawatan rel kereta api R54-70 dengan presisi tinggi.' }}
                        </p>
                    </div>
                    <div class="flex items-center justify-between pt-2 border-t border-zinc-100 text-[11px] font-mono text-zinc-500">
                        <span class="font-bold text-zinc-900">{{ $settings['hero_floating_year'] ?? '©2026 HI 102' }}</span>
                        <span>Dual Battery • 4 Sprayer</span>
                    </div>
                </div>
            </div>

            <!-- Headline Besar (Kanan Bawah) -->
            <div class="lg:col-span-8 lg:text-right space-y-3 pointer-events-none">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-rail-500 text-white text-xs font-extrabold tracking-wider uppercase shadow-lg shadow-rail-500/40">
                    <i class="fa-solid fa-train text-xs"></i>
                    <span>{{ $settings['brand_name'] ?? 'HI 102' }} RAILWAY ELECTRIC</span>
                </div>
                <h1 class="text-3xl sm:text-6xl font-extrabold tracking-tight leading-none text-white">
                    {{ $settings['hero_title'] ?? 'PARTNER IN RAILWAY INNOVATION' }}
                </h1>
            </div>
        </div>
    </section>

    <!-- ===================================================================== -->
    <!-- SECTION 01: PROBLEM, SOLUTION, TECHNOLOGY & MINI CARDS                -->
    <!-- ===================================================================== -->
    <section id="problem" class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start pt-4">
        
        <!-- Kolom Kiri (01, 4x Nozzle, Accordion Problem/Solution/Tech) -->
        <div class="lg:col-span-5 space-y-8" x-data="{ activeTab: 'problem' }">
            <div class="text-xs font-mono text-zinc-400">01 / ARSITEKTUR REKAYASA</div>
            
            <div>
                <div class="text-5xl font-extrabold text-zinc-900 tracking-tight">
                    {{ $settings['sec1_stat_number'] ?? '4x' }}
                </div>
                <p class="text-sm text-zinc-500 mt-1">
                    {{ $settings['sec1_stat_label'] ?? 'Nozzle Airless Sprayer Terintegrasi' }}
                </p>
            </div>

            <div class="space-y-4 border-t border-zinc-200 pt-6">
                <!-- Problem -->
                <div class="border-b border-zinc-200 pb-4 cursor-pointer" @click="activeTab = 'problem'">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition"
                              :class="activeTab === 'problem' ? 'bg-rail-500 text-white shadow-md shadow-rail-500/30' : 'bg-rail-100 text-rail-700'">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </span>
                        <h3 class="font-bold text-zinc-900">{{ $settings['problem_title'] ?? 'Problem Pemeliharaan Manual' }}</h3>
                    </div>
                    <p x-show="activeTab === 'problem'" x-collapse class="text-xs text-zinc-500 leading-relaxed mt-3 pl-11">
                        {{ $settings['problem_desc'] ?? '' }}
                    </p>
                </div>

                <!-- Solution -->
                <div id="solution" class="border-b border-zinc-200 pb-4 cursor-pointer" @click="activeTab = 'solution'">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition"
                              :class="activeTab === 'solution' ? 'bg-rail-500 text-white shadow-md shadow-rail-500/30' : 'bg-rail-100 text-rail-700'">
                            <i class="fa-solid fa-lightbulb"></i>
                        </span>
                        <h3 class="font-bold text-zinc-900">{{ $settings['solution_title'] ?? 'Solusi Otomasi HI 102' }}</h3>
                    </div>
                    <p x-show="activeTab === 'solution'" x-collapse class="text-xs text-zinc-500 leading-relaxed mt-3 pl-11">
                        {{ $settings['solution_desc'] ?? '' }}
                    </p>
                </div>

                <!-- Technology -->
                <div class="border-b border-zinc-200 pb-4 cursor-pointer" @click="activeTab = 'tech'">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition"
                              :class="activeTab === 'tech' ? 'bg-rail-500 text-white shadow-md shadow-rail-500/30' : 'bg-rail-100 text-rail-700'">
                            <i class="fa-solid fa-microchip"></i>
                        </span>
                        <h3 class="font-bold text-zinc-900">{{ $settings['tech_title'] ?? 'Teknologi CAD Trolley ASM v14' }}</h3>
                    </div>
                    <p x-show="activeTab === 'tech'" x-collapse class="text-xs text-zinc-500 leading-relaxed mt-3 pl-11">
                        {{ $settings['tech_desc'] ?? '' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan (Teks Headline Besar & 2 Kartu Preview Implementasi) -->
        <div class="lg:col-span-7 space-y-8">
            <span class="inline-block px-3.5 py-1.5 rounded-full bg-zinc-900 text-white text-xs font-semibold">
                Engineering Excellence • CAD v14
            </span>

            <h2 class="text-2xl sm:text-4xl font-bold text-zinc-900 leading-snug">
                {{ $settings['sec1_heading'] ?? 'Dari penggerak BLDC elektrik hingga sistem penyemprotan airless bertekanan tinggi, HI 102 mendukung pemeliharaan rel di setiap meter perjalanan.' }}
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2">
                <div class="bento-card bg-white rounded-3xl p-4 border border-zinc-200/80 shadow-sm flex items-center gap-4">
                    <img src="{{ asset('images/trolley/img3_sprayer_boom.jpeg') }}" class="w-28 h-28 rounded-2xl object-cover flex-shrink-0" alt="Sprayer">
                    <div class="space-y-1">
                        <span class="text-[10px] font-mono uppercase px-2 py-0.5 rounded bg-rail-100 text-rail-700 font-bold">Sprayer v2</span>
                        <h4 class="font-bold text-sm text-zinc-900">4-Nozzle Airless Boom</h4>
                        <p class="text-xs text-zinc-500">Manifold Tee & Y Pneumatik presisi untuk 2 rel.</p>
                    </div>
                </div>

                <div class="bento-card bg-white rounded-3xl p-4 border border-zinc-200/80 shadow-sm flex items-center gap-4">
                    <img src="{{ asset('images/trolley/img2_pump_gauge.jpeg') }}" class="w-28 h-28 rounded-2xl object-cover flex-shrink-0" alt="Pompa Airless">
                    <div class="space-y-1">
                        <span class="text-[10px] font-mono uppercase px-2 py-0.5 rounded bg-rail-100 text-rail-700 font-bold">Mesin Airless v7</span>
                        <h4 class="font-bold text-sm text-zinc-900">High-Pressure Möllar</h4>
                        <p class="text-xs text-zinc-500">Dilengkapi Pressure Gauge & Solenoid Drain Valve.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================================================================== -->
    <!-- BARIS FITUR CAD LAYER (Menggantikan Ikon Brand di Desain Referensi)   -->
    <!-- ===================================================================== -->
    <section class="py-6 border-y border-zinc-200 flex flex-wrap items-center justify-between gap-6 text-xs font-mono text-zinc-500">
        <div class="flex items-center gap-2"><i class="fa-solid fa-gear text-rail-500"></i> BLDC motor v5</div>
        <div class="flex items-center gap-2"><i class="fa-solid fa-circle-notch text-rail-500"></i> in-wheel_200 v10</div>
        <div class="flex items-center gap-2"><i class="fa-solid fa-wind text-rail-500"></i> mesin airless v7</div>
        <div class="flex items-center gap-2"><i class="fa-solid fa-battery-full text-rail-500"></i> Dual Baterai v1</div>
        <div class="flex items-center gap-2"><i class="fa-solid fa-hand text-rail-500"></i> ParkBrakeLever & Tromol</div>
        <div class="flex items-center gap-2"><i class="fa-solid fa-road text-rail-500"></i> Rail 1067 / R54-70</div>
    </section>

    <!-- ===================================================================== -->
    <!-- SECTION 02: BENTO BOX DATA HASIL PENGUJIAN (DINAMIS DARI ADMIN)       -->
    <!-- ===================================================================== -->
    <section id="pengujian" class="space-y-10" x-data="{ katFilter: 'Semua' }">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Kartu Kiri Besar: Foto Implementasi + Badge 86% -->
            <div class="lg:col-span-6 relative rounded-[32px] overflow-hidden min-h-[460px] shadow-lg group">
                <img src="{{ asset('images/trolley/img7_control_panel.jpeg') }}" alt="Panel Kontrol HI 102" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/70 via-transparent to-zinc-950/30"></div>
                
                <div class="absolute top-5 right-5 flex gap-2">
                    <span class="px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-white text-xs font-semibold">Panel Kontrol KAI</span>
                    <span class="px-3 py-1 rounded-full bg-rail-500 text-white text-xs font-bold">Teruji Lapangan</span>
                </div>

                <!-- Badge Statistik Kiri Bawah (86%) -->
                <div class="absolute bottom-5 left-5 bg-white rounded-3xl p-5 shadow-xl w-52">
                    <div class="flex items-center justify-between">
                        <span class="text-4xl font-extrabold text-zinc-900">{{ $settings['sec2_efficiency_pct'] ?? '86%' }}</span>
                        <span class="w-7 h-7 rounded-full bg-rail-500 text-white flex items-center justify-center text-xs font-bold">
                            <i class="fa-solid fa-check"></i>
                        </span>
                    </div>
                    <p class="text-xs text-zinc-500 mt-2 font-medium">
                        {{ $settings['sec2_efficiency_label'] ?? 'Keseragaman Distribusi Cat Rel' }}
                    </p>
                </div>
            </div>

            <!-- Kartu Kanan Besar: Quote + Grafik Batang Pengujian + Kartu Oranye 300% -->
            <div class="lg:col-span-6 bg-white rounded-[32px] p-6 sm:p-8 border border-zinc-200/80 shadow-sm flex flex-col justify-between space-y-6">
                
                <!-- Tab Pills Atas -->
                <div class="flex flex-wrap items-center justify-between gap-2 border-b border-zinc-100 pb-4">
                    <span class="px-3.5 py-1 rounded-full text-xs font-bold bg-zinc-900 text-white">Hasil Pengujian</span>
                    <span class="text-xs text-zinc-400 font-mono">Bento Analytics HI 102</span>
                </div>

                <!-- Teks Tengah -->
                <div class="text-center max-w-md mx-auto space-y-4 py-2">
                    <div class="text-rail-500 text-xl"><i class="fa-solid fa-quote-left"></i></div>
                    <p class="text-base sm:text-lg font-medium text-zinc-800 leading-relaxed">
                        {{ $settings['sec2_quote'] ?? '' }}
                    </p>
                    <a href="#tabel-pengujian" class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-zinc-900 text-white text-xs font-bold hover:bg-rail-500 transition">
                        <span>Lihat Tabel Uji Lengkap</span>
                        <span class="w-5 h-5 rounded-full bg-rail-500 text-white flex items-center justify-center text-[10px]">
                            <i class="fa-solid fa-arrow-down"></i>
                        </span>
                    </a>
                </div>

                <!-- Dua Kartu Bawah: Grafik Bar Pengujian & Kartu Oranye 300% -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    
                    <!-- Grafik Bar Dinamis dari Tabel test_results -->
                    <div class="bg-zinc-50 rounded-3xl p-5 border border-zinc-200/60 flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-zinc-700">Grafik Skor Uji</span>
                            <span class="w-6 h-6 rounded-full bg-rail-500 text-white flex items-center justify-center text-[10px]">
                                <i class="fa-solid fa-chart-column"></i>
                            </span>
                        </div>
                        <div class="flex items-end justify-between gap-2 h-28 pt-6 px-1">
                            @foreach($testResults->take(6) as $tr)
                                @php
                                    $max = ($tr->target_value && $tr->target_value > 0) ? $tr->target_value : 100;
                                    $pct = min(100, max(25, round(($tr->result_value / $max) * 100)));
                                @endphp
                                <div class="flex-1 flex flex-col items-center gap-1 group">
                                    <span class="text-[9px] font-mono text-zinc-500 opacity-0 group-hover:opacity-100 transition">{{ $tr->result_value }}</span>
                                    <div class="w-full bg-zinc-900 group-hover:bg-rail-500 transition-all rounded-t-md" style="height: {{ $pct }}px"></div>
                                    <span class="text-[9px] font-mono text-zinc-400">{{ $tr->test_code }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Kartu Aksen Oranye (Menggantikan Kartu Hijau/Kuning 300% di Referensi) -->
                    <div class="bg-rail-500 text-white rounded-3xl p-5 shadow-lg shadow-rail-500/30 flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider text-rail-100">Efisiensi Kerja</span>
                            <span class="w-7 h-7 rounded-full bg-zinc-900 text-white flex items-center justify-center text-xs">
                                <i class="fa-solid fa-bolt"></i>
                            </span>
                        </div>
                        <div class="pt-6">
                            <span class="text-xs text-rail-100 block">Up to</span>
                            <span class="text-4xl sm:text-5xl font-extrabold tracking-tight">
                                {{ $settings['sec2_boost_pct'] ?? '300%' }}
                            </span>
                            <p class="text-xs text-rail-100 mt-1">
                                {{ $settings['sec2_boost_label'] ?? 'Peningkatan Kecepatan Kerja vs Manual' }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- TABEL LENGKAP DATA HASIL PENGUJIAN -->
        <div id="tabel-pengujian" class="bg-white rounded-[32px] p-6 sm:p-8 border border-zinc-200/80 shadow-sm space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <span class="text-xs font-mono uppercase text-rail-600 font-bold">Laboratorium & Lapangan</span>
                    <h3 class="text-2xl font-extrabold text-zinc-900">Data Hasil Pengujian HI 102</h3>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="border-b border-zinc-200 text-xs font-mono uppercase text-zinc-400">
                            <th class="py-3 px-4">Kode</th>
                            <th class="py-3 px-4">Parameter Pengujian</th>
                            <th class="py-3 px-4">Kategori</th>
                            <th class="py-3 px-4">Hasil Uji</th>
                            <th class="py-3 px-4">Target / Standar</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Catatan Teknis</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        @foreach($testResults as $test)
                        <tr class="hover:bg-rail-50/40 transition">
                            <td class="py-3.5 px-4 font-mono text-xs font-bold text-rail-600">{{ $test->test_code }}</td>
                            <td class="py-3.5 px-4 font-bold text-zinc-900">{{ $test->parameter }}</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-full text-xs bg-zinc-100 text-zinc-700 font-medium">{{ $test->category }}</span>
                            </td>
                            <td class="py-3.5 px-4 font-mono font-extrabold text-base text-zinc-900">
                                {{ $test->result_value }} <span class="text-xs font-normal text-zinc-500">{{ $test->unit }}</span>
                            </td>
                            <td class="py-3.5 px-4 font-mono text-xs text-zinc-500">
                                {{ $test->target_value ?? '-' }} {{ $test->unit }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-rail-100 text-rail-700">
                                    {{ $test->status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-xs text-zinc-500">{{ $test->notes }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- ===================================================================== -->
    <!-- SECTION 03: OUR PRODUCT / 8 FOTO IMPLEMENTASI & BLUEPRINT             -->
    <!-- ===================================================================== -->
    <section id="komponen" class="space-y-8">
        <div class="flex items-center justify-between">
            <div class="flex items-baseline gap-6">
                <span class="text-xs font-mono text-zinc-400">02 / DOKUMENTASI FISIK</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-zinc-900">Implementasi Komponen HI 102</h2>
            </div>
            <span class="w-10 h-10 rounded-full bg-zinc-900 text-rail-400 flex items-center justify-center font-bold">
                <i class="fa-solid fa-cubes"></i>
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($components as $index => $comp)
            <div class="bento-card bg-white rounded-[28px] overflow-hidden border border-zinc-200/80 shadow-sm flex flex-col justify-between {{ $index === 0 ? 'md:col-span-2 lg:col-span-2' : '' }}">
                <div>
                    <div class="relative h-64 overflow-hidden bg-zinc-100">
                        <img src="{{ asset($comp->image_path) }}" alt="{{ $comp->name }}" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                        <div class="absolute top-3 left-3 flex gap-2">
                            <span class="px-3 py-1 rounded-full bg-zinc-900/80 backdrop-blur-md text-white text-[11px] font-semibold">
                                {{ $comp->category }}
                            </span>
                            @if($comp->code)
                            <span class="px-3 py-1 rounded-full bg-rail-500 text-white text-[11px] font-mono font-bold">
                                {{ $comp->code }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="p-6 space-y-2">
                        <h3 class="text-lg font-extrabold text-zinc-900">{{ $comp->name }}</h3>
                        <p class="text-xs text-zinc-500 leading-relaxed">{{ $comp->description }}</p>
                    </div>
                </div>
                <div class="px-6 pb-5 pt-3 border-t border-zinc-100 flex items-center justify-between text-xs font-mono text-zinc-500">
                    <span>{{ $comp->specification }}</span>
                    <span class="text-rail-600 font-bold">#0{{ $index + 1 }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </section>

</div>

<!-- ========================================================================= -->
<!-- MARQUEE TEXT BANNER (PERSIS REFERENSI DESAIN)                             -->
<!-- ========================================================================= -->
<div class="my-20 py-8 border-y border-zinc-200 bg-white overflow-hidden">
    <div class="animate-marquee">
        <span class="text-4xl sm:text-6xl font-extrabold tracking-tight text-zinc-900 mx-4">
            {{ $settings['marquee_text'] ?? 'HI 102 — Partner In Railway Maintenance Innovation ❖ Electric Trolley Machine for Rail Painting ❖ ' }}
        </span>
        <span class="text-4xl sm:text-6xl font-extrabold tracking-tight text-rail-500 mx-4">
            {{ $settings['marquee_text'] ?? 'HI 102 — Partner In Railway Maintenance Innovation ❖ Electric Trolley Machine for Rail Painting ❖ ' }}
        </span>
    </div>
</div>

<div class="max-w-[1400px] mx-auto px-4 sm:px-8 space-y-20">

    <!-- ===================================================================== -->
    <!-- SECTION 04: EVALUASI LAPANGAN & LINK KE HALAMAN TIM PENGEMBANG        -->
    <!-- ===================================================================== -->
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
        <div class="lg:col-span-7 space-y-6">
            <div class="flex items-center gap-3">
                <span class="text-xs font-mono text-zinc-400">03 / VALIDASI</span>
                <span class="text-sm font-bold text-zinc-900">{{ $settings['review_rating'] ?? '4.9' }}</span>
                <div class="flex text-rail-500 text-xs gap-1">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                </div>
            </div>

            <blockquote class="text-xl sm:text-2xl font-bold text-zinc-900 leading-relaxed">
                {{ $settings['review_quote'] ?? '' }}
            </blockquote>

            <div>
                <div class="font-extrabold text-zinc-900">{{ $settings['review_author'] ?? 'Tim Penguji Lapangan HI 102' }}</div>
                <div class="text-xs text-zinc-500">{{ $settings['review_role'] ?? 'Divisi Rekayasa & Perawatan Jalan Rel' }}</div>
            </div>
        </div>

        <div class="lg:col-span-5 grid grid-cols-2 gap-4">
            <div class="rounded-3xl overflow-hidden h-64 shadow-md border border-zinc-200">
                <img src="{{ asset('images/trolley/img1_pump_battery.jpeg') }}" class="w-full h-full object-cover" alt="Detail Mesin">
            </div>
            <div class="rounded-3xl bg-zinc-900 text-white p-6 flex flex-col justify-between h-64">
                <span class="w-10 h-10 rounded-2xl bg-rail-500 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-users text-white"></i>
                </span>
                <div class="space-y-2">
                    <div class="text-2xl font-extrabold">{{ $teamCount }} Engineer</div>
                    <p class="text-xs text-zinc-400">Kenali tim perancang mekanis, elektrikal, dan fluida di balik HI 102.</p>
                    <a href="{{ route('team') }}" class="inline-flex items-center gap-1.5 pt-2 text-xs font-bold text-rail-400 hover:text-rail-300">
                        <span>Lihat Tim Pengembang</span> <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================================================================== -->
    <!-- SECTION 05: WIDE SHOWCASE BANNER (GAMBAR BLUEPRINT & RANGKA BAWAH)    -->
    <!-- ===================================================================== -->
    <section class="space-y-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="w-9 h-9 rounded-full bg-zinc-900 text-rail-400 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-compass-drafting"></i>
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-zinc-900">Arsitektur Blueprint & Presisi Dimensi</h2>
            </div>
        </div>

        <div class="relative rounded-[32px] overflow-hidden bg-white border border-zinc-200 shadow-lg p-6 sm:p-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-8">
                <img src="{{ asset('images/trolley/blueprint_dimensi.png') }}" alt="Blueprint Dimensi HI 102" class="w-full h-auto rounded-2xl">
            </div>
            <div class="lg:col-span-4 space-y-4">
                <span class="px-3 py-1 rounded-full bg-rail-100 text-rail-700 text-xs font-mono font-bold">CAD Trolley full ASM v14</span>
                <h3 class="text-2xl font-extrabold text-zinc-900">Standar Geometri Jalan Rel</h3>
                <p class="text-xs text-zinc-500 leading-relaxed">
                    Seluruh komponen direkayasa menggunakan Autodesk Fusion / AutoCAD (AC1027) dengan titik berat yang seimbang di tengah sasis untuk stabilitas di atas rel R54-70.
                </p>
                <div class="grid grid-cols-2 gap-3 pt-2 font-mono text-xs">
                    <div class="p-3 rounded-2xl bg-zinc-50 border border-zinc-200">
                        <span class="text-zinc-400 block text-[10px]">LEBAR TOTAL</span>
                        <span class="font-bold text-zinc-900 text-base">1350 mm</span>
                    </div>
                    <div class="p-3 rounded-2xl bg-zinc-50 border border-zinc-200">
                        <span class="text-zinc-400 block text-[10px]">TRACK GAUGE</span>
                        <span class="font-bold text-rail-600 text-base">930 mm</span>
                    </div>
                    <div class="p-3 rounded-2xl bg-zinc-50 border border-zinc-200">
                        <span class="text-zinc-400 block text-[10px]">TINGGI PAGAR</span>
                        <span class="font-bold text-zinc-900 text-base">1000 mm</span>
                    </div>
                    <div class="p-3 rounded-2xl bg-zinc-50 border border-zinc-200">
                        <span class="text-zinc-400 block text-[10px]">TINGGI KURSI</span>
                        <span class="font-bold text-zinc-900 text-base">430 mm</span>
                    </div>
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

    document.addEventListener('DOMContentLoaded', initHI102ThreeJS);
</script>
@endsection
