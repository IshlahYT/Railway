<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('test_videos', function (Blueprint $table) {
            $table->id();
            $table->string('video_key')->unique(); // lurus, belok, wessel, relpaksa, mundur, ngecat
            $table->string('title');
            $table->string('badge')->nullable(); // UJI-01 • 3 Mode Kecepatan, etc.
            $table->string('category')->default('Pengujian Trolley'); // Pengujian Trolley, Pengujian Pengecatan
            $table->text('description')->nullable();
            $table->string('video_file')->nullable(); // Path ke file lokal misal: videos/PENGUJIAN SPRAYER.mp4
            $table->string('video_url')->nullable(); // URL YouTube / link video eksternal
            $table->string('poster_image')->nullable(); // Thumbnail gambar video
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_videos');
    }
};
