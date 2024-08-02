<?php
namespace App\Services\Teacher\Lesson;

use App\Models\Lesson;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LessonService
{
    public function getTeacherLessons()
    {
        try {
            $user = Auth::guard('user-api')->user();
            return $user->lessons;

            throw new Exception('Unauthorized', 403);
        } catch (Exception $e) {
            throw new Exception('Could not retrieve lessons', 500);
        }
    }

    public function getLessonStudents($lessonId)
    {
        try {
            $user = Auth::guard('user-api')->user();
            $lesson = Lesson::findOrFail($lessonId);
            if (!$lesson->users()->where('userId', $user->id)->exists()) {
                throw new Exception('Unauthorized', 403);
            }

            $data =  $lesson->users()->whereHas('roles', function ($query) {
                $query->where('name', 'student');
            })->get();

            return $data;

        } catch (Exception $e) {
            throw new Exception('Could not retrieve students', 500);
        }
    }

    public function getLessonById($lessonId)
    {
        try {
            $user = Auth::guard('user-api')->user();
            $lesson = Lesson::findOrFail($lessonId);

            if (!$lesson->users()->where('userId', $user->id)->exists()) {
                throw new Exception('Unauthorized', 403);
            }

            return $lesson;
        } catch (Exception $e) {
            throw new Exception('Could not retrieve lesson', 500);
        }
    }

}

