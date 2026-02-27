<?php
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\TaskManager;
use App\Http\Controllers\ForgetPasswordManager;
use Illuminate\Support\Facades\Route;
use Termwind\Components\Raw;



Route::get('login', [AuthManager::class, 'login'])->name('login');

Route::post('login', [AuthManager::class, 'loginPost'])->name('login.post');

Route::get('logout', [AuthManager::class, 'logout'])->name('logout');

Route::get('register', [AuthManager::class, 'register'])->name('register');

Route::post('register', [AuthManager::class, 'registerPost'])->name('register.post');


Route::middleware('auth')->group(function () {
    Route::get('/', [TaskManager::class, 'listTask'])->name('home');
    
    Route::get('task/add', [TaskManager::class, 'addTask'])->name('tasks.add');

    Route::post('task/add', [TaskManager::class, 'addTaskPost'])->name('tasks.add.post');

    Route::get('task/status/{id}', [TaskManager::class, 'updateTaskStatus'])->name('tasks.status.update');

    Route::get('task/edit/{id}', [TaskManager::class, 'taskEdit'])->name('tasks.edit');

    Route::post('task/edit/{id}', [TaskManager::class, 'taskEditPost'])->name('tasks.edit.post');

    Route::get('task/delete/{id}', [TaskManager::class, 'deleteTask'])->name('tasks.delete');
});


Route::get('forget-password', [ForgetPasswordManager::class, 'forgetPassword'])->name('forget.password');
Route::post('forget-password', [ForgetPasswordManager::class, 'forgetPasswordPost'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgetPasswordManager::class, 'resetPassword'])->name('reset.password');
Route::post('reset-password', [ForgetPasswordManager::class, 'resetPasswordPost'])->name('reset.password.post');