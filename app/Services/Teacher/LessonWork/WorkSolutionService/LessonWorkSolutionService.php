<?php

namespace App\Services\Teacher\LessonWork\WorkSolutionService;

use App\Models\LessonWork;
use App\Models\LessonWorkSolution;
use App\Traits\GeneralTrait;
use Exception;
use Illuminate\Support\Facades\Auth;

class LessonWorkSolutionService{
    use GeneralTrait;

    public function getAllSolutionsByLessonWork($lessonWorkId)
    {
        try {
            $user = Auth::guard('user-api')->user();

            $lessonWork = LessonWork::find($lessonWorkId);
            $lesson = $lessonWork->lesson;
            if (!$lesson->users()->where('userId', $user->id)->exists()) {
                throw new Exception('Unauthorized: You can only view solutions for your own lessons.', 403);
            }

            return LessonWorkSolution::where('lessonWorkId', $lessonWorkId)->with('user')->get();
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode() ?: 500);
        }
    }
}
