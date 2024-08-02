<?php
namespace App\Services\Student\Lesson;

use App\Models\Lesson;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LessonService
{
    public function getStudentLessons()
    {
        try {
            $user = Auth::guard('user-api')->user();

            return $user->lessons;

            throw new Exception('Unauthorized', 403);
        } catch (Exception $e) {
            throw new Exception('Could not retrieve lessons', 500);
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

    public function getLessonTeachers($lessonId)
    {
        try {
            $user = Auth::guard('user-api')->user();
            $lesson = Lesson::findOrFail($lessonId);

            // Ensure the lesson belongs to the student
            if (!$lesson->users()->where('userId', $user->id)->exists()) {
                throw new Exception('Unauthorized', 403);
            }

            // Return teachers of the lesson
            $teachers = $lesson->users()->whereHas('roles', function ($query) {
                $query->where('name', 'teacher');
            })->get();

            return $teachers;
        } catch (Exception $e) {
            throw new Exception('Could not retrieve teachers', 500);
        }
    }
}

