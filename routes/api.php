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
    Route::post('/logout',        [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');
});


Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('user')->group(function () {
        /* Route get all users  */
        Route::get('/',          [UserController::class, 'index'])->name('all-users');
        /* Route get user data  */
        Route::get('/{id}',          [UserController::class, 'show'])->name('user-profile');
    });


    Route::prefix('task')->group(function () {
        /* Route register get all tasks related to one user */
        Route::get('/user/{id}',      [TaskController::class, 'storeUserTasks'])->name('all-user-tasks');
        /*------------------------------------------------------------------------------------- */

        /* Route get all tasks */
        Route::get('/',          [TaskController::class, 'index'])->name('all-tasks');
        /* Route get task by id */
        Route::get('/{id}',      [TaskController::class, 'show'])->name('get-task');
        /* Route register new task */
        Route::post('/',         [TaskController::class, 'store'])->name('create-task');
        /* Route update task */
        Route::put('/',          [TaskController::class, 'update'])->name('update-task');
        /* Route delete task */
        Route::delete('/{id}',   [TaskController::class, 'destroy'])->name('delete-task');
    });
});
