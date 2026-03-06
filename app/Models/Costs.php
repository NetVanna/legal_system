<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Costs extends Model
{
    protected $fillable = [
        'purchase_date',
        'purchased_by',
        'paid_by',
        'item_name',
        'item_description',
        'amount',
    ];

    protected $casts = [
        'purchase_date' => 'date',
    ];
}
