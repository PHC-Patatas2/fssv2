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
    Route::resource('rooms', \App\Http\Controllers\RoomController::class)->except(['show', 'create', 'edit']);
    Route::resource('teachers', \App\Http\Controllers\TeacherController::class)->except(['show', 'create', 'edit']);
    Route::resource('subjects', \App\Http\Controllers\SubjectController::class)->except(['show', 'create', 'edit']);
    Route::resource('schedules', \App\Http\Controllers\ScheduleController::class)->except(['show', 'create', 'edit']);
    Route::get('schedules/export/csv', [\App\Http\Controllers\ScheduleController::class, 'exportCsv'])->name('schedules.export.csv');
    Route::get('schedules/export/pdf', [\App\Http\Controllers\ScheduleController::class, 'exportPdf'])->name('schedules.export.pdf');
    Route::get('system-report/export/pdf', [\App\Http\Controllers\ScheduleController::class, 'exportSystemReport'])->name('system-report.export.pdf');
    Route::get('/users', function () {
        $users = \App\Models\User::all();
        return Inertia::render('Admin/Users', ['users' => $users]);
    })->name('admin.users');
    Route::get('/export', function () {
        return Inertia::render('Admin/Export');
    })->name('admin.export');
    Route::get('/settings', function () {
        return Inertia::render('Admin/Settings');
    })->name('admin.settings');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
