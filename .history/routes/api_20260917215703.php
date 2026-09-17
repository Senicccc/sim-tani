<?php

use App\Http\Controllers\AnggotaJenisPekerjaanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenisPekerjaanController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\KegiatanPekerjaanController;
use App\Http\Controllers\PenugasanController;
use App\Http\Controllers\PermintaanPerubahanController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TaskHistoryController;
use App\Http\Controllers\UpahController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::get('/profile', [UserController::class, 'profile']);
    Route::put('/profile', [UserController::class, 'updateProfile']);

    Route::get('/my/tasks', [PenugasanController::class, 'myTasks']);
    Route::post('/my/tasks/{assignment}/start', [PenugasanController::class, 'startTask']);
    Route::post('/my/tasks/{assignment}/complete', [PenugasanController::class, 'completeTask']);

    Route::get('/my/attendance', [PresensiController::class, 'myAttendance']);
    Route::post('/my/attendance/check-in', [PresensiController::class, 'checkIn']);
    Route::post('/my/attendance/check-out', [PresensiController::class, 'checkOut']);

    Route::get('/my/task-history', [TaskHistoryController::class, 'myHistory']);
    Route::get('/my/wages', [UpahController::class, 'myWages']);

    Route::get('/my/change-requests', [PermintaanPerubahanController::class, 'myRequests']);
    Route::post('/my/change-requests', [PermintaanPerubahanController::class, 'store']);

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
        Route::get('/users/{user}', [UserController::class, 'show']);
        Route::put('/users/{user}', [UserController::class, 'update']);
        Route::delete('/users/{user}', [UserController::class, 'destroy']);

        Route::get('/job-types', [JenisPekerjaanController::class, 'index']);
        Route::post('/job-types', [JenisPekerjaanController::class, 'store']);
        Route::get('/job-types/{jobType}', [JenisPekerjaanController::class, 'show']);
        Route::put('/job-types/{jobType}', [JenisPekerjaanController::class, 'update']);
        Route::delete('/job-types/{jobType}', [JenisPekerjaanController::class, 'destroy']);

        Route::get('/member-competencies', [AnggotaJenisPekerjaanController::class, 'index']);
        Route::post('/member-competencies', [AnggotaJenisPekerjaanController::class, 'store']);
        Route::put('/member-competencies/{competency}', [AnggotaJenisPekerjaanController::class, 'update']);
        Route::delete('/member-competencies/{competency}', [AnggotaJenisPekerjaanController::class, 'destroy']);

        Route::get('/activities', [KegiatanController::class, 'index']);
        Route::post('/activities', [KegiatanController::class, 'store']);
        Route::get('/activities/{activity}', [KegiatanController::class, 'show']);
        Route::put('/activities/{activity}', [KegiatanController::class, 'update']);
        Route::delete('/activities/{activity}', [KegiatanController::class, 'destroy']);
        Route::post('/activities/{activity}/generate-schedule', [KegiatanController::class, 'generateSchedule']);

        Route::get('/activities/{activity}/assignments', [PenugasanController::class, 'byActivity']);
        Route::get('/assignments', [PenugasanController::class, 'index']);
        Route::get('/assignments/{assignment}', [PenugasanController::class, 'show']);
        Route::put('/assignments/{assignment}', [PenugasanController::class, 'update']);
        Route::post('/assignments/{assignment}/verify', [PenugasanController::class, 'verify']);

        Route::get('/attendance', [PresensiController::class, 'index']);
        Route::get('/wages', [UpahController::class, 'index']);
        Route::post('/wages', [UpahController::class, 'store']);
        Route::put('/wages/{wage}', [UpahController::class, 'update']);
        Route::post('/wages/{wage}/mark-paid', [UpahController::class, 'markPaid']);

        Route::get('/change-requests', [PermintaanPerubahanController::class, 'index']);
        Route::get('/change-requests/{request}', [PermintaanPerubahanController::class, 'show']);
        Route::post('/change-requests/{request}/process', [PermintaanPerubahanController::class, 'process']);

        Route::get('/reports/work', [ReportController::class, 'workReport']);
        Route::get('/reports/attendance', [ReportController::class, 'attendanceReport']);
        Route::get('/reports/wages', [ReportController::class, 'wageReport']);

        Route::get('/dashboard', [DashboardController::class, 'index']);
    });
});
