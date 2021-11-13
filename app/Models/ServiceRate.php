<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRate extends Model
{
    use HasFactory;
    protected $table = 'm_service_rates';
    protected $casts = ['service_rate' => 'array'];
}
