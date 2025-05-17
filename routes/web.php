<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserApprovalController;
use App\Http\Controllers\AdminDashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Auth/Login', [
        'canResetPassword' => Route::has('password.request'),
        'canRegister' => Route::has('register'),
        'status' => session('status'),
    ]);
});

Route::get('/dashboard', function () {
    $user = \Illuminate\Support\Facades\Auth::user();
    if ($user && $user->role === 'admin') {
        return Inertia::render('AdminDashboard');
    }
    return Inertia::render('SchedulerDashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/user-approvals', [UserApprovalController::class, 'index'])->name('admin.user-approvals');
    Route::post('/user-approvals/{id}/approve', [UserApprovalController::class, 'approve'])->name('admin.user-approvals.approve');
    Route::post('/user-approvals/{id}/decline', [UserApprovalController::class, 'decline'])->name('admin.user-approvals.decline');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/create-schedule', function () {
        return Inertia::render('Admin/CreateSchedule');
    })->name('admin.create-schedule');
    Route::get('/manage-schedules', function () {
        return Inertia::render('Admin/ManageSchedules');
    })->name('admin.manage-schedules');
    Route::get('/records', function () {
        return Inertia::render('Admin/Records');
    })->name('admin.records');
    Route::get('/system-logs', function () {
        return Inertia::render('Admin/SystemLogs');
    })->name('admin.system-logs');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
