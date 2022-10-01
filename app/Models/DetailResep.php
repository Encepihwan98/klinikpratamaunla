<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailResep extends Model
{
    use HasFactory;
    protected $table = 'detailreseps';
    protected $fillable = ['resep_id', 'obat_id','jumlah','keterangan'];
}
