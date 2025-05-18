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
        // User counts by role
        $totalUsers = User::count();
        $adminCount = User::where('role', 'admin')->count();
        $schedulerCount = User::where('role', 'scheduler')->count();
        $teacherCount = User::where('role', 'teacher')->count();
        $studentCount = User::where('role', 'student')->count();
        // Pending approvals
        $pendingApprovals = User::where('status', 'pending')->get();
        // Active schedules
        $activeSchedules = Schedule::where('status', 'active')->count();
        // System logs: last 5 activity logs
        $recentActivity = \App\Models\ActivityLog::orderBy('created_at', 'desc')->limit(5)->get();
        return Inertia::render('Admin/DashboardFallback', [
            'totalUsers' => $totalUsers,
            'adminCount' => $adminCount,
            'schedulerCount' => $schedulerCount,
            'teacherCount' => $teacherCount,
            'studentCount' => $studentCount,
            'pendingApprovals' => $pendingApprovals,
            'activeSchedules' => $activeSchedules,
            'recentActivity' => $recentActivity,
        ]);
    }
}
