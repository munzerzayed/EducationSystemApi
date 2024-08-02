<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\SuperAdmin\Lesson\LessonController as AdminLessonController;
use App\Http\Controllers\Api\Teacher\Lesson\LessonController as TeacherLessonController;
use App\Http\Controllers\Api\Student\Lesson\LessonController as StudentLessonController;
use App\Http\Controllers\Api\Student\LessonWork\LessonWorkController as StudentLessonWorkController;
use App\Http\Controllers\Api\Student\LessonWorkSolution\LessonWorkSolutionController;
use App\Http\Controllers\Api\Teacher\LessonWorkSolution\LessonWorkSolutionController as TeacherLessonWorkSolutionController;
use App\Http\Controllers\Api\Teacher\LessonWork\LessonWorkController as TeacherLessonWorkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::group(['middleware' => ['api']] , function(){
	Route::get('user-profile', [AuthController::class, 'userProfile']);
	Route::post('logout',[AuthController::class, 'logout']);

    Route::group(['prefix' => 'lesson'] , function(){

        Route::group(['prefix' => 'superAdmin'] , function(){
            Route::group(['middleware' => ['ensureUserHasRole:superAdmin']] , function(){
                Route::get('lessons', [AdminLessonController::class, 'index']);
                Route::get('show/{id}', [AdminLessonController::class, 'show']);
                Route::post('store', [AdminLessonController::class, 'store']);
                Route::post('update/{id}', [AdminLessonController::class, 'update']);
                Route::post('destroy/{id}', [AdminLessonController::class, 'destroy']);
                Route::post('add-user', [AdminLessonController::class, 'addUser']);
                Route::post('remove-user', [AdminLessonController::class, 'removeUser']);
                Route::get('{lessonId}/lesson-students', [AdminLessonController::class, 'getStudentLessons']);
                Route::get('{lessonId}/lesson-teachers', [AdminLessonController::class, 'getTeacherLessons']);
            });
        });

        Route::group(['prefix' => 'teacher'] , function(){
            Route::group(['middleware' => ['ensureUserHasRole:teacher']] , function(){
                Route::get('lessons', [TeacherLessonController::class, 'index']);
                Route::get('show/{id}', [TeacherLessonController::class, 'show']);
                Route::get('{lessonId}/lesson-students', [TeacherLessonController::class, 'getLessonStudents']);
            });
        });

        Route::group(['prefix' => 'student'] , function(){
            Route::group(['middleware' => ['ensureUserHasRole:student']] , function(){
                Route::get('lessons', [StudentLessonController::class, 'index']);
                Route::get('show/{id}', [StudentLessonController::class, 'show']);
                Route::get('{lessonId}/lesson-teachers', [StudentLessonController::class, 'getLessonTeachers']);
            });
        });
    });

    Route::group(['prefix' => 'lessonWork'] , function(){

        Route::group(['prefix' => 'teacher'] , function(){
            Route::group(['middleware' => ['ensureUserHasRole:teacher']] , function(){
                Route::get('all', [TeacherLessonWorkController::class, 'getAllMyLessonWork']);
                Route::get('index/{lessonId}', [TeacherLessonWorkController::class, 'index']);
                Route::post('store', [TeacherLessonWorkController::class, 'store']);
                Route::post('{lessonId}/update/{lessonWorkId}', [TeacherLessonWorkController::class, 'update']);
                Route::get('show/{id}', [TeacherLessonWorkController::class, 'show']);
                Route::post('destroy/{id}', [TeacherLessonWorkController::class, 'destroy']);
            });
        });

        Route::group(['prefix' => 'student'] , function(){
            Route::group(['middleware' => ['ensureUserHasRole:student']] , function(){
                Route::get('all', [StudentLessonWorkController::class, 'getAllMyLessonWork']);
                Route::get('{lessonId}/lessonworks', [StudentLessonWorkController::class, 'index']);
                Route::get('show/{lessonWorkId}', [StudentLessonWorkController::class, 'show']);
            });
        });
    });

    Route::group(['prefix' => 'lessonWorkSolution'] , function(){
        Route::group(['prefix' => 'student'] , function(){
            Route::group(['middleware' => ['ensureUserHasRole:student']] , function(){
                Route::post('store', [LessonWorkSolutionController::class, 'store']);
                Route::get('show/{lessonWorkId}', [LessonWorkSolutionController::class, 'show']);
            });
        });

        Route::group(['prefix' => 'teacher'] , function(){
            Route::group(['middleware' => ['ensureUserHasRole:teacher']] , function(){
                Route::get('index/{lessonWorkId}', [TeacherLessonWorkSolutionController::class, 'index']);
            });
        });
    });
});
