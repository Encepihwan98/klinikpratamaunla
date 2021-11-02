<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;
    protected $table = 'visits';
    protected $fillable = ['visit_in','visit_out','visit_number','patient_id','case_id','disease_id','reference_type_id',
        'origin_reference','reference_number','	reference_date', '	pj_name','pj_phone_number','payment_method_id ',
        'sjp_number','sjp_date'
    ];
}
