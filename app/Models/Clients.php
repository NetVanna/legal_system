<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $fillable = [
        'client_code',
        'name',
        'email',
        'phone',
        'address',
        'gender',
        'birth_date',
        'id_card_num',
        'client_type',
        'company_name',
        'instructor_id',
        'notes',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];
    // Default attributes
    protected $attributes = [
        'client_type' => 'individual',
    ];

    /**
     * Relationship: Client belongs to an Instructor (User)
     */
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }
}
