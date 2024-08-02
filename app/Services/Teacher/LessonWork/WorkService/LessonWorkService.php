<?php

namespace App\Services\Teacher\LessonWork\WorkService;


use App\Models\LessonWork;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;

class LessonWorkService
{
    public function getLessonWorksByLesson($lessonId)
    {
        try {
            $user = Auth::guard('user-api')->user();
            $lesson = Lesson::findOrFail($lessonId);
            if (!$lesson->users()->where('userId', $user->id)->exists()) {
                throw new Exception('Unauthorized: You can only view works in your own lessons.', 403);
            }

            return LessonWork::where('lessonId', $lessonId)->get();
        } catch (Exception $e) {
            throw new Exception('Could not retrieve lesson works', 500);
        }
    }


    public function getLessonWorks()
    {
        try {
            $user = Auth::guard('user-api')->user();
            return LessonWork::where('userId', $user->id)->get();
        } catch (Exception $e) {
            throw new Exception('Could not retrieve lesson works', 500);
        }
    }

    public function createLessonWork($data)
    {
        $rules = [
            'lessonId' => 'required|integer|exists:lessons,id',
            'lessonTitle' => 'required|string|max:255',
            'lessonContent' => 'required|string',
            'startDate' => 'required|date_format:Y-m-d',
            'endDate' => 'required|date_format:Y-m-d',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first(), 401);
        }

        $user = Auth::guard('user-api')->user();

        $lesson = Lesson::findOrFail($data['lessonId']);
        if (!$lesson->users()->where('userId', $user->id)->exists()) {
            throw new Exception('Unauthorized: You can only add works to your own lessons.', 403);
        }
        try {
            $data['userId'] = $user->id;

            return LessonWork::create($data);

        } catch (Exception $e) {
            throw new Exception('Could not create lesson work', 500);
        }
    }

    public function getLessonWorkById($id)
    {
        try {
            $user = Auth::guard('user-api')->user();
            $lessonWork = LessonWork::findOrFail($id);

            $lesson = Lesson::findOrFail($lessonWork->lessonId);
            if (!$lesson->users()->where('userId', $user->id)->exists()) {
                throw new Exception('Unauthorized: You can only view works in your own lessons.', 403);
            }

            return $lessonWork;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function deleteLessonWork($id)
    {
        try {
            $user = Auth::guard('user-api')->user();
            $lessonWork = LessonWork::find($id);
            if(!$lessonWork){
                throw new Exception('Lesson Work Not Found', 404);
            }
            $lesson = Lesson::findOrFail($lessonWork->lessonId);
            if (!$lesson->users()->where('userId', $user->id)->exists()) {
                throw new Exception('Unauthorized: You can only delete works in your own lessons.', 403);
            }

            $lessonWork->delete();
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function updateLessonWork($lessonId, $lessonWorkId, $data)
    {
        $rules = [
            'lessonTitle' => 'required|string|max:255',
            'lessonContent' => 'required|string',
            'startDate' => 'required|date_format:Y-m-d',
            'endDate' => 'required|date_format:Y-m-d',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first(), 401);
        }

        $user = Auth::guard('user-api')->user();

        $lesson = Lesson::findOrFail($lessonId);
        if (!$lesson->users()->where('userId', $user->id)->exists()) {
            throw new Exception('Unauthorized: You can only update works in your own lessons.', 403);
        }

        try {
            $lessonWork = LessonWork::findOrFail($lessonWorkId);
            $lessonWork->update($data);
            return $lessonWork;
        } catch (Exception $e) {
            throw new Exception('Could not update lesson work', 500);
        }
    }
}
