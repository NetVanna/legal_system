<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    // Fillable or guarded properties as needed
    protected $fillable = [
        'employee_id',
        'name',
        'phone',
        'email',
        'password',
        'role',
        'date_birth',
        'gender',
        'position_id',
        'chapter_id',
        'sub_chapter_id',
        'address',
        'photo',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'dob'               => 'date',
    ];


    /**
     * Position relationship (nullable)
     */
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id')->withDefault();
    }

    /**
     * Chapter department relationship (nullable)
     */
    public function chapter()
    {
        return $this->belongsTo(ChapterDepartments::class, 'chapter_id')->withDefault();
    }

    /**
     * Sub-chapter department relationship (nullable)
     */
    public function subChapter()
    {
        return $this->belongsTo(SubChapterDepartments::class, 'sub_chapter_id')->withDefault();
    }
}
