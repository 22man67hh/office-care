<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('tasks', TaskController::class);
    Route::resource('statuses',StatusController::class);
 Route::resource('/permissions',PermissionController::class);
    Route::resource('/roles', RoleController::class);
    Route::resource('/users', UserController::class);
    Route::get('/tasks/{task}/assign', [TaskController::class, 'assign'])->name('tasks.assign');
        Route::put('/tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');

Route::put('/tasks/{task}/assign', [TaskController::class, 'processAssignment'])->name('tasks.assign.store');

});
Route::post('/tasks/{task}/update-status', [TaskController::class, 'updateStatus'])
    ->name('tasks.update-status')
    ->middleware('auth');

require __DIR__.'/auth.php';
