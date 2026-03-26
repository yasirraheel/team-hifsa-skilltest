<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonCompletion extends Model
{
    protected $table = 'lesson_completions';

    protected $fillable = [
        'user_id',
        'course_id',
        'lesson_id',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];
}

