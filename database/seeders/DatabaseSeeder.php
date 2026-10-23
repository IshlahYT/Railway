<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;
use App\Models\TestResult;
use App\Models\ProductComponent;
use App\Models\TeamMember;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Navbar & Brand
            ['key' => 'brand_name', 'label' => 'Nama Brand / Produk', 'group' => 'general', 'type' => 'text', 'value' => 'HI 102'],
            ['key' => 'brand_subtitle', 'label' => 'Subjudul Brand', 'group' => 'general', 'type' => 'text', 'value' => 'Electric Trolley Machine for Rail Painting'],
            ['key' => 'location_tag', 'label' => 'Tag Lokasi Navbar', 'group' => 'general', 'type' => 'text', 'value' => 'Indonesia • R54-70 Track Standard'],
            ['key' => 'admin_password', 'label' => 'Password Admin Cepat', 'group' => 'general', 'type' => 'text', 'value' => 'admin123'],

            // Hero Section (Bento Top)
            ['key' => 'hero_badge_1', 'label' => 'Badge Hero 1', 'group' => 'hero', 'type' => 'text', 'value' => 'Rail Tech'],
            ['key' => 'hero_badge_2', 'label' => 'Badge Hero 2', 'group' => 'hero', 'type' => 'text', 'value' => '4-Nozzle Airless'],
            ['key' => 'hero_badge_3', 'label' => 'Badge Hero 3', 'group' => 'hero', 'type' => 'text', 'value' => 'BLDC In-Wheel 200'],
            ['key' => 'hero_stat_big', 'label' => 'Angka Utama Hero (Kiri)', 'group' => 'hero', 'type' => 'text', 'value' => '1350mm'],
            ['key' => 'hero_stat_label', 'label' => 'Label Angka Hero', 'group' => 'hero', 'type' => 'text', 'value' => 'Dimensi Lebar Presisi (Track Gauge 930mm)'],
            ['key' => 'hero_title', 'label' => 'Judul Utama Hero (Kanan Bawah)', 'group' => 'hero', 'type' => 'text', 'value' => 'PARTNER IN RAILWAY INNOVATION'],
            ['key' => 'hero_floating_card_text', 'label' => 'Teks Kartu Mengambang Hero', 'group' => 'hero', 'type' => 'textarea', 'value' => 'Inovasi wahana elektrik otomatis untuk pengecatan dan perawatan rel kereta api R54-70 dengan presisi tinggi.'],
            ['key' => 'hero_floating_year', 'label' => 'Tahun Kartu Hero', 'group' => 'hero', 'type' => 'text', 'value' => '©2026 HI 102'],

            // Section 01: Problem, Solution, Technology
            ['key' => 'sec1_stat_number', 'label' => 'Angka Statistik Seksi 01', 'group' => 'section_1', 'type' => 'text', 'value' => '4x'],
            ['key' => 'sec1_stat_label', 'label' => 'Label Statistik Seksi 01', 'group' => 'section_1', 'type' => 'text', 'value' => 'Nozzle Airless Sprayer Terintegrasi'],
            ['key' => 'sec1_heading', 'label' => 'Judul Utama Seksi 01', 'group' => 'section_1', 'type' => 'textarea', 'value' => 'Dari penggerak BLDC elektrik hingga sistem penyemprotan airless bertekanan tinggi, HI 102 mendukung pemeliharaan rel di setiap meter perjalanan.'],
            ['key' => 'problem_title', 'label' => 'Judul Problem', 'group' => 'section_1', 'type' => 'text', 'value' => 'Problem Pemeliharaan Manual'],
            ['key' => 'problem_desc', 'label' => 'Deskripsi Problem', 'group' => 'section_1', 'type' => 'textarea', 'value' => 'Pengecatan rel kereta api secara manual membutuhkan waktu lama, menguras tenaga operator, dan menghasilkan ketebalan lapisan anti-karat yang kurang merata.'],
            ['key' => 'solution_title', 'label' => 'Judul Solution', 'group' => 'section_1', 'type' => 'text', 'value' => 'Solusi Otomasi HI 102'],
            ['key' => 'solution_desc', 'label' => 'Deskripsi Solution', 'group' => 'section_1', 'type' => 'textarea', 'value' => 'Wahana troli elektrik dengan dua kursi operator ergonomis, sistem pengereman tromol mekanis, dan 4 titik penyemprotan simultan kiri-kanan rel.'],
            ['key' => 'tech_title', 'label' => 'Judul Technology', 'group' => 'section_1', 'type' => 'text', 'value' => 'Teknologi CAD Trolley ASM v14'],
            ['key' => 'tech_desc', 'label' => 'Deskripsi Technology', 'group' => 'section_1', 'type' => 'textarea', 'value' => 'Dirancang menggunakan pemodelan 3D presisi (Trolley full ASM v14) dengan sasis plat bordes aluminium anti-selip, dual battery system, dan kontrol inverter terpusat.'],

            // Section 02: Data Pengujian & Bento Metric
            ['key' => 'sec2_quote', 'label' => 'Deskripsi Bento Pengujian', 'group' => 'section_2', 'type' => 'textarea', 'value' => 'Baik untuk pemeliharaan jalur stasiun maupun lintasan jarak jauh, HI 102 dirancang untuk bekerja lebih cerdas, lebih cepat, dan bebas emisi.'],
            ['key' => 'sec2_efficiency_pct', 'label' => 'Persentase Efisiensi (Kiri Bawah)', 'group' => 'section_2', 'type' => 'text', 'value' => '86%'],
            ['key' => 'sec2_efficiency_label', 'label' => 'Label Efisiensi Kiri', 'group' => 'section_2', 'type' => 'text', 'value' => 'Keseragaman Distribusi Cat Rel'],
            ['key' => 'sec2_boost_pct', 'label' => 'Angka Peningkatan Produktivitas (Kartu Oranye)', 'group' => 'section_2', 'type' => 'text', 'value' => '300%'],
            ['key' => 'sec2_boost_label', 'label' => 'Label Kartu Oranye', 'group' => 'section_2', 'type' => 'text', 'value' => 'Peningkatan Kecepatan Kerja vs Manual'],

            // Marquee Banner
            ['key' => 'marquee_text', 'label' => 'Teks Berjalan (Marquee)', 'group' => 'general', 'type' => 'text', 'value' => 'HI 102 — Partner In Railway Maintenance Innovation ❖ Electric Trolley Machine for Rail Painting ❖ '],

            // Review / Pengujian Lapangan Quote
            ['key' => 'review_rating', 'label' => 'Rating Pengujian', 'group' => 'review', 'type' => 'text', 'value' => '4.9'],
            ['key' => 'review_quote', 'label' => 'Kutipan Hasil Uji Lapangan', 'group' => 'review', 'type' => 'textarea', 'value' => '"Sejak mengimplementasikan prototipe HI 102 pada pengujian jalur rel R54-70, proses pelapisan cat berjalan jauh lebih stabil, presisi semprotan 4 nozzle sangat merata, dan efisiensi waktu meningkat drastis!"'],
            ['key' => 'review_author', 'label' => 'Nama Penguji / Evaluator', 'group' => 'review', 'type' => 'text', 'value' => 'Tim Penguji Lapangan HI 102'],
            ['key' => 'review_role', 'label' => 'Jabatan Penguji', 'group' => 'review', 'type' => 'text', 'value' => 'Divisi Rekayasa & Perawatan Jalan Rel'],
        ];

        foreach ($settings as $s) {
            SiteSetting::updateOrCreate(['key' => $s['key']], $s);
        }

        // Seed Data Pengujian (Dapat diedit/ditambah Admin untuk grafik & tabel)
        $tests = [
            ['test_code' => 'UJI-01', 'parameter' => 'Kecepatan Operasional Pengecatan', 'category' => 'Performa', 'result_value' => 10.5, 'target_value' => 12.0, 'unit' => 'km/jam', 'status' => 'Optimal', 'notes' => 'Pengujian beban penuh dengan 2 operator di atas rel R54-70'],
            ['test_code' => 'UJI-02', 'parameter' => 'Tekanan Pompa Airless Möllar', 'category' => 'Sprayer', 'result_value' => 185.0, 'target_value' => 200.0, 'unit' => 'Bar', 'status' => 'Lulus Uji', 'notes' => 'Distribusi tekanan merata pada 4 nozzle (Tee & Y Pneumatik)'],
            ['test_code' => 'UJI-03', 'parameter' => 'Ketahanan Dual Battery System', 'category' => 'Baterai', 'result_value' => 92.0, 'target_value' => 100.0, 'unit' => '% Efisiensi', 'status' => 'Optimal', 'notes' => 'Suplai daya ke motor BLDC v5 dan Inverter stabil selama 4 jam nonstop'],
            ['test_code' => 'UJI-04', 'parameter' => 'Akurasi Lebar Semprotan Rel', 'category' => 'Sprayer', 'result_value' => 94.5, 'target_value' => 100.0, 'unit' => '% Presisi', 'status' => 'Optimal', 'notes' => '4 sprayer mengarah presisi ke sisi kiri dan kanan badan rel 930mm'],
            ['test_code' => 'UJI-05', 'parameter' => 'Jarak Pengereman Darurat (Tromol)', 'category' => 'Keamanan', 'result_value' => 1.8, 'target_value' => 2.5, 'unit' => 'Meter', 'status' => 'Sangat Aman', 'notes' => 'Pengujian tuas Park Brake Lever & E-Stop 19mm Mushroom Button'],
            ['test_code' => 'UJI-06', 'parameter' => 'Kapasitas Beban Sasis Bordes', 'category' => 'Struktur', 'result_value' => 320.0, 'target_value' => 350.0, 'unit' => 'Kg', 'status' => 'Lulus Uji', 'notes' => 'Rangka dalam v9 & plat bordes aluminium tanpa defleksi berarti'],
        ];

        foreach ($tests as $t) {
            TestResult::updateOrCreate(['test_code' => $t['test_code']], $t);
        }

        // Seed 8 Gambar Implementasi + 1 Blueprint Teknis
        $components = [
            [
                'name' => 'Full Assembly HI 102 (Tampak Depan)',
                'code' => 'Trolley full ASM v14',
                'category' => 'Sasis & Rangka',
                'description' => 'Implementasi penuh wahana HI 102 dengan rangka pengaman kuning-oranye, dua kursi operator kiri-kanan, konsol kontrol tengah, dan bentangan 4 nozzle sprayer di bagian depan.',
                'specification' => '1350mm (L) x 1000mm (T) | Track 930mm',
                'image_path' => 'images/trolley/img8_full_front.jpeg',
                'sort_order' => 1
            ],
            [
                'name' => 'Panel Kontrol & Kemudi Operator',
                'code' => 'Panel assembly v1#87',
                'category' => 'Kontrol & Elektrikal',
                'description' => 'Konsol kendali utama berlogo KAI yang dilengkapi tuas Throttle Gas v4, sakelar Mode v4, tombol Forward-Reverse v3, Pilot Light indikator, dan tombol Emergency Stop Mushroom Red 19mm.',
                'specification' => '570mm Console Width | Dual E-Stop System',
                'image_path' => 'images/trolley/img7_control_panel.jpeg',
                'sort_order' => 2
            ],
            [
                'name' => 'Sistem 4-Nozzle Airless Sprayer & Manifold',
                'code' => 'sprayer new assembly v2',
                'category' => 'Sistem Pengecatan',
                'description' => 'Konfigurasi pipa distribusi bertekanan tinggi menggunakan pembagi Y-Pneumatik, Filter v2, dan selang fleksibel biru menuju 4 gun sprayer untuk penyemprotan dua jalur rel sekaligus.',
                'specification' => '4 Gun Sprayer | Tee & Y Splitter Manifold',
                'image_path' => 'images/trolley/img3_sprayer_boom.jpeg',
                'sort_order' => 3
            ],
            [
                'name' => 'Mesin Pompa Airless Möllar & Kompresor',
                'code' => 'mesin airless v7',
                'category' => 'Sistem Pengecatan',
                'description' => 'Unit pompa airless paint sprayer berdaya tinggi yang terpasang kokoh di tengah dek plat bordes, lengkap dengan selang hisap cat dan pengatur tekanan kerja.',
                'specification' => 'High Pressure Airless | Integrated Suction Hose',
                'image_path' => 'images/trolley/img1_pump_battery.jpeg',
                'sort_order' => 4
            ],
            [
                'name' => 'Manometer & Katup Regulasi Tekanan',
                'code' => 'pressure_gauge v1 & VALVE v1',
                'category' => 'Sistem Pengecatan',
                'description' => 'Detail instalasi pressure gauge, katup solenoid/drain valve, dan konektor selang bertekanan tinggi untuk memastikan aliran cat tetap konstan tanpa penyumbatan.',
                'specification' => 'Stainless Manifold | Precision Pressure Gauge',
                'image_path' => 'images/trolley/img2_pump_gauge.jpeg',
                'sort_order' => 5
            ],
            [
                'name' => 'Motor Penggerak & Tuas Rem Mekanis',
                'code' => 'BLDC motor v5 & ParkBrakeLever',
                'category' => 'Penggerak & Rem',
                'description' => 'Unit motor elektrik dengan pendingin kipas terintegrasi, ditemani tuas rem tangan mekanis (handbrake lever) di sisi bawah dek untuk keamanan parkir di jalur miring.',
                'specification' => 'BLDC Electric Drive | Mechanical Drum Brake',
                'image_path' => 'images/trolley/img4_motor_handbrake.jpeg',
                'sort_order' => 6
            ],
            [
                'name' => 'Roda Rel In-Wheel & Bumper Indikator LED',
                'code' => 'roda_v3 & in-wheel_200 v10',
                'category' => 'Penggerak & Roda',
                'description' => 'Tampak belakang sasis memperlihatkan roda rel berflensa ganda (double-flange nylon/steel wheel), stiker reflektif chevron oranye-biru, serta lampu indikator LED merah dan oranye.',
                'specification' => '930mm Rail Gauge | LED Signal Lamp',
                'image_path' => 'images/trolley/img5_rear_wheels.jpeg',
                'sort_order' => 7
            ],
            [
                'name' => 'Kursi Operator & Kompartemen Baterai Ganda',
                'code' => 'chair v1 & Baterai v1',
                'category' => 'Sasis & Ergonomi',
                'description' => 'Tampak atas dudukan kursi aluminium berukuran 380x380mm dengan kompartemen boks baterai hitam berpengikat sabuk pengaman di bagian kolong kursi kiri dan kanan.',
                'specification' => 'Dual Battery Box | 380x380mm Operator Seat',
                'image_path' => 'images/trolley/img6_top_seat.jpeg',
                'sort_order' => 8
            ],
            [
                'name' => 'Blueprint & Dimensi Teknis HI 102',
                'code' => 'CAD Drawing v14',
                'category' => 'Dokumen Teknis',
                'description' => 'Gambar kerja proyeksi ortogonal dan isometrik yang menunjukkan lebar total 1350mm, tinggi pagar 1000mm, tinggi kursi 430mm, lebar konsol 570mm, dan jarak antar roda 930mm.',
                'specification' => 'Scale 1:1 CAD | ISO Standard Projection',
                'image_path' => 'images/trolley/blueprint_dimensi.png',
                'sort_order' => 9
            ],
        ];

        foreach ($components as $c) {
            ProductComponent::updateOrCreate(['name' => $c['name']], $c);
        }

        // Seed Tim Pengembang
        $teams = [
            [
                'name' => 'Ir. Ketua Peneliti / Lead Engineer',
                'role' => 'Project Leader & System Architect',
                'specialization' => 'Desain Mekanikal & Integrasi Wahana Rel HI 102',
                'identity_number' => 'HI-102-001',
                'bio' => 'Memimpin perancangan arsitektur Trolley full ASM v14 serta validasi standar keselamatan jalan rel.',
                'photo_path' => 'https://ui-avatars.com/api/?name=Lead+Engineer&background=f97316&color=fff&size=256',
                'sort_order' => 1
            ],
            [
                'name' => 'Spesialis Desain CAD & Manufaktur',
                'role' => 'Mechanical & CAD Engineer',
                'specialization' => 'Rangka Sasis v9, Roda In-Wheel 200 & Pengereman Tromol',
                'identity_number' => 'HI-102-002',
                'bio' => 'Bertanggung jawab atas pemodelan 3D presisi ratusan komponen mekanis, analisis beban sasis bordes, dan fabrikasi rangka.',
                'photo_path' => 'https://ui-avatars.com/api/?name=Mechanical+CAD&background=18181b&color=fff&size=256',
                'sort_order' => 2
            ],
            [
                'name' => 'Spesialis Sistem Elektrikal & Propulsi',
                'role' => 'Electrical & Control Engineer',
                'specialization' => 'Motor BLDC v5, Sistem Inverter & Panel Kontrol',
                'identity_number' => 'HI-102-003',
                'bio' => 'Merancang manajemen daya Dual Battery System, pengkabelan panel instrumen, serta sistem pengaman E-Stop ganda.',
                'photo_path' => 'https://ui-avatars.com/api/?name=Electrical+Eng&background=f97316&color=fff&size=256',
                'sort_order' => 3
            ],
            [
                'name' => 'Spesialis Otomasi Fluida & Pengujian',
                'role' => 'Fluid Dynamics & QA Tester',
                'specialization' => 'Manifold Airless Sprayer 4-Nozzle & Pengujian Lapangan',
                'identity_number' => 'HI-102-004',
                'bio' => 'Mengoptimalkan distribusi tekanan cat pada 4 titik nozzle serta mengoordinasikan pengumpulan data hasil pengujian.',
                'photo_path' => 'https://ui-avatars.com/api/?name=Fluid+Tester&background=18181b&color=fff&size=256',
                'sort_order' => 4
            ],
        ];

        foreach ($teams as $tm) {
            TeamMember::updateOrCreate(['identity_number' => $tm['identity_number']], $tm);
        }
    }
}
