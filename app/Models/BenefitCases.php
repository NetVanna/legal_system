<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BenefitCases extends Model
{
    protected $fillable = [
        'case_id',
        'client_name',
        'type_case',
        'date',
        'chapter',
        'sub_chapter',
        'service_fee',
        'employee',
        'employee_fee',
        'chapter_fee',
        'admin_fee',
        'it_fee',
        'lawyer',
        'lawyer_fee',
        'net_fee',
    ];
    protected $casts = [
        'date' => 'date',
    ];


    public function case()
    {
        return $this->belongsTo(Cases::class, 'case_id');
    }
}
