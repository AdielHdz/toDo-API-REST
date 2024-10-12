<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::prefix('/auth')->group(function () {
    /* Route sign in */
    Route::post('/login',         [AuthController::class, 'login'])->name('login');
    /* Route register new user */
    Route::post('/register',      [AuthController::class, 'register'])->name('register');
    /* Route logout user */
    Route::post('/logout',        [AuthController::class, 'logout'])->name('logout');
});


Route::middleware('auth:sanctum')->group(function () {
    /* Route get all users  */
    Route::get('/user',          [UserController::class, 'index'])->name('all-users');

    Route::prefix('task')->group(function () {
        /* Route register get all tasks related to one user */
        Route::get('/{id}',      [TaskController::class, 'storeUserTasks'])->name('all-user-tasks');
        /*------------------------------------------------------------------------------------- */

        /* Route get all tasks */
        Route::get('/',          [TaskController::class, 'index'])->name('all-tasks');
        /* Route get task by id */
        Route::get('/{id}',      [TaskController::class, 'show'])->name('all-tasks');
        /* Route register new task */
        Route::post('/',         [TaskController::class, 'store'])->name('create-task');
        /* Route update task */
        Route::put('/',          [TaskController::class, 'update'])->name('all-user-tasks');
        /* Route delete task */
        Route::delete('/{id}',   [TaskController::class, 'destroy'])->name('all-user-tasks');
    });
});
