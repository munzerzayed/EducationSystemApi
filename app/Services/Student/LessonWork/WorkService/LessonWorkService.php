<?php

namespace App\Services\Student\LessonWork\WorkService;

use App\Models\LessonWork;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;
use Exception;

class LessonWorkService
{
    public function getLessonWorks()
    {
        try {
            $user = Auth::guard('user-api')->user();

            return LessonWork::whereHas('lesson.users', function ($query) use ($user) {
                $query->where('userId', $user->id);
            })->get();

            throw new Exception('Unauthorized', 403);
        } catch (Exception $e) {
            throw new Exception('Could not retrieve lesons', 500);
        }
    }

    public function getLessonWorksByLesson()
    {
        try {
            $user = Auth::guard('user-api')->user();

            return LessonWork::where('lessonId', $user->id)->get();
        } catch (Exception $e) {
            throw new Exception('Could not retrieve lesson works', 500);
        }
    }


    public function getLessonWorkById($lessonWorkId)
    {
        try {
            $user = Auth::guard('user-api')->user();
            $lessonWork = LessonWork::findOrFail($lessonWorkId);

            $lesson = $lessonWork->lesson;
            if (!$lesson->users()->where('userId', $user->id)->exists()) {
                throw new Exception('Unauthorized: You can only view works for your own lessons.', 403);
            }
            return $lessonWork;
        } catch (Exception $e) {
            throw new Exception('Lesson work not found', 404);
        }
    }
}
