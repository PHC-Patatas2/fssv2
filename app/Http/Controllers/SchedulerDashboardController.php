<?php
namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Traits\LogsActivity;
use Illuminate\Support\Facades\Auth;

class SchedulerDashboardController extends Controller
{
    use LogsActivity;

    public function index(): Response
    {
        $this->logActivity('viewed_dashboard', 'dashboard', null, 'Scheduler viewed dashboard');
        // You can pass scheduler-specific data here
        return Inertia::render('Scheduler/DashboardFallback');
    }

    public function createSchedule(Request $request)
    {
        // Validate and create schedule
        $schedule = Schedule::create($request->all());
        $this->logActivity('created_schedule', 'schedule', $schedule->id, 'Created a new schedule');
        return redirect()->back()->with('status', 'Schedule created!');
    }

    public function updateSchedule(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->update($request->all());
        $this->logActivity('updated_schedule', 'schedule', $schedule->id, 'Updated a schedule');
        return redirect()->back()->with('status', 'Schedule updated!');
    }

    public function deleteSchedule($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();
        $this->logActivity('deleted_schedule', 'schedule', $id, 'Deleted a schedule');
        return redirect()->back()->with('status', 'Schedule deleted!');
    }
}
