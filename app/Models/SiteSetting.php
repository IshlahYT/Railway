<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'label', 'group', 'type', 'value'];

    public static function getMap(): array
    {
        return self::pluck('value', 'key')->toArray();
    }
}
