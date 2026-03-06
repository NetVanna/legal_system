<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubChapterDepartments extends Model
{
    protected $fillable = [
        'chapter_id',
        'name',
        'code',
        'description',
        'head_user_id',
        'status',
    ];

    public function chapter()
    {
        return $this->belongsTo(ChapterDepartments::class, 'chapter_id');
    }

    /**
     * The head user (nullable).
     */
    public function headUser()
    {
        return $this->belongsTo(User::class, 'head_user_id');
    }
    public function users()
    {
        return $this->hasMany(User::class, 'sub_chapter_id');
    }
}
