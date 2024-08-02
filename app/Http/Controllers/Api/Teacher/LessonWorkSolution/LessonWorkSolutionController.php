<?php

namespace App\Http\Controllers\Api\Teacher\LessonWorkSolution;

use App\Http\Controllers\Controller;
use App\Services\Teacher\LessonWork\WorkSolutionService\LessonWorkSolutionService;
use App\Traits\GeneralTrait;
use Exception;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;

class LessonWorkSolutionController extends Controller
{
    use GeneralTrait;

    protected $lessonWorkSolutionService;

    public function __construct(LessonWorkSolutionService $lessonWorkSolutionService)
    {
        $this->lessonWorkSolutionService = $lessonWorkSolutionService;
    }

    public function index($lessonWorkId){
        try {
            $solution = $this->lessonWorkSolutionService->getAllSolutionsByLessonWork($lessonWorkId);
            return $this->returnData('data', $solution, 'Retrive Solution successfully');
        } catch (Exception $e) {
            return $this->returnError($e->getCode(), $e->getMessage());
        }
    }
}
