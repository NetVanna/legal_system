<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'status',
    ];

    /**
     * Users that belong to this position
     */
    public function users()
    {
        return $this->hasMany(User::class, 'position_id');
    }
}
