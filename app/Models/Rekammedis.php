<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekammedis extends Model
{
    use HasFactory;
    protected $fillable = ['pasien_id','registrasi_id','dokter_id','bb'];
}
