<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminDashboardController extends Controller
{
    public function index(): Response
    {
        // Only count approved users who are admin or scheduler
        $totalUsers = User::whereIn('role', ['admin', 'scheduler'])
            ->where('status', 'approved')
            ->count();
        $adminCount = User::where('role', 'admin')->where('status', 'approved')->count();
        $schedulerCount = User::where('role', 'scheduler')->where('status', 'approved')->count();
        // Pending approvals (for admins to review)
        $pendingApprovals = User::where('status', 'pending')->get();
        // Active schedules
        $activeSchedules = Schedule::where('status', 'active')->count();
        // System logs: last 5 activity logs
        $recentActivity = \App\Models\ActivityLog::orderBy('created_at', 'desc')->limit(5)->get();
        $rooms = \App\Models\Room::all();
        $teachers = \App\Models\Teacher::all();
        $subjects = \App\Models\Subject::all();
        $users = \App\Models\User::all();
        $admins = User::where('role', 'admin')->where('status', 'approved')->get();
        $schedulers = User::where('role', 'scheduler')->where('status', 'approved')->get();
        return Inertia::render('Admin/DashboardFallback', [
            'totalUsers' => $totalUsers,
            'adminCount' => $adminCount,
            'schedulerCount' => $schedulerCount,
            'admins' => $admins,
            'schedulers' => $schedulers,
            'pendingApprovals' => $pendingApprovals,
            'activeSchedules' => $activeSchedules,
            'recentActivity' => $recentActivity,
            'rooms' => $rooms,
            'teachers' => $teachers,
            'subjects' => $subjects,
            'users' => $users,
        ]);
    }
}
