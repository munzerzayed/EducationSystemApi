<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonWorkSolution extends Model
{
    use HasFactory;
    protected $table = 'lesson_work_solutions';
    protected $fillable = [
        'lessonWorkId',
        'userId',
        'lessonWorkSolution',
        'lessonWorkComment',
    ];

    public function lessonWork()
    {
        return $this->belongsTo(LessonWork::class, 'lessonWorkId');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }
}
