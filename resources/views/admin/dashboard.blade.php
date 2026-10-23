@extends('layouts.app')

@section('content')
<div class="max-w-[1400px] mx-auto px-4 sm:px-8 py-8 space-y-12" x-data="{ tab: 'pengujian' }">

    <!-- Header Dashboard -->
    <div class="bg-zinc-900 text-white rounded-[28px] p-6 sm:p-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="text-xs font-mono text-rail-400 uppercase">Control Panel CMS</span>
            <h1 class="text-2xl sm:text-3xl font-extrabold">Manajemen Konten & Data Pengujian HI 102</h1>
            <p class="text-xs text-zinc-400 mt-1">Semua perubahan langsung tampil secara real-time di halaman utama website.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" target="_blank" class="px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 text-xs font-bold transition inline-flex items-center gap-1.5">
                <span>Lihat Website</span>
                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
            </a>
            <a href="{{ route('admin.logout') }}" class="px-4 py-2 rounded-full bg-red-500/20 text-red-300 hover:bg-red-500/30 text-xs font-bold transition inline-flex items-center gap-1.5">
                <i class="fa-solid fa-right-from-bracket text-xs"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-bold flex items-center gap-2">
        <i class="fa-solid fa-circle-check"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Navigasi Tab Admin -->
    <div class="flex flex-wrap gap-2 border-b border-zinc-200 pb-4">
        <button @click="tab = 'pengujian'" :class="tab === 'pengujian' ? 'bg-rail-500 text-white' : 'bg-white text-zinc-700 border border-zinc-200'"
                class="px-5 py-2.5 rounded-full text-xs font-bold transition inline-flex items-center gap-2">
            <i class="fa-solid fa-chart-column"></i>
            <span>1. Data Hasil Pengujian ({{ $testResults->count() }})</span>
        </button>
        <button @click="tab = 'elemen'" :class="tab === 'elemen' ? 'bg-rail-500 text-white' : 'bg-white text-zinc-700 border border-zinc-200'"
                class="px-5 py-2.5 rounded-full text-xs font-bold transition inline-flex items-center gap-2">
            <i class="fa-solid fa-pen-to-square"></i>
            <span>2. Edit Semua Teks & Angka Website</span>
        </button>
        <button @click="tab = 'komponen'" :class="tab === 'komponen' ? 'bg-rail-500 text-white' : 'bg-white text-zinc-700 border border-zinc-200'"
                class="px-5 py-2.5 rounded-full text-xs font-bold transition inline-flex items-center gap-2">
            <i class="fa-solid fa-images"></i>
            <span>3. Galeri Implementasi & Komponen ({{ $components->count() }})</span>
        </button>
        <button @click="tab = 'tim'" :class="tab === 'tim' ? 'bg-rail-500 text-white' : 'bg-white text-zinc-700 border border-zinc-200'"
                class="px-5 py-2.5 rounded-full text-xs font-bold transition inline-flex items-center gap-2">
            <i class="fa-solid fa-users"></i>
            <span>4. Tim Pengembang ({{ $teams->count() }})</span>
        </button>
    </div>

    <!-- ================================================================= -->
    <!-- TAB 1: KELOLA DATA HASIL PENGUJIAN                                -->
    <!-- ================================================================= -->
    <div x-show="tab === 'pengujian'" class="space-y-8">
        <!-- Form Tambah Data Pengujian Baru -->
        <div class="bg-white rounded-3xl p-6 border border-zinc-200 shadow-sm space-y-4">
            <h2 class="text-lg font-extrabold text-zinc-900 inline-flex items-center gap-2">
                <i class="fa-solid fa-plus text-rail-500 text-sm"></i>
                <span>Tambah Data Hasil Pengujian Baru</span>
            </h2>
            <form action="{{ route('admin.tests.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-xs">
                @csrf
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Kode Uji</label>
                    <input type="text" name="test_code" placeholder="UJI-07" required class="w-full px-3 py-2 rounded-xl border border-zinc-300">
                </div>
                <div class="sm:col-span-2">
                    <label class="font-bold text-zinc-600 block mb-1">Parameter Pengujian</label>
                    <input type="text" name="parameter" placeholder="Misal: Konsumsi Daya Motor BLDC" required class="w-full px-3 py-2 rounded-xl border border-zinc-300">
                </div>
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Kategori</label>
                    <input type="text" name="category" placeholder="Performa / Sprayer / Baterai" required class="w-full px-3 py-2 rounded-xl border border-zinc-300">
                </div>
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Nilai Hasil Uji (Angka)</label>
                    <input type="number" step="0.01" name="result_value" placeholder="95.5" required class="w-full px-3 py-2 rounded-xl border border-zinc-300">
                </div>
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Target / Maksimum (Angka)</label>
                    <input type="number" step="0.01" name="target_value" placeholder="100" class="w-full px-3 py-2 rounded-xl border border-zinc-300">
                </div>
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Satuan (Unit)</label>
                    <input type="text" name="unit" placeholder="km/jam, Bar, %, Meter" required class="w-full px-3 py-2 rounded-xl border border-zinc-300">
                </div>
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Status</label>
                    <input type="text" name="status" value="Optimal" required class="w-full px-3 py-2 rounded-xl border border-zinc-300">
                </div>
                <div class="sm:col-span-3">
                    <label class="font-bold text-zinc-600 block mb-1">Catatan Pengujian</label>
                    <input type="text" name="notes" placeholder="Keterangan kondisi pengujian..." class="w-full px-3 py-2 rounded-xl border border-zinc-300">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full py-2.5 rounded-xl bg-rail-500 hover:bg-rail-600 text-white font-bold transition">
                        Simpan Data Uji
                    </button>
                </div>
            </form>
        </div>

        <!-- Daftar Data Pengujian yang Bisa Diedit Langsung -->
        <div class="space-y-3">
            <h3 class="font-extrabold text-zinc-900">Daftar Data Pengujian Saat Ini (Klik Simpan pada baris yang diubah)</h3>
            @foreach($testResults as $tr)
            <div class="bg-white rounded-2xl p-4 border border-zinc-200 flex flex-col lg:flex-row gap-3 items-center">
                <form action="{{ route('admin.tests.update', $tr->id) }}" method="POST" class="flex-1 grid grid-cols-1 sm:grid-cols-7 gap-2 w-full text-xs">
                    @csrf
                    @method('PUT')
                    <input type="text" name="test_code" value="{{ $tr->test_code }}" class="px-2.5 py-2 rounded-lg border border-zinc-300 font-mono font-bold">
                    <input type="text" name="parameter" value="{{ $tr->parameter }}" class="sm:col-span-2 px-2.5 py-2 rounded-lg border border-zinc-300 font-semibold">
                    <input type="text" name="category" value="{{ $tr->category }}" class="px-2.5 py-2 rounded-lg border border-zinc-300">
                    <div class="flex gap-1">
                        <input type="number" step="0.01" name="result_value" value="{{ $tr->result_value }}" class="w-1/2 px-2 py-2 rounded-lg border border-zinc-300 font-mono">
                        <input type="text" name="unit" value="{{ $tr->unit }}" class="w-1/2 px-2 py-2 rounded-lg border border-zinc-300">
                    </div>
                    <input type="text" name="notes" value="{{ $tr->notes }}" class="px-2.5 py-2 rounded-lg border border-zinc-300">
                    <button type="submit" class="px-3 py-2 rounded-lg bg-zinc-900 hover:bg-rail-500 text-white font-bold transition">
                        Update
                    </button>
                </form>
                <form action="{{ route('admin.tests.delete', $tr->id) }}" method="POST" onsubmit="return confirm('Hapus data uji ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 text-xs font-bold">Hapus</button>
                </form>
            </div>
            @endforeach
        </div>
    </div>

    <!-- ================================================================= -->
    <!-- TAB 2: EDIT SEMUA ELEMEN TEKS & ANGKA WEBSITE                     -->
    <!-- ================================================================= -->
    <div x-show="tab === 'elemen'" class="bg-white rounded-3xl p-6 sm:p-8 border border-zinc-200 shadow-sm">
        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
            @csrf
            <div class="flex items-center justify-between border-b border-zinc-200 pb-4">
                <div>
                    <h2 class="text-xl font-extrabold text-zinc-900">Edit Seluruh Elemen Landing Page</h2>
                    <p class="text-xs text-zinc-500">Ubah judul, subjudul, angka statistik, problem, solution, hingga teks marquee.</p>
                </div>
                <button type="submit" class="px-6 py-3 rounded-full bg-rail-500 hover:bg-rail-600 text-white text-xs font-bold shadow-lg shadow-rail-500/30 transition inline-flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Semua Perubahan Teks</span>
                </button>
            </div>

            @foreach($settings as $groupName => $groupItems)
            <div class="space-y-4">
                <h3 class="text-xs font-mono uppercase tracking-wider text-rail-600 font-bold border-b border-zinc-100 pb-2">
                    Grup Elemen: {{ strtoupper($groupName) }}
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($groupItems as $item)
                    <div>
                        <label class="block text-xs font-bold text-zinc-700 mb-1">{{ $item->label }} <span class="font-mono text-[10px] text-zinc-400">({{ $item->key }})</span></label>
                        @if($item->type === 'textarea')
                            <textarea name="{{ $item->key }}" rows="3" class="w-full px-3.5 py-2 rounded-xl border border-zinc-300 text-xs focus:border-rail-500 focus:outline-none">{{ $item->value }}</textarea>
                        @else
                            <input type="text" name="{{ $item->key }}" value="{{ $item->value }}" class="w-full px-3.5 py-2 rounded-xl border border-zinc-300 text-xs focus:border-rail-500 focus:outline-none">
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach

            <div class="pt-4">
                <button type="submit" class="px-6 py-3 rounded-full bg-rail-500 hover:bg-rail-600 text-white text-xs font-bold shadow-lg shadow-rail-500/30 transition inline-flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Semua Perubahan Teks</span>
                </button>
            </div>
        </form>
    </div>

    <!-- ================================================================= -->
    <!-- TAB 3: KELOLA KOMPONEN & FOTO IMPLEMENTASI                        -->
    <!-- ================================================================= -->
    <div x-show="tab === 'komponen'" class="space-y-8">
        <div class="bg-white rounded-3xl p-6 border border-zinc-200 shadow-sm space-y-4">
            <h2 class="text-lg font-extrabold text-zinc-900 inline-flex items-center gap-2">
                <i class="fa-solid fa-plus text-rail-500 text-sm"></i>
                <span>Tambah Foto Komponen / Implementasi Baru</span>
            </h2>
            <form action="{{ route('admin.components.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                @csrf
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Nama Komponen</label>
                    <input type="text" name="name" required class="w-full px-3 py-2 rounded-xl border border-zinc-300">
                </div>
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Kode Layer CAD</label>
                    <input type="text" name="code" placeholder="misal: BLDC motor v5" class="w-full px-3 py-2 rounded-xl border border-zinc-300">
                </div>
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Kategori</label>
                    <input type="text" name="category" value="Sistem Pengecatan" required class="w-full px-3 py-2 rounded-xl border border-zinc-300">
                </div>
                <div class="sm:col-span-2">
                    <label class="font-bold text-zinc-600 block mb-1">Deskripsi Teknis</label>
                    <input type="text" name="description" required class="w-full px-3 py-2 rounded-xl border border-zinc-300">
                </div>
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Spesifikasi Singkat</label>
                    <input type="text" name="specification" placeholder="1350mm | 200 Bar" class="w-full px-3 py-2 rounded-xl border border-zinc-300">
                </div>
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Upload Foto Baru</label>
                    <input type="file" name="image" accept="image/*" class="w-full text-xs">
                </div>
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Urutan Tampil</label>
                    <input type="number" name="sort_order" value="10" class="w-full px-3 py-2 rounded-xl border border-zinc-300">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full py-2.5 rounded-xl bg-rail-500 text-white font-bold">Tambah Komponen</button>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($components as $comp)
            <div class="bg-white rounded-2xl p-4 border border-zinc-200 flex gap-4 items-start">
                <img src="{{ asset($comp->image_path) }}" class="w-24 h-24 rounded-xl object-cover flex-shrink-0">
                <form action="{{ route('admin.components.update', $comp->id) }}" method="POST" enctype="multipart/form-data" class="flex-1 space-y-2 text-xs">
                    @csrf
                    @method('PUT')
                    <input type="text" name="name" value="{{ $comp->name }}" class="w-full px-2.5 py-1.5 rounded-lg border border-zinc-300 font-bold">
                    <div class="grid grid-cols-2 gap-2">
                        <input type="text" name="code" value="{{ $comp->code }}" class="px-2.5 py-1.5 rounded-lg border border-zinc-300 font-mono">
                        <input type="text" name="specification" value="{{ $comp->specification }}" class="px-2.5 py-1.5 rounded-lg border border-zinc-300">
                    </div>
                    <textarea name="description" rows="2" class="w-full px-2.5 py-1.5 rounded-lg border border-zinc-300">{{ $comp->description }}</textarea>
                    <div class="flex items-center justify-between pt-1">
                        <input type="file" name="image" class="text-[10px]">
                        <button type="submit" class="px-3 py-1.5 rounded-lg bg-zinc-900 text-white font-bold">Simpan</button>
                    </div>
                </form>
            </div>
            @endforeach
        </div>
    </div>

    <!-- ================================================================= -->
    <!-- TAB 4: KELOLA TIM PENGEMBANG                                      -->
    <!-- ================================================================= -->
    <div x-show="tab === 'tim'" class="space-y-8">
        <div class="bg-white rounded-3xl p-6 border border-zinc-200 shadow-sm space-y-4">
            <h2 class="text-lg font-extrabold text-zinc-900 inline-flex items-center gap-2">
                <i class="fa-solid fa-plus text-rail-500 text-sm"></i>
                <span>Tambah Anggota Tim Pengembang</span>
            </h2>
            <form action="{{ route('admin.team.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                @csrf
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Nama Lengkap & Gelar</label>
                    <input type="text" name="name" required class="w-full px-3 py-2 rounded-xl border border-zinc-300">
                </div>
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Jabatan / Peran</label>
                    <input type="text" name="role" placeholder="Mechanical Engineer" required class="w-full px-3 py-2 rounded-xl border border-zinc-300">
                </div>
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">NIM / NIP / ID</label>
                    <input type="text" name="identity_number" placeholder="HI-102-005" class="w-full px-3 py-2 rounded-xl border border-zinc-300">
                </div>
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Spesialisasi Bagian Alat</label>
                    <input type="text" name="specialization" placeholder="Desain Rangka & Roda" class="w-full px-3 py-2 rounded-xl border border-zinc-300">
                </div>
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Bio Singkat</label>
                    <input type="text" name="bio" class="w-full px-3 py-2 rounded-xl border border-zinc-300">
                </div>
                <div>
                    <label class="font-bold text-zinc-600 block mb-1">Foto Profil (Opsional)</label>
                    <input type="file" name="photo" accept="image/*" class="w-full text-xs">
                </div>
                <div class="sm:col-span-3">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-rail-500 text-white font-bold">Tambah Anggota Tim</button>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($teams as $tm)
            <div class="bg-white rounded-2xl p-4 border border-zinc-200 flex gap-4 items-start justify-between">
                <form action="{{ route('admin.team.update', $tm->id) }}" method="POST" enctype="multipart/form-data" class="flex-1 space-y-2 text-xs">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-2 gap-2">
                        <input type="text" name="name" value="{{ $tm->name }}" class="px-2.5 py-1.5 rounded-lg border border-zinc-300 font-bold">
                        <input type="text" name="role" value="{{ $tm->role }}" class="px-2.5 py-1.5 rounded-lg border border-zinc-300">
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="text" name="identity_number" value="{{ $tm->identity_number }}" class="px-2.5 py-1.5 rounded-lg border border-zinc-300 font-mono">
                        <input type="text" name="specialization" value="{{ $tm->specialization }}" class="px-2.5 py-1.5 rounded-lg border border-zinc-300">
                    </div>
                    <textarea name="bio" rows="2" class="w-full px-2.5 py-1.5 rounded-lg border border-zinc-300">{{ $tm->bio }}</textarea>
                    <div class="flex items-center justify-between">
                        <input type="file" name="photo" class="text-[10px]">
                        <button type="submit" class="px-3 py-1.5 rounded-lg bg-zinc-900 text-white font-bold">Update</button>
                    </div>
                </form>
                <form action="{{ route('admin.team.delete', $tm->id) }}" method="POST" onsubmit="return confirm('Hapus anggota tim ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 text-xs font-bold">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
