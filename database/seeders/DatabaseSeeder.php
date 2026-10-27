<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;
use App\Models\TestResult;
use App\Models\ProductComponent;
use App\Models\TeamMember;
use App\Models\TestVideo;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Site Settings (Landing images & general settings)
        $settings = [
            ['key' => 'admin_password', 'label' => 'Password Admin Cepat', 'group' => 'general', 'type' => 'text', 'value' => 'KunciDipegangHilal'],
            ['key' => 'hero_image', 'label' => 'Foto Implementasi Hero Card', 'group' => 'images', 'type' => 'image', 'value' => 'images/trolley/img1.jpg'],
            ['key' => 'hero_floating_badge', 'label' => 'Badge Foto Hero', 'group' => 'images', 'type' => 'text', 'value' => ''],
            ['key' => 'hero_floating_card_text', 'label' => 'Teks Kartu Mengambang Hero', 'group' => 'images', 'type' => 'textarea', 'value' => 'Inovasi troli elektrik otomatis untuk pengecatan dan perawatan rel kereta api R54-70 dengan presisi tinggi.'],
            ['key' => 'hero_floating_year', 'label' => 'Tahun Kartu Hero', 'group' => 'images', 'type' => 'text', 'value' => ''],
            ['key' => 'hero_floating_footer', 'label' => 'Footer Subtitle Kartu Hero', 'group' => 'images', 'type' => 'text', 'value' => ''],
            ['key' => 'blueprint_image', 'label' => 'Gambar CAD Blueprint Dimensi', 'group' => 'images', 'type' => 'image', 'value' => 'images/trolley/img2.jpg'],
            ['key' => 'blueprint_title', 'label' => 'Judul Kartu Blueprint', 'group' => 'images', 'type' => 'text', 'value' => 'Full Assembly Trolley'],
            ['key' => 'blueprint_badge_1', 'label' => 'Badge 1 Blueprint (CAD)', 'group' => 'images', 'type' => 'text', 'value' => ''],
            ['key' => 'blueprint_badge_2', 'label' => 'Badge 2 Blueprint (Software)', 'group' => 'images', 'type' => 'text', 'value' => ''],
            ['key' => 'blueprint_desc', 'label' => 'Deskripsi Kartu Blueprint', 'group' => 'images', 'type' => 'textarea', 'value' => 'Gambar teknis proyeksi AutoCAD AC1027 dimensi P 1050 x L 1350 x T 1000 mm dengan track gauge rel 930 mm.'],
            ['key' => 'motor_img_1', 'label' => 'Foto Motor BLDC 200mm', 'group' => 'images', 'type' => 'image', 'value' => 'images/trolley/img4_motor_handbrake.jpeg'],
            ['key' => 'motor_badge_1', 'label' => 'Badge Kartu Motor 1', 'group' => 'images', 'type' => 'text', 'value' => 'Planetary Geared'],
            ['key' => 'motor_title_1', 'label' => 'Judul Kartu Motor 1', 'group' => 'images', 'type' => 'text', 'value' => ' 750W 60V Planetary'],
            ['key' => 'motor_desc_1', 'label' => 'Deskripsi Kartu Motor 1', 'group' => 'images', 'type' => 'textarea', 'value' => 'Motor BLDC  750W 60V dengan sistem internal planetary gear, menghasilkan reduksi putaran untuk torsi dorong awal yang besar, efisiensi daya tinggi, dan akselerasi halus di lintasan rel.'],
            ['key' => 'motor_img_2', 'label' => 'Foto Roda Dual Rear-Wheel', 'group' => 'images', 'type' => 'image', 'value' => 'images/trolley/img5_rear_wheels.jpeg'],
            ['key' => 'motor_badge_2', 'label' => 'Badge Kartu Roda 2', 'group' => 'images', 'type' => 'text', 'value' => 'Dual Rear Drive'],
            ['key' => 'motor_title_2', 'label' => 'Judul Kartu Roda 2', 'group' => 'images', 'type' => 'text', 'value' => 'Dual  In-Wheel Drive'],
            ['key' => 'motor_desc_2', 'label' => 'Deskripsi Kartu Roda 2', 'group' => 'images', 'type' => 'textarea', 'value' => 'Konfigurasi ganda motor penggerak roda belakang menghasilkan traksi roda yang seimbang di atas rel, kuat menghela bobot trolley dan tangki cat tanpa gejala slip.'],
            ['key' => 'battery_image', 'label' => 'Foto Visual Baterai LiFePO4', 'group' => 'images', 'type' => 'image', 'value' => 'images/trolley/img1_pump_battery.jpeg'],
            ['key' => 'battery_badge', 'label' => 'Badge Kartu Baterai', 'group' => 'images', 'type' => 'text', 'value' => 'LiFePO4'],
            ['key' => 'battery_card_desc', 'label' => 'Deskripsi Kartu Baterai', 'group' => 'images', 'type' => 'textarea', 'value' => 'Baterai LiFePO4 berkapasitas tinggi menyuplai daya stabil ke inverter dan kontroler.'],
            ['key' => 'battery_stat_1_val', 'label' => 'Baterai Voltase', 'group' => 'images', 'type' => 'text', 'value' => '58'],
            ['key' => 'battery_stat_1_label', 'label' => 'Label Voltase', 'group' => 'images', 'type' => 'text', 'value' => 'Volt'],
            ['key' => 'battery_stat_2_val', 'label' => 'Baterai Kapasitas', 'group' => 'images', 'type' => 'text', 'value' => '15'],
            ['key' => 'battery_stat_2_label', 'label' => 'Label Kapasitas', 'group' => 'images', 'type' => 'text', 'value' => 'Ampere-hour'],
            ['key' => 'battery_stat_3_val', 'label' => 'Baterai Watt-hour', 'group' => 'images', 'type' => 'text', 'value' => '870'],
            ['key' => 'battery_stat_3_label', 'label' => 'Label Watt-hour', 'group' => 'images', 'type' => 'text', 'value' => 'Watt-hour'],
            ['key' => 'review_image', 'label' => 'Foto Detail Mesin (Seksi Evaluasi)', 'group' => 'images', 'type' => 'image', 'value' => 'images/trolley/img6_top_seat.jpeg'],
            ['key' => 'review_image_badge', 'label' => 'Badge Foto Evaluasi', 'group' => 'images', 'type' => 'text', 'value' => 'Implementasi Fisik'],
            ['key' => 'review_image_title', 'label' => 'Judul Foto Evaluasi', 'group' => 'images', 'type' => 'text', 'value' => 'Dudukan Kursi & Kompartemen'],
            ['key' => 'review_image_desc', 'label' => 'Deskripsi Foto Evaluasi', 'group' => 'images', 'type' => 'textarea', 'value' => 'Tampak atas dudukan kursi operator aluminium dan kompartemen baterai ganda.'],
        ];

        foreach ($settings as $s) {
            SiteSetting::updateOrCreate(['key' => $s['key']], $s);
        }

        // 2. Data Pengujian (Grafik & Tabel Hasil Uji)
        $tests = [
            [
                'test_code' => 'UJI-01',
                'parameter' => 'Kecepatan Operasional Pengecatan',
                'category' => 'Performa',
                'result_value' => 10.5,
                'target_value' => 12.0,
                'unit' => 'km/jam',
                'status' => 'Optimal',
                'notes' => 'Pengujian beban penuh dengan 2 operator di atas rel R54-70',
            ],
            [
                'test_code' => 'UJI-02',
                'parameter' => 'Tekanan Pompa Airless Möllar',
                'category' => 'Sprayer',
                'result_value' => 185.0,
                'target_value' => 200.0,
                'unit' => 'Bar',
                'status' => 'Lulus Uji',
                'notes' => 'Distribusi tekanan merata pada 4 nozzle (Tee & Y Pneumatik)',
            ],
            [
                'test_code' => 'UJI-03',
                'parameter' => 'Ketahanan Dual Battery System',
                'category' => 'Baterai',
                'result_value' => 92.0,
                'target_value' => 100.0,
                'unit' => '% Efisiensi',
                'status' => 'Optimal',
                'notes' => 'Suplai daya ke motor BLDC v5 dan Inverter stabil selama 4 jam nonstop',
            ],
            [
                'test_code' => 'UJI-04',
                'parameter' => 'Akurasi Lebar Semprotan Rel',
                'category' => 'Sprayer',
                'result_value' => 94.5,
                'target_value' => 100.0,
                'unit' => '% Presisi',
                'status' => 'Optimal',
                'notes' => '4 sprayer mengarah presisi ke sisi kiri dan kanan badan rel 930mm',
            ],
            [
                'test_code' => 'UJI-05',
                'parameter' => 'Jarak Pengereman Darurat (Tromol)',
                'category' => 'Keamanan',
                'result_value' => 1.8,
                'target_value' => 2.5,
                'unit' => 'Meter',
                'status' => 'Sangat Aman',
                'notes' => 'Pengujian tuas Park Brake Lever & E-Stop 19mm Mushroom Button',
            ],
            [
                'test_code' => 'UJI-06',
                'parameter' => 'Kapasitas Beban Sasis Bordes',
                'category' => 'Struktur',
                'result_value' => 320.0,
                'target_value' => 350.0,
                'unit' => 'Kg',
                'status' => 'Lulus Uji',
                'notes' => 'Rangka dalam v9 & plat bordes aluminium tanpa defleksi berarti',
            ],
        ];

        foreach ($tests as $t) {
            TestResult::updateOrCreate(['test_code' => $t['test_code']], $t);
        }

        // 3. Komponen Produk HI 102
        $components = [
            [
                'name' => 'Full Assembly HI 102 (Tampak Depan)',
                'code' => 'Trolley full ASM v14',
                'category' => 'Sasis & Rangka',
                'description' => 'Implementasi penuh wahana HI 102 dengan rangka pengaman kuning-oranye, dua kursi operator kiri-kanan, konsol kontrol tengah, dan bentangan 4 nozzle sprayer di bagian depan.',
                'specification' => '1350mm (L) x 1000mm (T) | Track 930mm',
                'image_path' => 'images/trolley/1793011189_img2.jpg',
                'sort_order' => 1,
            ],
            [
                'name' => 'Panel Kontrol & Kemudi Operator',
                'code' => '',
                'category' => 'Kontrol & Elektrikal',
                'description' => 'Konsol kendali utama berlogo KAI yang dilengkapi tuas Throttle Gas v4, sakelar Mode v4, tombol Forward-Reverse v3, Pilot Light indikator, dan tombol Emergency Stop Mushroom Red 19mm.',
                'specification' => '',
                'image_path' => 'images/trolley/panel_kontrol_detail.jpg',
                'sort_order' => 2,
            ],
            [
                'name' => 'Sistem 4-Nozzle Airless Sprayer & Manifold',
                'code' => 'sprayer new assembly v2',
                'category' => 'Sistem Pengecatan',
                'description' => 'Konfigurasi pipa distribusi bertekanan tinggi menggunakan pembagi Y-Pneumatik, Filter v2, dan selang fleksibel biru menuju 4 gun sprayer untuk penyemprotan dua jalur rel sekaligus.',
                'specification' => '4 Gun Sprayer | Tee & Y Splitter Manifold',
                'image_path' => 'images/trolley/1793004434_sprayer.jpg',
                'sort_order' => 3,
            ],
            [
                'name' => 'Mesin Pompa Airless Möllar & Kompresor',
                'code' => 'mesin airless v7',
                'category' => 'Sistem Pengecatan',
                'description' => 'Unit pompa airless paint sprayer berdaya tinggi yang terpasang kokoh di tengah dek plat bordes, lengkap dengan selang hisap cat dan pengatur tekanan kerja.',
                'specification' => 'High Pressure Airless | Integrated Suction Hose',
                'image_path' => 'images/trolley/1793006616_mollar.jpg',
                'sort_order' => 4,
            ],
            [
                'name' => 'Manometer & Katup Regulasi Tekanan',
                'code' => 'pressure_gauge v1 & VALVE v1',
                'category' => 'Sistem Pengecatan',
                'description' => 'Detail instalasi pressure gauge, katup solenoid/drain valve, dan konektor selang bertekanan tinggi untuk memastikan aliran cat tetap konstan tanpa penyumbatan.',
                'specification' => 'Stainless Manifold | Precision Pressure Gauge',
                'image_path' => 'images/trolley/1793005225_manometer.jpg',
                'sort_order' => 5,
            ],
            [
                'name' => 'Inline Fluid Filter',
                'code' => 'Filter v2',
                'category' => 'Sistem Pengecatan',
                'description' => 'Filter fluida bertekanan tinggi yang terpasang in-line pada jalur selang cat sebelum nozzle gun sprayer untuk menyaring kotoran dan endapan cat, mencegah nozzle tersumbat, dan menjamin hasil semprotan yang merata.',
                'specification' => 'Stainless Steel Mesh | Max 5000 PSI High Pressure',
                'image_path' => 'images/trolley/inline_fluid_filter.png',
                'sort_order' => 6,
            ],
            [
                'name' => 'Motor Penggerak & Tuas Rem Mekanis',
                'code' => 'BLDC motor v5 & ParkBrakeLever',
                'category' => 'Penggerak & Rem',
                'description' => 'Unit motor elektrik dengan pendingin kipas terintegrasi, ditemani tuas rem tangan mekanis (handbrake lever) di sisi bawah dek untuk keamanan parkir di jalur miring.',
                'specification' => 'BLDC Electric Drive | Mechanical Drum Brake',
                'image_path' => 'images/trolley/1793010944_breake.jpeg',
                'sort_order' => 7,
            ],
            [
                'name' => 'Roda Rel In-Wheel & Bumper Indikator LED',
                'code' => 'roda_v3 & in-wheel_200 v10',
                'category' => 'Penggerak & Roda',
                'description' => 'Tampak belakang sasis memperlihatkan roda rel berflensa ganda (double-flange nylon/steel wheel), stiker reflektif chevron oranye-biru, serta lampu indikator LED merah dan oranye.',
                'specification' => '930mm Rail Gauge | LED Signal Lamp',
                'image_path' => 'images/trolley/1793008170_kaki.jpg',
                'sort_order' => 8,
            ],
            [
                'name' => 'Kursi Operator & Kompartemen Baterai Ganda',
                'code' => 'chair v1 & Baterai v1',
                'category' => 'Sasis & Ergonomi',
                'description' => 'Tampak atas dudukan kursi aluminium berukuran 380x380mm dengan kompartemen boks baterai hitam berpengikat sabuk pengaman di bagian kolong kursi kiri dan kanan.',
                'specification' => 'Dual Battery Box | 380x380mm Operator Seat',
                'image_path' => 'images/trolley/1793011150_kursi.jpeg',
                'sort_order' => 9,
            ],
            [
                'name' => 'Blueprint & Dimensi',
                'code' => 'CAD Drawing',
                'category' => 'Dokumen Teknis',
                'description' => 'Gambar kerja proyeksi ortogonal dan isometrik yang menunjukkan lebar total 1350mm, tinggi pagar 1000mm, tinggi kursi 430mm, lebar konsol 570mm, dan jarak antar roda 930mm.',
                'specification' => 'Scale 1:1 CAD',
                'image_path' => 'images/trolley/drawing.jpg',
                'sort_order' => 10,
            ],
        ];

        foreach ($components as $c) {
            ProductComponent::updateOrCreate(['name' => $c['name']], $c);
        }

        // 4. Tim Pengembang
        $teams = [
            [
                'name' => 'Ir. Ketua Peneliti / Lead Engineer',
                'role' => 'Project Leader & System Architect',
                'specialization' => 'Desain Mekanikal & Integrasi Wahana Rel HI 102',
                'identity_number' => 'HI-102-001',
                'bio' => 'Memimpin perancangan arsitektur Trolley full ASM v14 serta validasi standar keselamatan jalan rel.',
                'photo_path' => 'https://ui-avatars.com/api/?name=Lead+Engineer&background=f97316&color=fff&size=256',
                'linkedin_url' => null,
                'sort_order' => 1,
            ],
            [
                'name' => 'Spesialis Desain CAD & Manufaktur',
                'role' => 'Mechanical & CAD Engineer',
                'specialization' => 'Rangka Sasis v9, Roda In-Wheel 200 & Pengereman Tromol',
                'identity_number' => 'HI-102-002',
                'bio' => 'Bertanggung jawab atas pemodelan 3D presisi ratusan komponen mekanis, analisis beban sasis bordes, dan fabrikasi rangka.',
                'photo_path' => 'https://ui-avatars.com/api/?name=Mechanical+CAD&background=18181b&color=fff&size=256',
                'linkedin_url' => null,
                'sort_order' => 2,
            ],
            [
                'name' => 'Spesialis Sistem Elektrikal & Propulsi',
                'role' => 'Electrical & Control Engineer',
                'specialization' => 'Motor BLDC v5, Sistem Inverter & Panel Kontrol',
                'identity_number' => 'HI-102-003',
                'bio' => 'Merancang manajemen daya Dual Battery System, pengkabelan panel instrumen, serta sistem pengaman E-Stop ganda.',
                'photo_path' => 'https://ui-avatars.com/api/?name=Electrical+Eng&background=f97316&color=fff&size=256',
                'linkedin_url' => null,
                'sort_order' => 3,
            ],
            [
                'name' => 'Spesialis Otomasi Fluida & Pengujian',
                'role' => 'Fluid Dynamics & QA Tester',
                'specialization' => 'Manifold Airless Sprayer 4-Nozzle & Pengujian Lapangan',
                'identity_number' => 'HI-102-004',
                'bio' => 'Mengoptimalkan distribusi tekanan cat pada 4 titik nozzle serta mengoordinasikan pengumpulan data hasil pengujian.',
                'photo_path' => 'https://ui-avatars.com/api/?name=Fluid+Tester&background=18181b&color=fff&size=256',
                'linkedin_url' => null,
                'sort_order' => 4,
            ],
        ];

        foreach ($teams as $tm) {
            TeamMember::updateOrCreate(['identity_number' => $tm['identity_number']], $tm);
        }

        // 5. Video Pengujian
        $videos = [
            [
                'video_key' => 'lurus',
                'title' => 'Pengujian Jalan Lurus 3 Mode',
                'badge' => 'UJI-01 • 3 Mode Kecepatan',
                'category' => 'Pengujian Trolley',
                'description' => 'Trolley diuji pada rel lurus dengan mode kecepatan 1 (5 km/jam), mode 2 (10 km/jam), dan mode 3 (15 km/jam). Evaluasi stabilitas, getaran sasis, dan konsistensi kecepatan.',
                'video_file' => 'videos/PENGUJIAN TROLLEY KEILILING KECEPATAN RENDAH.mp4',
                'video_url' => 'https://youtu.be/VJwOfbU6qIw',
                'poster_image' => 'images/trolley/poster_1793095791_Screenshot28.png',
                'sort_order' => 1,
            ],
            [
                'video_key' => 'wessel',
                'title' => 'Pengujian Lewat Wessel',
                'badge' => 'UJI-02 • Turnout / Switch',
                'category' => 'Pengujian Trolley',
                'description' => 'Kemampuan melewati wessel (switch/turnout) rel tanpa risiko anjlok (derailment).',
                'video_file' => null,
                'video_url' => 'https://youtu.be/WiGAJuPtHak',
                'poster_image' => 'images/trolley/poster_1793091302_Screenshot23.png',
                'sort_order' => 2,
            ],
            [
                'video_key' => 'relpaksa',
                'title' => 'Pengujian Lewat Rel Paksa',
                'badge' => 'UJI-03 • Rel Paksa',
                'category' => 'Pengujian Trolley',
                'description' => 'Ketahanan impak roda terhadap sambungan rel paksa dan rel kompensasi.',
                'video_file' => null,
                'video_url' => 'https://youtu.be/TcaxBr-cBNQ',
                'poster_image' => 'images/trolley/poster_1793095533_Screenshot27.png',
                'sort_order' => 3,
            ],
            [
                'video_key' => 'mundur',
                'title' => 'Pengujian Jalan Mundur',
                'badge' => 'UJI-04 • Reverse Drive',
                'category' => 'Pengujian Trolley',
                'description' => 'Pengujian respon motor BLDC dan kontroler saat beroperasi mundur (reverse) dengan beban kerja penuh.',
                'video_file' => null,
                'video_url' => 'https://youtu.be/LDsKvte6sSQ',
                'poster_image' => 'images/trolley/poster_1793091995_Screenshot26.png',
                'sort_order' => 4,
            ],
            [
                'video_key' => 'ngecat',
                'title' => 'Pengujian Pengecatan Rel Kereta Api',
                'badge' => 'LIVE TEST • 10L → 630m',
                'category' => 'Pengujian Pengecatan',
                'description' => 'Demonstrasi sprayer airless 4-nozzle pada rel R54-70 dengan keseragaman semprot 86% dan efisiensi 63 meter per liter.',
                'video_file' => 'videos/PENGUJIAN SPRAYER.mp4',
                'video_url' => 'https://youtu.be/4dZeV1yYo_k',
                'poster_image' => 'images/trolley/poster_1793091814_Screenshot25.png',
                'sort_order' => 5,
            ],
        ];

        foreach ($videos as $v) {
            TestVideo::updateOrCreate(['video_key' => $v['video_key']], $v);
        }
    }
}
