<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $table = 'lessons';
    protected $fillable = [
        'lessonName',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'lesson_users', 'lessonId', 'userId');
    }
}
