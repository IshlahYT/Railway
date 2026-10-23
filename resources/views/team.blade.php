@extends('layouts.app')

@section('content')
<div class="max-w-[1400px] mx-auto px-4 sm:px-8 space-y-16 pt-6">

    <!-- Header Tim Pengembang -->
    <section class="rounded-[32px] bg-zinc-900 text-white p-8 sm:p-14 relative overflow-hidden">
        <div class="max-w-2xl space-y-4 relative z-10">
            <span class="px-3.5 py-1.5 rounded-full bg-rail-500 text-white text-xs font-extrabold uppercase tracking-wider">
                Divisi R&D • {{ $settings['brand_name'] ?? 'HI 102' }}
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight">
                Tim Pengembang & Peneliti Wahana HI 102
            </h1>
            <p class="text-sm sm:text-base text-zinc-300 leading-relaxed">
                Kolaborasi multidisiplin teknik mesin, kontrol elektrikal BLDC, dan sistem otomasi fluida untuk menghadirkan solusi perawatan jalan rel kereta api modern.
            </p>
        </div>
        <div class="absolute -right-20 -bottom-20 w-96 h-96 rounded-full bg-rail-500/20 blur-3xl pointer-events-none"></div>
    </section>

    <!-- Grid Anggota Tim (Dapat ditambah/diedit dari Admin) -->
    <section class="space-y-8">
        <div class="flex items-center justify-between">
            <div>
                <span class="text-xs font-mono text-rail-600 font-bold uppercase">Struktur Tim</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-zinc-900">Personel Inti Proyek</h2>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($teams as $member)
            <div class="bento-card bg-white rounded-[28px] p-6 border border-zinc-200/80 shadow-sm flex flex-col justify-between space-y-4">
                <div class="space-y-4">
                    <div class="w-20 h-20 rounded-2xl overflow-hidden bg-rail-100 border-2 border-rail-500/30">
                        <img src="{{ str_starts_with($member->photo_path, 'http') ? $member->photo_path : asset($member->photo_path) }}" 
                             alt="{{ $member->name }}" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <span class="text-[11px] font-mono text-rail-600 font-bold">{{ $member->identity_number }}</span>
                        <h3 class="text-lg font-extrabold text-zinc-900 mt-0.5">{{ $member->name }}</h3>
                        <p class="text-xs font-semibold text-zinc-600">{{ $member->role }}</p>
                    </div>
                    <p class="text-xs text-zinc-500 leading-relaxed">
                        {{ $member->bio }}
                    </p>
                </div>

                <div class="pt-3 border-t border-zinc-100">
                    <span class="text-[10px] font-mono uppercase text-zinc-400 block">Spesialisasi</span>
                    <span class="text-xs font-bold text-zinc-800">{{ $member->specialization }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Daftar Bill of Materials (BOM) dari File CAD DXF Trolley full ASM v14 -->
    <section class="bg-white rounded-[32px] p-6 sm:p-10 border border-zinc-200/80 shadow-sm space-y-6">
        <div>
            <span class="text-xs font-mono text-rail-600 font-bold uppercase">Data Engineering CAD (AC1027)</span>
            <h2 class="text-2xl font-extrabold text-zinc-900">Daftar Sub-Assembly CAD HI 102</h2>
            <p class="text-xs text-zinc-500 mt-1">Diekstrak langsung dari struktur layer file gambar kerja <code>Trolley full ASM v14.dxf</code>.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 font-mono text-xs">
            <div class="p-4 rounded-2xl bg-zinc-50 border border-zinc-200 space-y-1">
                <span class="text-rail-600 font-bold">01. Sasis & Rangka</span>
                <p class="text-zinc-600">rangka dalam v9, rangka belakang v6, Chasis v4, pagar v1, pagar 2 v1, Bordes Aluminium</p>
            </div>
            <div class="p-4 rounded-2xl bg-zinc-50 border border-zinc-200 space-y-1">
                <span class="text-rail-600 font-bold">02. Propulsi & Roda</span>
                <p class="text-zinc-600">BLDC motor v5, in-wheel_200 v10, roda_v3, Front Wheel v1, Rail 1067 R54-70</p>
            </div>
            <div class="p-4 rounded-2xl bg-zinc-50 border border-zinc-200 space-y-1">
                <span class="text-rail-600 font-bold">03. Pengereman & Kontrol</span>
                <p class="text-zinc-600">tromol v1, Brake v1, ParkBrakeLever v1, Panel assembly v1, Gas v4, Mode v4, Forward-reverse v3</p>
            </div>
            <div class="p-4 rounded-2xl bg-zinc-50 border border-zinc-200 space-y-1">
                <span class="text-rail-600 font-bold">04. Sistem Airless Sprayer</span>
                <p class="text-zinc-600">mesin airless v7, sprayer new assembly v2 (4 unit), Tee pneumatik v1, Y v1, Filter v2, pressure_gauge v1</p>
            </div>
            <div class="p-4 rounded-2xl bg-zinc-50 border border-zinc-200 space-y-1">
                <span class="text-rail-600 font-bold">05. Elektrikal & Proteksi</span>
                <p class="text-zinc-600">Baterai v1 (Dual Unit), inverter v1, Emergency Stop Switch v1, Signal lamp v1, lampu trolley orange/red</p>
            </div>
            <div class="p-4 rounded-2xl bg-zinc-50 border border-zinc-200 space-y-1">
                <span class="text-rail-600 font-bold">06. Ergonomi Operator</span>
                <p class="text-zinc-600">chair v1 (Dual Operator Seat 380x380mm), Table New v6, pangkon v4</p>
            </div>
        </div>
    </section>

</div>
@endsection
