<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incinerator extends Model
{
    use HasFactory;
    protected $fillable = ['name','description','unit'];
    protected $table = 'm_incinerators';
}
