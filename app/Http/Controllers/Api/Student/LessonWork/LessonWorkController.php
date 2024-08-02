<?php

namespace App\Http\Controllers\Api\Student\LessonWork;

use App\Http\Controllers\Controller;
use App\Services\Student\LessonWork\WorkService\LessonWorkService;
use App\Traits\GeneralTrait;
use Exception;
use Illuminate\Http\Request;

class LessonWorkController extends Controller
{
    use GeneralTrait;

    protected $lessonWorkService;

    public function __construct(LessonWorkService $lessonWorkService)
    {
        $this->lessonWorkService = $lessonWorkService;
    }
    //Get Lesson Works by lesson
    public function index($lessonId)
    {
        try {
            $lessonWorks = $this->lessonWorkService->getLessonWorksByLesson($lessonId);
            return $this->returnData('data', $lessonWorks, 'Lesson works retrieved successfully');
        } catch (Exception $e) {
            return $this->returnError('500', $e->getMessage());
        }
    }

    public function getAllMyLessonWork()
    {
        try {
            $lessonWorks = $this->lessonWorkService->getLessonWorksByLesson();
            return $this->returnData('data', $lessonWorks, 'Lesson works for lesson retrieved successfully');
        } catch (Exception $e) {
            return $this->returnError('500', $e->getMessage());
        }
    }
    public function show($lessonWorkId)
    {
        try {
            $lessonWork = $this->lessonWorkService->getLessonWorkById($lessonWorkId);
            return $this->returnData('data', $lessonWork, 'Lesson work retrieved successfully');
        } catch (Exception $e) {
            return $this->returnError($e->getCode(), $e->getMessage());
        }
    }
}
