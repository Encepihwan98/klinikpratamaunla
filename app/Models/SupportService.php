<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportService extends Model
{
    use HasFactory;
    protected $fillable = ['service_uuid','treatment_id','treatment_type','polyclinic_id ','treatment_time','note'];
    protected $table = 'support_services';
}
