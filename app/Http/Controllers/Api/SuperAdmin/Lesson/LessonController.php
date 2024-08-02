<?php

namespace App\Http\Controllers\Api\SuperAdmin\Lesson;

use App\Http\Controllers\Controller;
use App\Services\SuperAdmin\Lesson\LessonService\LessonService;
use App\Traits\GeneralTrait;
use Exception;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    use GeneralTrait;

    protected $lessonService;

    public function __construct(LessonService $lessonService)
    {
        $this->lessonService = $lessonService;
    }
    public function index()
    {
        try {
            $lessons = $this->lessonService->getAllLessons();
            return $this->returnData('data', $lessons, 'Lessons retrieved successfully');
        } catch (Exception $e) {
            return $this->returnError($e->getCode(), $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $lesson = $this->lessonService->getLessonById($id);
            return $this->returnData('data', $lesson, 'Lesson retrieved successfully');
        } catch (Exception $e) {
            return $this->returnError($e->getCode(), $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $lesson = $this->lessonService->createLesson($request->all());
            return $this->returnData('data', $lesson, 'Lesson created successfully');
        } catch (Exception $e) {
            return $this->returnError($e->getCode(), $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $lesson = $this->lessonService->updateLesson($id, $request->all());
            return $this->returnData('data', $lesson, 'Lesson updated successfully');
        } catch (Exception $e) {
            return $this->returnError($e->getCode(), $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->lessonService->deleteLesson($id);
            return $this->returnSuccessMassage('Lesson deleted successfully');
        } catch (Exception $e) {
            return $this->returnError($e->getCode(), $e->getMessage());
        }
    }

    public function addUser(Request $request)
    {
        try {
            $data = $this->lessonService->addUserToLesson($request->lessonId, $request->userId);
            return $this->returnData('data', $data, 'User added to lesson successfully');
        } catch (Exception $e) {
            return $this->returnError($e->getCode(), $e->getMessage());
        }
    }

    public function removeUser(Request $request)
    {
        try {
            $this->lessonService->removeUserFromLesson($request->lessonId, $request->userId);
            return $this->returnSuccessMassage('User removed from lesson successfully');
        } catch (Exception $e) {
            return $this->returnError($e->getCode(), $e->getMessage());
        }
    }

    public function getStudentLessons($lessonId)
    {
        try {
            $lessons = $this->lessonService->getLessonsByRole($lessonId, 'student');
            return $this->returnData('data', $lessons, 'Student lessons retrieved successfully');
        } catch (Exception $e) {
            return $this->returnError($e->getCode(), $e->getMessage());
        }
    }

    public function getTeacherLessons($lessonId)
    {
        try {
            $lessons = $this->lessonService->getLessonsByRole($lessonId, 'teacher');
            return $this->returnData('data', $lessons, 'Teacher lessons retrieved successfully');
        } catch (Exception $e) {
            return $this->returnError($e->getCode(), $e->getMessage());
        }
    }
}
