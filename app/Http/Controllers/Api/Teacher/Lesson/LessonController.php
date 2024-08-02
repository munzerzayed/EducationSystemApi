<?php

namespace App\Http\Controllers\Api\Teacher\Lesson;

use App\Http\Controllers\Controller;
use App\Services\Teacher\Lesson\LessonService;
use App\Traits\GeneralTrait;
use Exception;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    use GeneralTrait;
    protected $teacherLessonService;

    public function __construct(LessonService $teacherLessonService)
    {
        $this->teacherLessonService = $teacherLessonService;
    }

    public function index()
    {
        try {
            $lessons = $this->teacherLessonService->getTeacherLessons();
            return $this->returnData('data', $lessons, 'Lessons retrieved successfully');
        } catch (Exception $e) {
            return $this->returnError('500', $e->getMessage());
        }
    }


    public function getLessonStudents($lessonId)
    {
        try {
            $students = $this->teacherLessonService->getLessonStudents($lessonId);
            return $this->returnData('data', $students, 'Students retrieved successfully');
        } catch (Exception $e) {
            return $this->returnError('500', $e->getMessage());
        }
    }

    public function show($lessonId)
    {
        try {
            $lesson = $this->teacherLessonService->getLessonById($lessonId);
            return $this->returnData('data', $lesson, 'Lesson retrieved successfully');
        } catch (Exception $e) {
            return $this->returnError('500', $e->getMessage());
        }
    }
}
