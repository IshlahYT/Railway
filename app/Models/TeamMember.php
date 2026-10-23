<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $fillable = [
        'name', 'role', 'specialization',
        'identity_number', 'bio', 'photo_path',
        'linkedin_url', 'sort_order'
    ];
}
