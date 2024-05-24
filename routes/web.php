<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\AnswerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [RedirectController::class, 'redirectToDashboardPage']);
Route::get('/classrooms', [RedirectController::class, 'redirectToClassroomsPage']);
Route::get('/classrooms/{code}', [RedirectController::class, 'redirectToClassroomPage']);
Route::get('/classrooms/{code}/assessments/builder', [RedirectController::class, 'redirectToAssessmentBuilderPage']);
Route::post('/classrooms/{code}/assessments/builder/preview', [RedirectController::class, 'redirectToAssessmentPreviewPage']);
Route::post('/classrooms/{code}/assessments/builder/process', [AssessmentController::class, 'create']);
Route::get('/classrooms/{code}/assessments/view/{id}', [RedirectController::class, 'redirectToAssessmentPage']);
Route::get('/classrooms/{code}/assessments/grade/{assessment_id}/user/{user_id}', [RedirectController::class, 'redirectToGradeAssessmentPage']);
Route::post('/classroom/create', [ClassroomController::class, 'create']);
Route::post('/classroom/join', [ClassroomController::class, 'join']);

Route::get('/assessments/latest', [RedirectController::class, 'redirectToLatestAssementPage']);

Route::post('/assessment/delete', [AssessmentController::class, 'delete']);

Route::post('/answer/create', [AnswerController::class, 'create']);
Route::post('/answer/grade', [AnswerController::class, 'grade']);

Route::get('/login', [RedirectController::class, 'redirectToLoginPage']);
Route::post('/login/process', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout']);

Route::get('/register', [RedirectController::class, 'redirectToRegisterPage']);
Route::post('/register/process', [UserController::class, 'register']);

Route::get('/account', [RedirectController::class, 'redirectToAccountPage']);
Route::post('/account/update', [UserController::class, 'update']);
Route::post('/account/password/reset', [UserController::class, 'resetPassword']);
