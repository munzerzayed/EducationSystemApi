<?php

namespace App\Http\Controllers\Api\Teacher\LessonWork;

use App\Http\Controllers\Controller;
use App\Services\Teacher\LessonWork\WorkService\LessonWorkService;
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

    public function index($lessonId)
    {
        try {
            $lessonWorks = $this->lessonWorkService->getLessonWorksByLesson($lessonId);
            return $this->returnData('data', $lessonWorks, 'Lesson works retrieved successfully');
        } catch (Exception $e) {
            return $this->returnError('500', 'Could not retrieve lesson works');
        }
    }

    public function getAllMyLessonWork()
    {
        try {
            $lessonWorks = $this->lessonWorkService->getLessonWorks();
            return $this->returnData('data', $lessonWorks, 'Lesson works retrieved successfully');
        } catch (Exception $e) {
            return $this->returnError('500', 'Could not retrieve lesson works');
        }
    }

    public function store(Request $request)
    {
        try {
            $lessonWork = $this->lessonWorkService->createLessonWork($request->all());
            return $this->returnData('data', $lessonWork, 'Lesson work created successfully');
        } catch (Exception $e) {
            return $this->returnError($e->getCode(), $e->getMessage());
        }
    }

    public function update(Request $request, $lessonId, $lessonWorkId)
    {
        try {
            $lessonWork = $this->lessonWorkService->updateLessonWork($lessonId, $lessonWorkId, $request->all());
            return $this->returnData('data', $lessonWork, 'Lesson work updated successfully');
        } catch (Exception $e) {
            return $this->returnError($e->getCode(), $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $lessonWork = $this->lessonWorkService->getLessonWorkById($id);
            return $this->returnData('data', $lessonWork, 'Lesson work retrieved successfully');
        } catch (Exception $e) {
            return $this->returnError($e->getCode(), $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->lessonWorkService->deleteLessonWork($id);
            return $this->returnSuccessMassage('Lesson work deleted successfully');
        } catch (Exception $e) {
            return $this->returnError($e->getCode(), $e->getMessage());
        }
    }
}
