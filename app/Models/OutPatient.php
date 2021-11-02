<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutPatient extends Model
{
    use HasFactory;
    protected $table = 'out_patients';
    protected $fillable = ['entry_time','exit_time','final_condition','medical_activity_id','polyclinic_id'];
}
