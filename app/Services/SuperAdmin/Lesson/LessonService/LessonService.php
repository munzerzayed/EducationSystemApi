<?php
namespace App\Services\SuperAdmin\Lesson\LessonService;

use App\Models\Lesson;
use Exception;
use Illuminate\Support\Facades\Validator;

class LessonService
{
    public function getAllLessons()
    {
        try {
            return Lesson::all();
        } catch (Exception $e) {
            throw new Exception('Could not retrieve lessons', 500);
        }
    }

    public function getLessonById($id)
    {
        try {
            return Lesson::with(['users.roles'])->findOrFail($id);
        } catch (Exception $e) {
            throw new Exception('Lesson not found', 404);
        }
    }

    public function createLesson($data)
    {
        $rules = [
            'lessonName' => 'required|string|max:255',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first(), 401);
        }

        try {
            return Lesson::create($data);
        } catch (Exception $e) {
            throw new Exception('Could not create lesson', 500);
        }
    }

    public function updateLesson($id, $data)
    {
        $rules = [
            'lessonName' => 'required|string|max:255',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first(), 401);
        }

        try {
            $lesson = Lesson::findOrFail($id);
            $lesson->update($data);
            return $lesson;
        } catch (Exception $e) {
            throw new Exception('Could not update lesson', 500);
        }
    }

    public function deleteLesson($id)
    {
        try {
            $lesson = Lesson::findOrFail($id);
            $lesson->delete();
            return true;
        } catch (Exception $e) {
            throw new Exception('Could not delete lesson', 500);
        }
    }

    public function addUserToLesson($lessonId, $userId)
    {
        try {
            $lesson = Lesson::findOrFail($lessonId);
            if ($lesson->users()->where('userId', $userId)->exists()) {
                throw new Exception('User is already added to the lesson', 400);
            }

            $lesson->users()->attach($userId);
            return true;
        } catch (Exception $e) {
            throw new Exception('Could not add user to lesson', 500);
        }
    }

    public function removeUserFromLesson($lessonId, $userId)
    {
        try {
            $lesson = Lesson::find($lessonId);
            $lesson->users()->detach($userId);
            return true;
        } catch (Exception $e) {
            throw new Exception('Could not remove user from lesson', 500);
        }
    }

    public function getLessonsByRole($lessonId, $role)
    {
        try {
            $lesson = Lesson::findOrFail($lessonId);
            $data = $lesson->users()->whereHas('roles', function ($query) use ($role) {
                $query->where('name', $role);
            })->get();

            return $data;
        } catch (Exception $e) {
            throw new Exception('Could not retrieve lessons', 500);
        }
    }
}

