<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonWork extends Model
{
    use HasFactory;
    protected $table = 'lesson_works';
    protected $fillable = [
        'id',
        'lessonId',
        'userId',
        'lessonTitle',
        'lessonContent',
        'startDate',
        'endDate',
    ];

    public function lesson(){
        return $this->belongsTo(Lesson::class, 'lessonId');
    }
}
