<?php

namespace App\Http\Controllers\Api\Student\Lesson;

use App\Http\Controllers\Controller;
use App\Services\Student\Lesson\LessonService;
use App\Traits\GeneralTrait;
use Exception;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    use GeneralTrait;
    protected $studentLessonService;

    public function __construct(LessonService $studentLessonService)
    {
        $this->studentLessonService = $studentLessonService;
    }

    public function index()
    {
        try {
            $lessons = $this->studentLessonService->getStudentLessons();
            return $this->returnData('data', $lessons, 'Lessons retrieved successfully');
        } catch (Exception $e) {
            return $this->returnError('500', $e->getMessage());
        }
    }

    public function show($lessonId)
    {
        try {
            $lesson = $this->studentLessonService->getLessonById($lessonId);
            return $this->returnData('data', $lesson, 'Lesson retrieved successfully');
        } catch (Exception $e) {
            return $this->returnError('500', $e->getMessage());
        }
    }

    public function getLessonTeachers($lessonId)
    {
        try {
            $teachers = $this->studentLessonService->getLessonTeachers($lessonId);
            return $this->returnData('data', $teachers, 'Teachers retrieved successfully');
        } catch (Exception $e) {
            return $this->returnError('500', $e->getMessage());
        }
    }
}
