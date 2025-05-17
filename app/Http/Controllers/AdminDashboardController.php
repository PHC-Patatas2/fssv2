<?php
namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Room;
use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Traits\LogsActivity;

class AdminDashboardController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $this->logActivity('view_dashboard', 'dashboard', null, 'Admin viewed the dashboard.');
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'activeSchedules' => Schedule::where('status', 'active')->count(),
                'pendingApprovals' => User::where('status', 'pending')->count(),
                'systemAlerts' => 3, // Placeholder, replace with real logic
            ],
            'recentActivity' => ActivityLog::latest()->limit(5)->get(),
            'pendingApprovals' => User::where('status', 'pending')->get(['name', 'email']),
            'systemHealth' => 'All systems operational',
        ]);
    }
}
