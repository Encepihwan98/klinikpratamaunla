<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarCaraPembayaran extends Model
{
    use HasFactory;
    protected $fillable = ['description'];
    protected $table ='m_payment_methods';
}
