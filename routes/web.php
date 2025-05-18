<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserApprovalController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
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
    if (!Auth::check()) {
        return redirect('/')->with('status', 'Please login first.');
    }
    $user = Auth::user();
    if ($user->role === 'admin') {
        // Use the controller to provide all dashboard props
        return app(\App\Http\Controllers\AdminDashboardController::class)->index();
    } elseif ($user->role === 'scheduler') {
        return Inertia::render('Scheduler/DashboardFallback');
    } else {
        Auth::logout();
        return redirect('/')->with('status', 'Invalid credentials or role.');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/create-schedule', function () {
        return Inertia::render('Admin/ManageSchedules'); // Placeholder, update as needed
    })->name('admin.create-schedule');
    Route::get('/manage-schedules', function () {
        return Inertia::render('Admin/ManageSchedules'); // Placeholder, update as needed
    })->name('admin.manage-schedules');
    Route::get('/records', function () {
        return Inertia::render('Admin/Records'); // Placeholder, update as needed
    })->name('admin.records');
    Route::get('/system-logs', function () {
        return Inertia::render('Admin/SystemLogs'); // Placeholder, update as needed
    })->name('admin.system-logs');
    Route::get('/user-approvals', [UserApprovalController::class, 'index'])->name('admin.user-approvals');
    Route::post('/user-approvals/{id}/approve', [UserApprovalController::class, 'approve'])->name('admin.user-approvals.approve');
    Route::post('/user-approvals/{id}/decline', [UserApprovalController::class, 'decline'])->name('admin.user-approvals.decline');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
