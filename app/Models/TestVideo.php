<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestVideo extends Model
{
    protected $fillable = [
        'video_key',
        'title',
        'badge',
        'category',
        'description',
        'video_file',
        'video_url',
        'poster_image',
        'sort_order',
    ];

    /**
     * Dapatkan URL sumber video yang dapat diputar (file lokal atau URL eksternal)
     */
    public function getPlaySourceAttribute(): ?string
    {
        if ($this->video_file) {
            return asset($this->video_file);
        }

        if ($this->video_url) {
            // Ubah link youtube watch?v= biasa menjadi link embed jika diperlukan
            if (str_contains($this->video_url, 'youtube.com/watch?v=')) {
                $videoId = explode('v=', $this->video_url)[1] ?? '';
                $videoId = explode('&', $videoId)[0];
                return 'https://www.youtube.com/embed/' . $videoId . '?autoplay=1';
            }
            if (str_contains($this->video_url, 'youtu.be/')) {
                $videoId = explode('youtu.be/', $this->video_url)[1] ?? '';
                $videoId = explode('?', $videoId)[0];
                return 'https://www.youtube.com/embed/' . $videoId . '?autoplay=1';
            }
            return $this->video_url;
        }

        return null;
    }

    /**
     * Cek apakah video bertipe file lokal (HTML5 video player)
     */
    public function isLocalFile(): bool
    {
        if ($this->video_file) {
            return true;
        }

        if ($this->video_url) {
            $lower = strtolower($this->video_url);
            return str_ends_with($lower, '.mp4') || str_ends_with($lower, '.webm') || str_ends_with($lower, '.ogg');
        }

        return false;
    }
}
