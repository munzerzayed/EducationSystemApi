<?php

namespace App\Http\Controllers\Api\Student\LessonWorkSolution;

use App\Http\Controllers\Controller;
use App\Services\Student\LessonWork\WorkSolutionService\LessonWorkSolutionService;
use App\Traits\GeneralTrait;
use Exception;
use Illuminate\Http\Request;

class LessonWorkSolutionController extends Controller
{
    use GeneralTrait;

    protected $lessonWorkSolutionService;

    public function __construct(LessonWorkSolutionService $lessonWorkSolutionService)
    {
        $this->lessonWorkSolutionService = $lessonWorkSolutionService;
    }

    public function store(Request $request)
    {
        try {
            $solution = $this->lessonWorkSolutionService->addSolution($request->all());
            return $this->returnData('data', $solution, 'Solution added successfully');
        } catch (Exception $e) {
            return $this->returnError($e->getCode(), $e->getMessage());
        }
    }

    public function show($lessonWorkId)
    {
        try {
            $solution = $this->lessonWorkSolutionService->getUserSolution($lessonWorkId);
            return $this->returnData('data', $solution, 'Solution retrieved successfully');
        } catch (Exception $e) {
            return $this->returnError($e->getCode(), $e->getMessage());
        }
    }
}
