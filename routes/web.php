<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserApprovalController;
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
    if (auth()->user()->role === 'admin') {
        return Inertia::render('AdminDashboard');
    }
    return Inertia::render('SchedulerDashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/user-approvals', [UserApprovalController::class, 'index'])->name('admin.user-approvals');
    Route::post('/admin/user-approvals/{id}/approve', [UserApprovalController::class, 'approve'])->name('admin.user-approvals.approve');
    Route::post('/admin/user-approvals/{id}/decline', [UserApprovalController::class, 'decline'])->name('admin.user-approvals.decline');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
