<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Site Settings (Semua teks, angka statistik, judul, deskripsi bisa diedit admin)
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('label');
            $table->string('group')->default('general'); // hero, stats, problem_solution, about, footer
            $table->string('type')->default('text'); // text, textarea, image, number
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // 2. Test Results / Data Pengujian (Untuk grafik bar & tabel pengujian dinamis)
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();
            $table->string('test_code');
            $table->string('parameter'); // misal: Kecepatan Pengecatan, Konsumsi Daya, Tekanan Airless
            $table->string('category')->default('Peforma'); // Peforma, Efisiensi, Baterai, Sprayer
            $table->decimal('result_value', 10, 2);
            $table->decimal('target_value', 10, 2)->nullable();
            $table->string('unit'); // km/jam, Bar, Watt, %, Meter
            $table->string('status')->default('Optimal'); // Optimal, Lulus Uji, Standar
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 3. Komponen & Produk Gallery (Menggunakan 8 foto implementasi + Blueprint)
        Schema::create('product_components', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable(); // Nama layer CAD: mesin airless v7, BLDC motor v5, dll
            $table->string('category');
            $table->text('description');
            $table->string('specification')->nullable();
            $table->string('image_path');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 4. Tim Pengembang (Halaman Tim & Institusi)
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role');
            $table->string('specialization')->nullable();
            $table->string('identity_number')->nullable(); // NIP / NIM / ID
            $table->text('bio')->nullable();
            $table->string('photo_path')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_members');
        Schema::dropIfExists('product_components');
        Schema::dropIfExists('test_results');
        Schema::dropIfExists('site_settings');
    }
};
