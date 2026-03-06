<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cases extends Model
{
    protected $fillable = [
        'case_number',
        'case_title',
        'case_type',
        'description',
        'client_id',
        'lawyer_id',
        'instructor_id',
        'chapter_id',
        'subchapter_id',
        'casecode_id',
        'client_relative',
        'opponents',
        'case_data',
        'filed_date',
        'closed_date',
        'day_judge',
        'day_show',
        'payment_type',
        'case_price',
        'discount',
        'payment_amount',
        'payment_status',
        'case_status',
        'outcome',
        'documents'
    ];

    protected $casts = [
        'client_relative' => 'array',
        'opponents' => 'array',
        'case_data' => 'array',
        'documents' => 'array', // Make sure this is here
        'filed_date' => 'date',
        'closed_date' => 'date',
        'day_judge' => 'datetime',
        'day_show' => 'datetime',
        'case_price' => 'decimal:2',
        'payment_amount' => 'decimal:2',
        'documents' => 'array',
    ];

    // Relationships
    public function client()
    {
        return $this->belongsTo(Clients::class);
    }

    public function lawyer()
    {
        return $this->belongsTo(User::class, 'lawyer_id');
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function chapter()
    {
        return $this->belongsTo(ChapterDepartments::class);
    }

    public function subchapter()
    {
        return $this->belongsTo(SubChapterDepartments::class);
    }

    public function casecode()
    {
        return $this->belongsTo(CaseCode::class);
    }
    public function benefitCase()
    {
        return $this->hasOne(BenefitCases::class, 'case_id');
    }
}
