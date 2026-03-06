<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChapterDepartments extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'head_user_id',
        'status',
    ];

    /**
     * Relationship: Head of Department (User)
     */
    public function headUser()
    {
        return $this->belongsTo(User::class, 'head_user_id');
    }

    public function subChapters()
    {
        return $this->hasMany(SubChapterDepartments::class, 'chapter_id');
    }

    /**
     * Users that belong to this chapter
     */
    public function users()
    {
        return $this->hasMany(User::class, 'chapter_id');
    }
}
