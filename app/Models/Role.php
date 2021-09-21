<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'm_roles';
    protected $hidden = [
        'superuser',
        'created_at',
        'updated_at',
        'id'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
