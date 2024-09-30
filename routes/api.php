<?php

use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\AssignableController;
use App\Http\Controllers\Api\ImportController;
use App\Http\Controllers\Api\LockController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\OverviewDataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('activities', ActivityController::class)->only(['update']);
Route::apiResource('tasks', TaskController::class)->only(['update']);
Route::apiResource('locks', LockController::class)->only(['update']);
Route::post('import/{project}', ImportController::class)->name('import');
Route::post('/assignments/{project}', [AssignableController::class, 'assignments'])->name('assignments');
Route::get('/overview-data', [OverviewDataController::class, 'index']);
