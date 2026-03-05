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

    Route::get('task/edit/{id}', [TaskManager::class, 'taskEdit'])->name('tasks.edit');

    Route::post('task/edit/{id}', [TaskManager::class, 'taskEditPost'])->name('tasks.edit.post');

    Route::get('task/delete/{id}', [TaskManager::class, 'deleteTask'])->name('tasks.delete');

     Route::middleware('role.user')->group(function () {
        Route::get('task/add',  [TaskManager::class, 'addTask'])->name('tasks.add');
        Route::post('task/add', [TaskManager::class, 'addTaskPost'])->name('tasks.add.post');

        Route::get('task/status/{id}', [TaskManager::class, 'updateTaskStatus'])->name('tasks.status.update');
    });

    // ── Admin only routes ────────────────────────────────
    Route::middleware('role.admin')->group(function () {
        // Admin — specific user er tasks dekhbe
        Route::get('admin/user/{userId}/tasks', [TaskManager::class, 'adminUserTasks'])->name('admin.user.tasks');
    });

     
});

    Route::get('/otp/verify',    [AuthManager::class, 'showOtpForm'])->name('otp.verify.form');
    Route::post('/otp/verify',   [AuthManager::class, 'verifyOtp'])->name('otp.verify');
    Route::post('/otp/resend',   [AuthManager::class, 'resendOtp'])->name('otp.resend');



Route::get('forget-password', [ForgetPasswordManager::class, 'forgetPassword'])->name('forget.password');
Route::post('forget-password', [ForgetPasswordManager::class, 'forgetPasswordPost'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgetPasswordManager::class, 'resetPassword'])->name('reset.password');
Route::post('reset-password', [ForgetPasswordManager::class, 'resetPasswordPost'])->name('reset.password.post');