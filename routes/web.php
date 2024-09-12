<?php
use App\Exports\SampleExport;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Api\ImportController;
use App\Http\Controllers\ProjectExportController;
use App\Http\Controllers\SampleExportController;
use App\Http\Controllers\TaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Api\LockController;
use App\Http\Controllers\ManagerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('projects.index');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/projects', ProjectController::class)->except(['edit', 'update']);
    Route::resource('/groups', GroupController::class)->only('store');
    Route::resource('/tasks', TaskController::class)->only('store');
    Route::get('/sample_export/{project}', SampleExportController::class)->name('sample_export');
    Route::get('/project_export/{project}', ProjectExportController::class)->name('project_export');
    Route::patch('locks/{lock}', [LockController::class, 'update'])->name('locks.update');
    Route::post('/projects/{project}/import', ImportController::class)->name('import');
    Route::post('/locks/get-entity-locks', [LockController::class, 'getLocks']);
    Route::get('manager-login', [ManagerController::class, 'showLoginForm'])->name('manager.login.form');
    Route::post('manager-login', [ManagerController::class, 'login'])->name('manager.login');
    Route::post('manager-logout', [ManagerController::class, 'logout'])->name('manager.logout');
    Route::get('/managers', [UserController::class, 'getManagers']);

});

require __DIR__ . '/auth.php';
