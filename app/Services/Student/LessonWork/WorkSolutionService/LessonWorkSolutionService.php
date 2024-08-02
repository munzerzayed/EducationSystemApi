<?php

namespace App\Services\Student\LessonWork\WorkSolutionService;

use App\Models\LessonWork;
use App\Models\LessonWorkSolution;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;


class LessonWorkSolutionService
{
    public function addSolution($data)
    {
        $user = Auth::guard('user-api')->user();
        if (LessonWorkSolution::where('lessonWorkId', $data['lessonWorkId'])->where('userId', $user->id)->exists()) {
            throw new Exception('You have already submitted a solution for this lesson work.', 403);
        }


        $rules = [
            'lessonWorkId' => 'required|integer|exists:lesson_works,id',
            'lessonWorkSolution' => 'required|string',
            'lessonWorkComment' => 'string',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first(), 401);
        }


        $lessonWork = LessonWork::findOrFail($data['lessonWorkId']);
        $lesson = $lessonWork->lesson;
        if (!$lesson->users()->where('userId', $user->id)->exists()) {
            throw new Exception('Unauthorized: You can only add solutions to your own lessons.', 403);
        }

        try {
            $data['userId'] = $user->id;
            return LessonWorkSolution::create($data);
        } catch (Exception $e) {
            throw new Exception('Could not add solution', 500);
        }
    }

    public function getUserSolution($lessonWorkId)
    {
        try {
            $user = Auth::guard('user-api')->user();

            $solution = LessonWorkSolution::where('lessonWorkId', $lessonWorkId)
                                            ->where('userId', $user->id)
                                            ->first();


            if (!$solution) {
                throw new Exception('Solution not found', 404);
            }

            return $solution;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode() ?: 500);
        }
    }
}
