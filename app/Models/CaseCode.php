<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseCode extends Model
{
    protected $fillable = [
        'code',
        'description',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
