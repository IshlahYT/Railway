@extends('layouts.app')

@section('content')
<div class="max-w-[1400px] mx-auto px-3 sm:px-6 lg:px-8 py-4 sm:py-8 space-y-6 sm:space-y-8" x-data="{ tab: new URLSearchParams(window.location.search).get('tab') || '{{ session('active_tab', 'videos') }}' }">

    <!-- Header Dashboard -->
    <div class="bg-zinc-900 text-white rounded-2xl sm:rounded-[32px] p-4 sm:p-6 lg:p-8 flex flex-col md:flex-row md:items-center justify-between gap-5 sm:gap-6 shadow-2xl border border-zinc-800">
        <div class="space-y-1.5">
            <div class="flex flex-wrap items-center gap-2">
                <span class="px-3 py-1 rounded-full bg-rail-500/20 text-rail-400 border border-rail-500/30 text-[10px] sm:text-[11px] font-mono font-bold uppercase tracking-wider">
                    Control Panel CMS
                </span>
                <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 text-[10px] sm:text-[11px] font-mono font-semibold">
                    Live System
                </span>
            </div>
            <h1 class="text-xl sm:text-2xl md:text-3xl font-extrabold tracking-tight">Manajemen Konten, Media & Pengujian HI 102</h1>
            <p class="text-xs sm:text-sm text-zinc-400 max-w-2xl">Kelola 6 video pengujian, foto-foto landing page, komponen CAD, data hasil uji, dan teks website secara real-time.</p>
        </div>
        <div class="grid grid-cols-2 sm:flex sm:items-center gap-2 sm:gap-3 flex-shrink-0 w-full md:w-auto">
            <form action="{{ route('admin.sync_seeder') }}" method="POST" class="col-span-2 sm:col-span-1">
                @csrf
                <button type="submit" onclick="return confirm('Perbarui file DatabaseSeeder.php dengan seluruh data saat ini?')" class="w-full px-4 py-2.5 rounded-xl sm:rounded-full bg-emerald-500/20 text-emerald-300 hover:bg-emerald-500/30 text-xs font-bold transition inline-flex items-center justify-center gap-1.5 border border-emerald-500/30 text-center">
                    <i class="fa-solid fa-cloud-arrow-down text-xs"></i>
                    <span>Simpan ke Seeder</span>
                </button>
            </form>
            <a href="{{ route('home') }}" target="_blank" class="px-4 py-2.5 rounded-xl sm:rounded-full bg-white/10 hover:bg-white/20 text-xs font-bold transition inline-flex items-center justify-center gap-2 text-center">
                <span>Lihat Web</span>
                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
            </a>
            <a href="{{ route('admin.logout') }}" class="px-4 py-2.5 rounded-xl sm:rounded-full bg-red-500/20 text-red-300 hover:bg-red-500/30 text-xs font-bold transition inline-flex items-center justify-center gap-1.5 border border-red-500/30 text-center">
                <i class="fa-solid fa-right-from-bracket text-xs"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
    <div class="p-3.5 sm:p-4 rounded-xl sm:rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-bold flex items-center gap-3 shadow-sm">
        <span class="w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-emerald-500 text-white flex items-center justify-center flex-shrink-0 text-xs sm:text-sm">
            <i class="fa-solid fa-check"></i>
        </span>
        <span class="flex-1">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="p-3.5 sm:p-4 rounded-xl sm:rounded-2xl bg-red-50 border border-red-200 text-red-800 text-xs sm:text-sm font-bold flex items-center gap-3 shadow-sm">
        <span class="w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-red-500 text-white flex items-center justify-center flex-shrink-0 text-xs sm:text-sm">
            <i class="fa-solid fa-exclamation"></i>
        </span>
        <span class="flex-1">{{ session('error') }}</span>
    </div>
    @endif

    <!-- Navigasi Tab Admin Responsif (Horizontal Scroll di Layar Kecil & Sedang) -->
    <div class="border-b border-zinc-200 pb-2">
        <div class="flex items-center gap-1.5 sm:gap-2 overflow-x-auto no-scrollbar py-1">
            <button @click="tab = 'videos'" :class="tab === 'videos' ? 'bg-rail-500 text-white shadow-md shadow-rail-500/30 font-bold' : 'bg-white text-zinc-700 hover:bg-zinc-100 border border-zinc-200 font-semibold'"
                    class="flex-shrink-0 whitespace-nowrap px-3.5 sm:px-5 py-2 sm:py-2.5 rounded-full text-xs transition inline-flex items-center gap-2">
                <i class="fa-solid fa-video"></i>
                <span>1. Video Pengujian ({{ $videos->count() }})</span>
            </button>

            <button @click="tab = 'landing_images'" :class="tab === 'landing_images' ? 'bg-rail-500 text-white shadow-md shadow-rail-500/30 font-bold' : 'bg-white text-zinc-700 hover:bg-zinc-100 border border-zinc-200 font-semibold'"
                    class="flex-shrink-0 whitespace-nowrap px-3.5 sm:px-5 py-2 sm:py-2.5 rounded-full text-xs transition inline-flex items-center gap-2">
                <i class="fa-solid fa-image"></i>
                <span>2. Gambar Landing Page (3)</span>
            </button>

            <button @click="tab = 'komponen'" :class="tab === 'komponen' ? 'bg-rail-500 text-white shadow-md shadow-rail-500/30 font-bold' : 'bg-white text-zinc-700 hover:bg-zinc-100 border border-zinc-200 font-semibold'"
                    class="flex-shrink-0 whitespace-nowrap px-3.5 sm:px-5 py-2 sm:py-2.5 rounded-full text-xs transition inline-flex items-center gap-2">
                <i class="fa-solid fa-cubes"></i>
                <span>3. Komponen CAD ({{ $components->count() }})</span>
            </button>

            <button @click="tab = 'pengujian'" :class="tab === 'pengujian' ? 'bg-rail-500 text-white shadow-md shadow-rail-500/30 font-bold' : 'bg-white text-zinc-700 hover:bg-zinc-100 border border-zinc-200 font-semibold'"
                    class="flex-shrink-0 whitespace-nowrap px-3.5 sm:px-5 py-2 sm:py-2.5 rounded-full text-xs transition inline-flex items-center gap-2">
                <i class="fa-solid fa-chart-column"></i>
                <span>4. Data Uji & Grafik ({{ $testResults->count() }})</span>
            </button>

            <button @click="tab = 'tim'" :class="tab === 'tim' ? 'bg-rail-500 text-white shadow-md shadow-rail-500/30 font-bold' : 'bg-white text-zinc-700 hover:bg-zinc-100 border border-zinc-200 font-semibold'"
                    class="flex-shrink-0 whitespace-nowrap px-3.5 sm:px-5 py-2 sm:py-2.5 rounded-full text-xs transition inline-flex items-center gap-2">
                <i class="fa-solid fa-users"></i>
                <span>5. Tim Pengembang ({{ $teams->count() }})</span>
            </button>

            <button @click="tab = 'password'" :class="tab === 'password' ? 'bg-rail-500 text-white shadow-md shadow-rail-500/30 font-bold' : 'bg-white text-zinc-700 hover:bg-zinc-100 border border-zinc-200 font-semibold'"
                    class="flex-shrink-0 whitespace-nowrap px-3.5 sm:px-5 py-2 sm:py-2.5 rounded-full text-xs transition inline-flex items-center gap-2">
                <i class="fa-solid fa-key"></i>
                <span>6. Password Admin</span>
            </button>
        </div>
    </div>

    <!-- ===================================================================== -->
    <!-- TAB 1: KELOLA 6 VIDEO PENGUJIAN TROLLEY & PENGECATAN                  -->
    <!-- ===================================================================== -->
    <div x-show="tab === 'videos'" class="space-y-6 sm:space-y-8" x-cloak>
        
        <!-- Info Banner Video -->
        <div class="bg-gradient-to-r from-zinc-900 to-zinc-800 text-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 border border-zinc-700/60 shadow-lg flex flex-col md:flex-row md:items-center justify-between gap-3 sm:gap-4">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-rail-500 animate-ping"></span>
                    <h3 class="font-extrabold text-sm sm:text-base">Manajemen 6 Video Pengujian (Seksi 08 & 09 Home)</h3>
                </div>
                <p class="text-xs text-zinc-300">
                    Video dapat berupa <strong>file lokal (.mp4/.webm)</strong> di server, atau tautan <strong>YouTube / embed URL</strong>.
                </p>
            </div>
            <div class="flex items-center gap-2 text-[11px] sm:text-xs font-mono bg-zinc-950/60 px-3.5 py-1.5 sm:py-2 rounded-xl sm:rounded-2xl border border-zinc-700 w-fit">
                <i class="fa-solid fa-folder-open text-rail-400"></i>
                <span>Lokasi: <strong>public/videos/</strong></span>
            </div>
        </div>

        <!-- Daftar 6 Kartu Video Pengujian -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-5 sm:gap-6 lg:gap-8">
            @foreach($videos as $video)
            <div class="bg-white rounded-2xl sm:rounded-[32px] p-4 sm:p-6 border border-zinc-200 shadow-md flex flex-col justify-between space-y-4 sm:space-y-6">
                <div class="space-y-4">
                    
                    <!-- Header Kartu Video -->
                    <div class="flex flex-wrap items-center justify-between gap-2 border-b border-zinc-100 pb-3">
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 sm:px-3 py-1 rounded-full bg-zinc-900 text-rail-400 font-mono text-[11px] sm:text-xs font-bold">
                                {{ strtoupper($video->video_key) }}
                            </span>
                            <span class="px-2.5 sm:px-3 py-1 rounded-full bg-rail-100 text-rail-700 text-[11px] sm:text-xs font-mono font-bold">
                                {{ $video->badge ?? 'UJI' }}
                            </span>
                        </div>
                        <div>
                            @if($video->play_source)
                                <span class="px-2.5 sm:px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[11px] sm:text-xs font-bold inline-flex items-center gap-1.5">
                                    <i class="fa-solid fa-circle-check text-emerald-600"></i>
                                    <span>Video Tersedia</span>
                                </span>
                            @else
                                <span class="px-2.5 sm:px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-[11px] sm:text-xs font-bold inline-flex items-center gap-1.5">
                                    <i class="fa-solid fa-triangle-exclamation text-amber-600"></i>
                                    <span>Belum Ada Video</span>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Video Preview Player Responsif -->
                    <div class="relative rounded-xl sm:rounded-2xl overflow-hidden bg-zinc-950 aspect-video border border-zinc-200 flex items-center justify-center">
                        @if($video->isLocalFile())
                            <video controls poster="{{ $video->poster_image ? asset($video->poster_image) : '' }}" class="w-full h-full object-contain">
                                <source src="{{ $video->play_source }}" type="video/mp4">
                                Browser Anda tidak mendukung pemutar video.
                            </video>
                        @elseif($video->play_source)
                            <iframe src="{{ $video->play_source }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                        @else
                            <div class="text-center p-4 sm:p-6 space-y-2">
                                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-zinc-800 flex items-center justify-center mx-auto text-zinc-400 text-xl sm:text-2xl">
                                    <i class="fa-solid fa-film"></i>
                                </div>
                                <p class="text-zinc-300 text-xs font-semibold">Video belum diunggah atau ditautkan</p>
                                <p class="text-zinc-500 text-[11px]">Gunakan form di bawah untuk upload MP4 atau masukkan URL YouTube</p>
                            </div>
                        @endif
                    </div>

                    <!-- Status File Saat Ini -->
                    <div class="p-3 rounded-xl bg-zinc-50 border border-zinc-200 text-xs space-y-1.5">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-0.5 text-zinc-500">
                            <span class="font-semibold text-zinc-600">Sumber Video:</span>
                            <span class="font-mono font-bold text-zinc-900 break-all sm:truncate sm:max-w-[280px]">
                                {{ $video->video_file ?? ($video->video_url ?? 'Belum ada sumber video') }}
                            </span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-0.5 text-zinc-500">
                            <span class="font-semibold text-zinc-600">Poster / Thumbnail:</span>
                            <span class="font-mono text-zinc-700 break-all sm:truncate sm:max-w-[280px]">
                                {{ $video->poster_image ?? 'Default Thumbnail' }}
                            </span>
                        </div>
                    </div>

                    <!-- Form Edit Video -->
                    <form action="{{ route('admin.videos.update', $video->id) }}" method="POST" enctype="multipart/form-data" class="space-y-3.5 pt-1">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="video_key" value="{{ $video->video_key }}">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 sm:gap-3 text-xs">
                            <div>
                                <label class="font-bold text-zinc-700 block mb-1">Judul Pengujian</label>
                                <input type="text" name="title" value="{{ $video->title }}" required class="w-full px-3 py-2 sm:py-2.5 rounded-xl border border-zinc-300 text-xs sm:text-sm focus:border-rail-500 focus:outline-none">
                            </div>
                            <div>
                                <label class="font-bold text-zinc-700 block mb-1">Badge / Tag Pengujian</label>
                                <input type="text" name="badge" value="{{ $video->badge }}" placeholder="UJI-01 • 3 Mode Kecepatan" class="w-full px-3 py-2 sm:py-2.5 rounded-xl border border-zinc-300 text-xs sm:text-sm focus:border-rail-500 focus:outline-none">
                            </div>
                        </div>

                        <div class="text-xs">
                            <label class="font-bold text-zinc-700 block mb-1">Deskripsi Hasil Uji</label>
                            <textarea name="description" rows="2" class="w-full px-3 py-2 sm:py-2.5 rounded-xl border border-zinc-300 text-xs sm:text-sm focus:border-rail-500 focus:outline-none">{{ $video->description }}</textarea>
                        </div>

                        <!-- Opsi Input Video -->
                        <div class="p-3.5 sm:p-4 rounded-xl sm:rounded-2xl bg-zinc-50 border border-zinc-200 space-y-3 text-xs">
                            <span class="font-bold text-zinc-800 flex items-center gap-1.5 text-xs sm:text-sm">
                                <i class="fa-solid fa-file-video text-rail-500"></i>
                                <span>Pilihan Berkas Video:</span>
                            </span>

                            <!-- 1. Upload Video Baru -->
                            <div>
                                <label class="text-zinc-600 font-semibold block mb-1">1. Unggah Video Baru (.mp4 / .webm)</label>
                                <input type="file" name="video_file" accept="video/mp4,video/webm,video/mov" class="w-full text-xs text-zinc-600 file:mr-2 sm:file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-rail-500 file:text-white hover:file:bg-rail-600">
                            </div>

                            <!-- 2. Pilih dari file server yang ada -->
                            <div>
                                <label class="text-zinc-600 font-semibold block mb-1">2. Atau Pilih File yang Ada di Server</label>
                                <select name="existing_video_file" class="w-full px-3 py-2 rounded-xl border border-zinc-300 bg-white text-xs">
                                    <option value="">-- Tetap Gunakan yang Sekarang --</option>
                                    @foreach($availableVideos as $av)
                                        <option value="{{ $av }}" {{ $video->video_file === $av ? 'selected' : '' }}>
                                            📁 {{ $av }}
                                        </option>
                                    @endforeach
                                    <option value="__REMOVE__">❌ Hapus File Video (Kosongkan)</option>
                                </select>
                            </div>

                            <!-- 3. Masukkan URL YouTube / Eksternal -->
                            <div>
                                <label class="text-zinc-600 font-semibold block mb-1">3. Atau Tautan YouTube / URL Embed</label>
                                <input type="text" name="video_url" value="{{ $video->video_url }}" placeholder="https://www.youtube.com/watch?v=... atau link mp4" class="w-full px-3 py-2 rounded-xl border border-zinc-300 bg-white text-xs focus:border-rail-500 focus:outline-none">
                            </div>
                        </div>

                        <!-- Opsi Input Poster / Thumbnail -->
                        <div class="p-3.5 sm:p-4 rounded-xl sm:rounded-2xl bg-zinc-50 border border-zinc-200 space-y-3 text-xs">
                            <span class="font-bold text-zinc-800 flex items-center gap-1.5 text-xs sm:text-sm">
                                <i class="fa-solid fa-image text-rail-500"></i>
                                <span>Pilihan Poster / Gambar Sampul Video:</span>
                            </span>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 sm:gap-3">
                                <div>
                                    <label class="text-zinc-600 font-semibold block mb-1">Unggah Poster Baru</label>
                                    <input type="file" name="poster_image" accept="image/*" class="w-full text-xs text-zinc-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-zinc-900 file:text-white">
                                </div>
                                <div>
                                    <label class="text-zinc-600 font-semibold block mb-1">Atau Pilih dari Galeri</label>
                                    <select name="existing_poster_image" class="w-full px-2.5 py-1.5 rounded-xl border border-zinc-300 bg-white text-xs">
                                        <option value="">-- Tetap Gunakan yang Sekarang --</option>
                                        @foreach($availableImages as $ai)
                                            <option value="{{ $ai }}" {{ $video->poster_image === $ai ? 'selected' : '' }}>
                                                {{ basename($ai) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="pt-1">
                            <button type="submit" class="w-full py-2.5 sm:py-3 rounded-xl bg-rail-500 hover:bg-rail-600 text-white font-bold transition shadow-md shadow-rail-500/20 text-xs sm:text-sm flex items-center justify-center gap-2">
                                <i class="fa-solid fa-floppy-disk"></i>
                                <span>Simpan Perubahan Video ({{ strtoupper($video->video_key) }})</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- ===================================================================== -->
    <!-- TAB 2: MANAJEMEN GAMBAR LANDING PAGE (3 BAGIAN UTAMA DI HOME)         -->
    <!-- ===================================================================== -->
    <div x-show="tab === 'landing_images'" class="space-y-6 sm:space-y-8" x-cloak>
        <div class="bg-gradient-to-r from-zinc-900 to-zinc-800 text-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 border border-zinc-700/60 shadow-lg">
            <h3 class="font-extrabold text-sm sm:text-base">Manajemen Gambar Landing Page Home</h3>
            <p class="text-xs text-zinc-300 mt-1">
                Ganti 3 gambar penting di halaman utama (Hero Section 3D, Blueprint CAD Dimensi, dan Foto Evaluasi Lapangan).
            </p>
        </div>

        @php
        $landingImages = [
            [
                'key' => 'hero_image',
                'title' => 'Foto Kartu Hero (Depan)',
                'location' => 'Hero Section 3D (Kiri Bawah)',
                'default' => 'images/trolley/img8_full_front.jpeg',
                'desc' => 'Foto trolley tampak depan dengan bentangan sprayer dan rangka pelindung oranye.',
                'text_fields' => [
                    ['key' => 'hero_floating_badge', 'label' => 'Badge Foto', 'default' => '', 'type' => 'text'],
                    ['key' => 'hero_floating_footer', 'label' => 'Footer Subtitle', 'default' => 'Dual Battery • 4 Sprayer', 'type' => 'text'],
                    ['key' => 'hero_floating_card_text', 'label' => 'Deskripsi / Teks Kartu', 'default' => 'Inovasi wahana elektrik otomatis untuk pengecatan dan perawatan rel kereta api R54-70 dengan presisi tinggi.', 'type' => 'textarea'],
                    ['key' => 'hero_floating_year', 'label' => 'Tahun', 'default' => '©2026 HI 102', 'type' => 'text'],
                ]
            ],
            [
                'key' => 'blueprint_image',
                'title' => 'Gambar CAD Blueprint Dimensi',
                'location' => 'Seksi 01: Dimensi & Berat',
                'default' => 'images/trolley/blueprint_dimensi.png',
                'desc' => 'Gambar teknis proyeksi AutoCAD AC1027 dimensi P 1050 x L 1350 x T 1000 mm.',
                'text_fields' => [
                    ['key' => 'blueprint_title', 'label' => 'Judul Kartu', 'default' => 'Blueprint Teknis Trolley ASM v14', 'type' => 'text'],
                    ['key' => 'blueprint_badge_1', 'label' => 'Badge 1 (CAD)', 'default' => 'CAD Trolley full ASM v14', 'type' => 'text'],
                    ['key' => 'blueprint_badge_2', 'label' => 'Badge 2 (Software)', 'default' => 'AutoCAD AC1027', 'type' => 'text'],
                    ['key' => 'blueprint_desc', 'label' => 'Deskripsi Kartu', 'default' => 'Gambar teknis proyeksi AutoCAD AC1027 dimensi P 1050 x L 1350 x T 1000 mm dengan track gauge rel 930 mm.', 'type' => 'textarea'],
                ]
            ],
            [
                'key' => 'review_image',
                'title' => 'Foto Detail Mesin & Kursi',
                'location' => 'Seksi Evaluasi Lapangan',
                'default' => 'images/trolley/img6_top_seat.jpeg',
                'desc' => 'Foto tampak atas dudukan kursi operator aluminium dan kompartemen baterai ganda.',
                'text_fields' => [
                    ['key' => 'review_image_badge', 'label' => 'Badge Foto', 'default' => 'Implementasi Fisik', 'type' => 'text'],
                    ['key' => 'review_image_title', 'label' => 'Judul Foto', 'default' => 'Dudukan Kursi & Kompartemen', 'type' => 'text'],
                    ['key' => 'review_image_desc', 'label' => 'Deskripsi Foto', 'default' => 'Tampak atas dudukan kursi operator aluminium dan kompartemen baterai ganda.', 'type' => 'textarea'],
                ]
            ]
        ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
            @foreach($landingImages as $img)
            @php
                $currentVal = $settings[$img['key']] ?? $img['default'];
            @endphp
            <div class="bg-white rounded-2xl sm:rounded-[28px] p-4 sm:p-5 border border-zinc-200 shadow-sm flex flex-col justify-between space-y-3.5">
                <div class="space-y-2.5">
                    <div>
                        <span class="px-2.5 py-0.5 rounded-full bg-rail-100 text-rail-700 font-mono text-[10px] font-bold uppercase">
                            {{ $img['location'] }}
                        </span>
                        <h4 class="font-extrabold text-zinc-900 text-sm mt-1.5">{{ $img['title'] }}</h4>
                    </div>

                    <!-- Preview Gambar -->
                    <div class="relative rounded-xl overflow-hidden bg-zinc-100 aspect-video border border-zinc-200 shadow-inner group">
                        <img src="{{ asset($currentVal) }}" alt="{{ $img['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/70 via-transparent to-transparent flex items-end p-2.5">
                            <span class="text-[10px] font-mono text-zinc-200 truncate">{{ $currentVal }}</span>
                        </div>
                    </div>

                    <p class="text-xs text-zinc-500 leading-relaxed">{{ $img['desc'] }}</p>
                </div>

                <!-- Form Upload / Ganti Gambar & Teks Card -->
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="pt-2 border-t border-zinc-100 space-y-3 text-xs">
                    @csrf
                    <input type="hidden" name="active_tab" value="landing_images">

                    <div>
                        <label class="font-bold text-zinc-700 block mb-1">Unggah Berkas Baru:</label>
                        <input type="file" name="{{ $img['key'] }}_file" accept="image/*" class="w-full text-xs text-zinc-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-rail-500 file:text-white hover:file:bg-rail-600">
                    </div>

                    <div>
                        <label class="font-bold text-zinc-700 block mb-1">Atau Pilih dari Galeri:</label>
                        <select name="{{ $img['key'] }}" class="w-full px-2.5 py-1.5 rounded-xl border border-zinc-300 bg-white text-xs font-mono">
                            <option value="{{ $currentVal }}">{{ basename($currentVal) }} (Saat Ini)</option>
                            @foreach($availableImages as $ai)
                                @if($ai !== $currentVal)
                                    <option value="{{ $ai }}">{{ basename($ai) }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    @if(!empty($img['text_fields']))
                    <div class="pt-2 border-t border-dashed border-zinc-200 space-y-2">
                        <span class="font-bold text-zinc-700 block text-[11px] uppercase tracking-wider font-mono">Teks & Redaksi Kartu:</span>
                        @foreach($img['text_fields'] as $tf)
                        @php
                            $fieldVal = array_key_exists($tf['key'], $settings) ? $settings[$tf['key']] : $tf['default'];
                        @endphp
                        <div>
                            <label class="block text-[11px] font-semibold text-zinc-600 mb-0.5">{{ $tf['label'] }}</label>
                            @if($tf['type'] === 'textarea')
                            <textarea name="{{ $tf['key'] }}" rows="2" placeholder="Kosongkan jika ingin menyembunyikan" class="w-full px-2.5 py-1.5 rounded-lg border border-zinc-300 text-xs focus:border-rail-500 focus:outline-none">{{ $fieldVal }}</textarea>
                            @else
                            <input type="text" name="{{ $tf['key'] }}" value="{{ $fieldVal }}" placeholder="Kosongkan jika ingin menyembunyikan" class="w-full px-2.5 py-1.5 rounded-lg border border-zinc-300 text-xs focus:border-rail-500 focus:outline-none">
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <button type="submit" class="w-full py-2.5 rounded-xl bg-zinc-900 hover:bg-rail-500 text-white font-bold transition text-xs flex items-center justify-center gap-1.5 shadow-sm">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Gambar & Redaksi Kartu</span>
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </div>

    <!-- ===================================================================== -->
    <!-- TAB 3: KELOLA KOMPONEN & GALERI IMPLEMENTASI (CAD & FISIK)            -->
    <!-- ===================================================================== -->
    <div x-show="tab === 'komponen'" class="space-y-6 sm:space-y-8" x-cloak>
        
        <!-- Form Tambah Komponen Baru -->
        <div class="bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 lg:p-8 border border-zinc-200 shadow-sm space-y-4">
            <h2 class="text-base sm:text-lg font-extrabold text-zinc-900 inline-flex items-center gap-2">
                <i class="fa-solid fa-plus text-rail-500 text-sm"></i>
                <span>Tambah Foto Komponen / Implementasi Baru</span>
            </h2>
            <form action="{{ route('admin.components.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 text-xs">
                @csrf
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Nama Komponen</label>
                    <input type="text" name="name" placeholder="Misal: Manometer & Katup Regulasi" required class="w-full px-3 py-2 sm:py-2.5 rounded-xl border border-zinc-300 focus:border-rail-500 focus:outline-none">
                </div>
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Kode Layer CAD</label>
                    <input type="text" name="code" placeholder="Misal: BLDC motor v5, chair v1" class="w-full px-3 py-2 sm:py-2.5 rounded-xl border border-zinc-300 focus:border-rail-500 focus:outline-none">
                </div>
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Kategori</label>
                    <select name="category" class="w-full px-3 py-2 sm:py-2.5 rounded-xl border border-zinc-300 bg-white">
                        <option value="Sasis & Rangka">Sasis & Rangka</option>
                        <option value="Sistem Pengecatan">Sistem Pengecatan</option>
                        <option value="Kontrol & Elektrikal">Kontrol & Elektrikal</option>
                        <option value="Penggerak & Roda">Penggerak & Roda</option>
                        <option value="Penggerak & Rem">Penggerak & Rem</option>
                        <option value="Dokumen Teknis">Dokumen Teknis</option>
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="font-bold text-zinc-600 block mb-1">Deskripsi Teknis Komponen</label>
                    <input type="text" name="description" placeholder="Penjelasan fungsi, material, dan penempatan komponen..." required class="w-full px-3 py-2 sm:py-2.5 rounded-xl border border-zinc-300 focus:border-rail-500 focus:outline-none">
                </div>
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Spesifikasi Singkat</label>
                    <input type="text" name="specification" placeholder="Misal: 1350mm | 200 Bar | LiFePO4" class="w-full px-3 py-2 sm:py-2.5 rounded-xl border border-zinc-300 focus:border-rail-500 focus:outline-none">
                </div>
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Upload Foto Baru</label>
                    <input type="file" name="image" accept="image/*" class="w-full text-xs text-zinc-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:bg-rail-500 file:text-white file:font-bold">
                </div>
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Atau Pilih dari Galeri</label>
                    <select name="existing_image" class="w-full px-3 py-2 sm:py-2.5 rounded-xl border border-zinc-300 bg-white">
                        <option value="">-- Unggah file baru atau pilih --</option>
                        @foreach($availableImages as $ai)
                            <option value="{{ $ai }}">{{ basename($ai) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Urutan Tampil</label>
                    <input type="number" name="sort_order" value="10" class="w-full px-3 py-2 sm:py-2.5 rounded-xl border border-zinc-300 focus:border-rail-500 focus:outline-none">
                </div>
                <div class="sm:col-span-2 lg:col-span-3 pt-2">
                    <button type="submit" class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-rail-500 hover:bg-rail-600 text-white font-bold transition shadow-md shadow-rail-500/20 text-xs sm:text-sm">
                        Tambah Komponen Baru
                    </button>
                </div>
            </form>
        </div>

        <!-- Grid Komponen Saat Ini -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
            @foreach($components as $comp)
            <div class="bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-5 border border-zinc-200 shadow-sm flex flex-col sm:flex-row gap-4 items-stretch sm:items-start">
                <div class="w-full sm:w-36 h-44 sm:h-36 rounded-xl sm:rounded-2xl overflow-hidden bg-zinc-100 flex-shrink-0 border border-zinc-200">
                    <img src="{{ asset($comp->image_path) }}" alt="{{ $comp->name }}" class="w-full h-full object-cover">
                </div>
                <form action="{{ route('admin.components.update', $comp->id) }}" method="POST" enctype="multipart/form-data" class="flex-1 space-y-2.5 text-xs w-full">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="text-[10px] font-mono uppercase text-zinc-400 font-bold block">Nama Komponen</label>
                        <input type="text" name="name" value="{{ $comp->name }}" class="w-full px-3 py-1.5 rounded-lg border border-zinc-300 font-bold">
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div>
                            <label class="text-[10px] font-mono uppercase text-zinc-400 font-bold block">Kode CAD</label>
                            <input type="text" name="code" value="{{ $comp->code }}" class="w-full px-2.5 py-1.5 rounded-lg border border-zinc-300 font-mono">
                        </div>
                        <div>
                            <label class="text-[10px] uppercase text-zinc-400 font-bold block">Kategori</label>
                            <select name="category" class="w-full px-2.5 py-1.5 rounded-lg border border-zinc-300 bg-white">
                                @foreach(['Sasis & Rangka', 'Sistem Pengecatan', 'Kontrol & Elektrikal', 'Penggerak & Roda', 'Penggerak & Rem', 'Sasis & Ergonomi', 'Dokumen Teknis'] as $cat)
                                    <option value="{{ $cat }}" {{ $comp->category === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-mono uppercase text-zinc-400 font-bold block">Spesifikasi</label>
                            <input type="text" name="specification" value="{{ $comp->specification }}" class="w-full px-2.5 py-1.5 rounded-lg border border-zinc-300">
                        </div>
                    </div>
                    <div>
                        <label class="text-[10px] font-mono uppercase text-zinc-400 font-bold block">Deskripsi</label>
                        <textarea name="description" rows="2" class="w-full px-2.5 py-1.5 rounded-lg border border-zinc-300">{{ $comp->description }}</textarea>
                    </div>
                    <div class="space-y-2 pt-2 border-t border-zinc-100">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <div>
                                <label class="text-[10px] uppercase text-zinc-500 font-bold block mb-0.5">Pilih dari Galeri:</label>
                                <select name="existing_image" class="w-full px-2 py-1.5 rounded-lg border border-zinc-300 bg-white text-[11px]">
                                    <option value="{{ $comp->image_path }}">{{ basename($comp->image_path) }} (Saat Ini)</option>
                                    @foreach($availableImages as $ai)
                                        @if($ai !== $comp->image_path)
                                            <option value="{{ $ai }}">{{ basename($ai) }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-[10px] uppercase text-zinc-500 font-bold block mb-0.5">Atau Upload Gambar Baru:</label>
                                <input type="file" name="image" accept="image/*" class="w-full text-[11px] text-zinc-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-[10px] file:font-bold file:bg-rail-500 file:text-white hover:file:bg-rail-600">
                            </div>
                        </div>
                        <div class="flex items-center justify-end gap-2 pt-1">
                            <button type="submit" class="px-4 py-1.5 rounded-lg bg-zinc-900 hover:bg-rail-500 text-white font-bold transition flex items-center gap-1.5">
                                <i class="fa-solid fa-floppy-disk text-xs"></i>
                                <span>Simpan Perubahan</span>
                            </button>
                        </div>
                    </div>
                </form>
                <form action="{{ route('admin.components.delete', $comp->id) }}" method="POST" onsubmit="return confirm('Hapus komponen ini?')" class="self-end sm:self-start">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 text-xs flex items-center justify-center transition" title="Hapus Komponen">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </div>

    <!-- ===================================================================== -->
    <!-- TAB 4: KELOLA DATA HASIL PENGUJIAN (TABEL & GRAFIK)                   -->
    <!-- ===================================================================== -->
    <div x-show="tab === 'pengujian'" class="space-y-6 sm:space-y-8" x-cloak>
        <!-- Form Tambah Data Pengujian Baru -->
        <div class="bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 lg:p-8 border border-zinc-200 shadow-sm space-y-4">
            <h2 class="text-base sm:text-lg font-extrabold text-zinc-900 inline-flex items-center gap-2">
                <i class="fa-solid fa-plus text-rail-500 text-sm"></i>
                <span>Tambah Data Hasil Pengujian Baru</span>
            </h2>
            <form action="{{ route('admin.tests.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 text-xs">
                @csrf
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Kode Uji</label>
                    <input type="text" name="test_code" placeholder="UJI-07" required class="w-full px-3 py-2 sm:py-2.5 rounded-xl border border-zinc-300">
                </div>
                <div class="sm:col-span-2">
                    <label class="font-bold text-zinc-600 block mb-1">Parameter Pengujian</label>
                    <input type="text" name="parameter" placeholder="Misal: Konsumsi Daya Motor BLDC" required class="w-full px-3 py-2 sm:py-2.5 rounded-xl border border-zinc-300">
                </div>
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Kategori</label>
                    <input type="text" name="category" placeholder="Performa / Sprayer / Baterai" required class="w-full px-3 py-2 sm:py-2.5 rounded-xl border border-zinc-300">
                </div>
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Nilai Hasil Uji (Angka)</label>
                    <input type="number" step="0.01" name="result_value" placeholder="95.5" required class="w-full px-3 py-2 sm:py-2.5 rounded-xl border border-zinc-300">
                </div>
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Target / Maksimum (Angka)</label>
                    <input type="number" step="0.01" name="target_value" placeholder="100" class="w-full px-3 py-2 sm:py-2.5 rounded-xl border border-zinc-300">
                </div>
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Satuan (Unit)</label>
                    <input type="text" name="unit" placeholder="km/jam, Bar, %, Meter" required class="w-full px-3 py-2 sm:py-2.5 rounded-xl border border-zinc-300">
                </div>
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Status</label>
                    <input type="text" name="status" value="Optimal" required class="w-full px-3 py-2 sm:py-2.5 rounded-xl border border-zinc-300">
                </div>
                <div class="sm:col-span-2 lg:col-span-3">
                    <label class="font-bold text-zinc-600 block mb-1">Catatan Pengujian</label>
                    <input type="text" name="notes" placeholder="Keterangan kondisi pengujian..." class="w-full px-3 py-2 sm:py-2.5 rounded-xl border border-zinc-300">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full py-2.5 rounded-xl bg-rail-500 hover:bg-rail-600 text-white font-bold transition">
                        Simpan Data Uji
                    </button>
                </div>
            </form>
        </div>

        <!-- Daftar Data Pengujian Responsif (Card-based pada layar sedang/kecil) -->
        <div class="space-y-3">
            <h3 class="font-extrabold text-zinc-900 text-sm sm:text-base">Daftar Data Pengujian Saat Ini</h3>
            
            <div class="space-y-3">
                @foreach($testResults as $tr)
                <div class="bg-white rounded-2xl p-4 sm:p-5 border border-zinc-200 shadow-sm space-y-3">
                    <div class="flex items-center justify-between border-b border-zinc-100 pb-2">
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-1 rounded-lg bg-zinc-900 text-rail-400 font-mono text-xs font-bold">{{ $tr->test_code }}</span>
                            <span class="px-2.5 py-0.5 rounded-full bg-rail-100 text-rail-700 text-[11px] font-semibold">{{ $tr->category }}</span>
                        </div>
                        <form action="{{ route('admin.tests.delete', $tr->id) }}" method="POST" onsubmit="return confirm('Hapus data uji ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-2.5 py-1 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 text-xs font-bold flex items-center gap-1 transition">
                                <i class="fa-solid fa-trash-can text-[10px]"></i>
                                <span>Hapus</span>
                            </button>
                        </form>
                    </div>

                    <form action="{{ route('admin.tests.update', $tr->id) }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-2.5 text-xs">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="test_code" value="{{ $tr->test_code }}">

                        <div class="sm:col-span-2">
                            <label class="text-[10px] font-mono text-zinc-400 block mb-0.5">PARAMETER</label>
                            <input type="text" name="parameter" value="{{ $tr->parameter }}" class="w-full px-2.5 py-1.5 rounded-lg border border-zinc-300 font-semibold">
                        </div>

                        <div>
                            <label class="text-[10px] font-mono text-zinc-400 block mb-0.5">KATEGORI</label>
                            <input type="text" name="category" value="{{ $tr->category }}" class="w-full px-2.5 py-1.5 rounded-lg border border-zinc-300">
                        </div>

                        <div>
                            <label class="text-[10px] font-mono text-zinc-400 block mb-0.5">NILAI & SATUAN</label>
                            <div class="flex gap-1">
                                <input type="number" step="0.01" name="result_value" value="{{ $tr->result_value }}" class="w-3/5 px-2 py-1.5 rounded-lg border border-zinc-300 font-mono">
                                <input type="text" name="unit" value="{{ $tr->unit }}" class="w-2/5 px-1.5 py-1.5 rounded-lg border border-zinc-300 text-center">
                            </div>
                        </div>

                        <div class="sm:col-span-2 lg:col-span-1">
                            <label class="text-[10px] font-mono text-zinc-400 block mb-0.5">CATATAN</label>
                            <input type="text" name="notes" value="{{ $tr->notes }}" class="w-full px-2.5 py-1.5 rounded-lg border border-zinc-300">
                        </div>

                        <div class="flex items-end sm:col-span-2 md:col-span-3 lg:col-span-1">
                            <button type="submit" class="w-full py-2 rounded-lg bg-zinc-900 hover:bg-rail-500 text-white font-bold transition text-xs flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-floppy-disk text-[11px]"></i>
                                <span>Simpan</span>
                            </button>
                        </div>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- ===================================================================== -->
    <!-- TAB 5: KELOLA TIM PENGEMBANG                                          -->
    <!-- ===================================================================== -->
    <div x-show="tab === 'tim'" class="space-y-6 sm:space-y-8" x-cloak>
        <div class="bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 lg:p-8 border border-zinc-200 shadow-sm space-y-4">
            <h2 class="text-base sm:text-lg font-extrabold text-zinc-900 inline-flex items-center gap-2">
                <i class="fa-solid fa-plus text-rail-500 text-sm"></i>
                <span>Tambah Anggota Tim Pengembang</span>
            </h2>
            <form action="{{ route('admin.team.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 text-xs">
                @csrf
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Nama Lengkap & Gelar</label>
                    <input type="text" name="name" required class="w-full px-3 py-2 sm:py-2.5 rounded-xl border border-zinc-300">
                </div>
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Jabatan / Peran</label>
                    <input type="text" name="role" placeholder="Mechanical Engineer" required class="w-full px-3 py-2 sm:py-2.5 rounded-xl border border-zinc-300">
                </div>
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">NIM / NIP / ID</label>
                    <input type="text" name="identity_number" placeholder="HI-102-005" class="w-full px-3 py-2 sm:py-2.5 rounded-xl border border-zinc-300">
                </div>
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Spesialisasi Bagian Alat</label>
                    <input type="text" name="specialization" placeholder="Desain Rangka & Roda" class="w-full px-3 py-2 sm:py-2.5 rounded-xl border border-zinc-300">
                </div>
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Bio Singkat</label>
                    <input type="text" name="bio" class="w-full px-3 py-2 sm:py-2.5 rounded-xl border border-zinc-300">
                </div>
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Foto Profil (Opsional)</label>
                    <input type="file" name="photo" accept="image/*" class="w-full text-xs text-zinc-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:bg-rail-500 file:text-white file:font-bold">
                </div>
                <div class="sm:col-span-2 lg:col-span-3 pt-2">
                    <button type="submit" class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-rail-500 text-white font-bold text-xs sm:text-sm">
                        Tambah Anggota Tim
                    </button>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
            @foreach($teams as $tm)
            <div class="bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-5 border border-zinc-200 shadow-sm flex flex-col sm:flex-row gap-4 items-center sm:items-start">
                <div class="w-16 h-16 rounded-full overflow-hidden bg-zinc-100 flex-shrink-0 border border-zinc-200">
                    <img src="{{ asset($tm->photo_path) }}" alt="{{ $tm->name }}" class="w-full h-full object-cover">
                </div>
                <form action="{{ route('admin.team.update', $tm->id) }}" method="POST" enctype="multipart/form-data" class="flex-1 space-y-2 text-xs w-full">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <input type="text" name="name" value="{{ $tm->name }}" class="px-2.5 py-1.5 rounded-lg border border-zinc-300 font-bold">
                        <input type="text" name="role" value="{{ $tm->role }}" class="px-2.5 py-1.5 rounded-lg border border-zinc-300">
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <input type="text" name="identity_number" value="{{ $tm->identity_number }}" class="px-2.5 py-1.5 rounded-lg border border-zinc-300 font-mono">
                        <input type="text" name="specialization" value="{{ $tm->specialization }}" class="px-2.5 py-1.5 rounded-lg border border-zinc-300">
                    </div>
                    <textarea name="bio" rows="2" class="w-full px-2.5 py-1.5 rounded-lg border border-zinc-300">{{ $tm->bio }}</textarea>
                    <div class="flex flex-wrap items-center justify-between gap-2 pt-1 border-t border-zinc-100">
                        <input type="file" name="photo" class="text-[10px] text-zinc-500 max-w-[180px]">
                        <button type="submit" class="px-3.5 py-1.5 rounded-lg bg-zinc-900 hover:bg-rail-500 text-white font-bold transition">
                            Update
                        </button>
                    </div>
                </form>
                <form action="{{ route('admin.team.delete', $tm->id) }}" method="POST" onsubmit="return confirm('Hapus anggota tim ini?')" class="self-end sm:self-start">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 text-xs flex items-center justify-center transition" title="Hapus Anggota">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </div>

    <!-- ===================================================================== -->
    <!-- TAB 6: PENGATURAN PASSWORD ADMIN                                      -->
    <!-- ===================================================================== -->
    <div x-show="tab === 'password'" class="bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 lg:p-8 border border-zinc-200 shadow-sm max-w-xl mx-auto space-y-6" x-cloak>
        <div class="border-b border-zinc-200 pb-4">
            <h2 class="text-lg sm:text-xl font-extrabold text-zinc-900 flex items-center gap-2">
                <i class="fa-solid fa-shield-halved text-rail-500"></i>
                <span>Ganti Password Akses Admin</span>
            </h2>
            <p class="text-xs text-zinc-500 mt-1">Ubah kata sandi untuk login ke panel kontrol CMS HI 102.</p>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="active_tab" value="password">
            <div>
                <label class="block text-xs font-bold text-zinc-700 mb-1">Password Admin Baru</label>
                <input type="text" name="admin_password" value="{{ $settings['admin_password'] ?? 'admin123' }}" required class="w-full px-3 py-2.5 rounded-xl border border-zinc-300 text-xs sm:text-sm font-mono focus:border-rail-500 focus:outline-none">
                <span class="text-[10px] text-zinc-400 block mt-1">Default: admin123</span>
            </div>

            <button type="submit" class="w-full py-2.5 sm:py-3 rounded-xl bg-rail-500 hover:bg-rail-600 text-white text-xs sm:text-sm font-bold shadow-md shadow-rail-500/30 transition flex items-center justify-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Simpan Password Baru</span>
            </button>
        </form>
    </div>

</div>
@endsection
