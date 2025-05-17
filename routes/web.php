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
    return redirect('/')->with('status', 'Dashboards are in progress. You are logged in, but will remain on this page until dashboards are available.');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
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
