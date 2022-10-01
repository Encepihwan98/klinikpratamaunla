<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reseps extends Model
{
    use HasFactory;

    public function obat() {
    	return $this->belongsTo('App\Models\Obat');
    }
}
