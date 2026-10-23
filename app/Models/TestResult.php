<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    protected $fillable = [
        'test_code', 'parameter', 'category',
        'result_value', 'target_value', 'unit',
        'status', 'notes'
    ];
}
