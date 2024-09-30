<?php
use App\Exports\SampleExport;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Api\ImportController;
use App\Http\Controllers\ProjectExportController;
use App\Http\Controllers\SampleExportController;
use App\Http\Controllers\OverviewController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\TaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Api\LockController;
use App\Http\Controllers\ManagerController;
Route::get('/', function () {
    return redirect()->route('projects.index');
});
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth', 'verified')->group(function () {
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
    Route::get('/overview', [OverviewController::class, 'index'])->name('overview.index');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::get('/projects/{project}/data', [OverviewController::class, 'getProjectData'])->name('projects.data');
    Route::get('/projects/{id}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::get('/sponsor', [SponsorController::class, 'index'])->name('sponsor.index');
    Route::get('/api/sponsors', [SponsorController::class, 'getSponsors']);
    Route::get('/api/sponsors/{sponsorName}', [SponsorController::class, 'getSponsorDetails']);
    Route::get('/api/sponsors/{sponsorName}/months', [SponsorController::class, 'getSponsorMonths']);
    Route::get('/api/sponsors/no-tasks', [SponsorController::class, 'getSponsorsWithoutTasks']);
    
        Route::get('/api/user-role', function () {
        return response()->json([
            'role' => auth()->user()->getRoleNames()->first() 
        ]);
    })->name('user.role');
});
require __DIR__ . '/auth.php';
