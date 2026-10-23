<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductComponent extends Model
{
    protected $fillable = [
        'name', 'code', 'category',
        'description', 'specification', 'image_path', 'sort_order'
    ];
}
