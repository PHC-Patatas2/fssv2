<?php
namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Room;
use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ScheduleController extends Controller
{
    public function index(): Response
    {
        $schedules = Schedule::with(['subject', 'teacher', 'room', 'creator'])->get();
        $subjects = \App\Models\Subject::all();
        $teachers = \App\Models\Teacher::all();
        $rooms = \App\Models\Room::all();
        $courses = \App\Models\Course::all();
        $years = \App\Models\Year::all();
        $semesters = \App\Models\Semester::all();
        $majors = \App\Models\Major::all();
        $sections = \App\Models\Section::all();
        return Inertia::render('Admin/Schedules', [
            'schedules' => $schedules,
            'subjects' => $subjects,
            'teachers' => $teachers,
            'rooms' => $rooms,
            'courses' => $courses,
            'years' => $years,
            'semesters' => $semesters,
            'majors' => $majors,
            'sections' => $sections,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'room_id' => 'required|exists:rooms,id',
            'day' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);
        // Room conflict
        $roomConflict = Schedule::where('room_id', $request->room_id)
            ->where('day', $request->day)
            ->where(function($q) use ($request) {
                $q->whereBetween('start_time', [$request->start_time, $request->end_time])
                  ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
            })->exists();
        if ($roomConflict) {
            return redirect()->back()->withErrors(['conflict' => 'Room is already booked for this time slot.']);
        }
        // Teacher conflict
        $teacherConflict = Schedule::where('teacher_id', $request->teacher_id)
            ->where('day', $request->day)
            ->where(function($q) use ($request) {
                $q->whereBetween('start_time', [$request->start_time, $request->end_time])
                  ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
            })->exists();
        if ($teacherConflict) {
            return redirect()->back()->withErrors(['conflict' => 'Teacher is already assigned to another class at this time.']);
        }
        // Prevent duplicate schedule (same subject, teacher, room, day, and time)
        $duplicate = Schedule::where('subject_id', $request->subject_id)
            ->where('teacher_id', $request->teacher_id)
            ->where('room_id', $request->room_id)
            ->where('day', $request->day)
            ->where('start_time', $request->start_time)
            ->where('end_time', $request->end_time)
            ->exists();
        if ($duplicate) {
            return redirect()->back()->withErrors(['conflict' => 'This exact schedule already exists.']);
        }
        $schedule = Schedule::create([
            ...$request->all(),
            'created_by' => \Auth::id(),
        ]);
        return redirect()->back()->with('status', 'Schedule created!');
    }
    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);
        $request->validate([
            'type' => 'required|string',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'room_id' => 'required|exists:rooms,id',
            'day' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);
        // Room conflict (excluding current)
        $roomConflict = Schedule::where('room_id', $request->room_id)
            ->where('day', $request->day)
            ->where('id', '!=', $id)
            ->where(function($q) use ($request) {
                $q->whereBetween('start_time', [$request->start_time, $request->end_time])
                  ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
            })->exists();
        if ($roomConflict) {
            return redirect()->back()->withErrors(['conflict' => 'Room is already booked for this time slot.']);
        }
        // Teacher conflict (excluding current)
        $teacherConflict = Schedule::where('teacher_id', $request->teacher_id)
            ->where('day', $request->day)
            ->where('id', '!=', $id)
            ->where(function($q) use ($request) {
                $q->whereBetween('start_time', [$request->start_time, $request->end_time])
                  ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
            })->exists();
        if ($teacherConflict) {
            return redirect()->back()->withErrors(['conflict' => 'Teacher is already assigned to another class at this time.']);
        }
        // Prevent duplicate schedule (excluding current)
        $duplicate = Schedule::where('subject_id', $request->subject_id)
            ->where('teacher_id', $request->teacher_id)
            ->where('room_id', $request->room_id)
            ->where('day', $request->day)
            ->where('start_time', $request->start_time)
            ->where('end_time', $request->end_time)
            ->where('id', '!=', $id)
            ->exists();
        if ($duplicate) {
            return redirect()->back()->withErrors(['conflict' => 'This exact schedule already exists.']);
        }
        $schedule->update($request->all());
        return redirect()->back()->with('status', 'Schedule updated!');
    }
    // System report export (admin only)
    public function exportSystemReport()
    {
        $users = \App\Models\User::all();
        $schedules = Schedule::with(['subject', 'teacher', 'room'])->get();
        $rooms = \App\Models\Room::all();
        $teachers = \App\Models\Teacher::all();
        $subjects = \App\Models\Subject::all();
        $logs = \App\Models\ActivityLog::orderBy('created_at', 'desc')->limit(100)->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('exports.system_report', compact('users','schedules','rooms','teachers','subjects','logs'));
        return $pdf->download('system_report.pdf');
    }
    public function exportCsv()
    {
        $schedules = Schedule::with(['subject', 'teacher', 'room'])->get();
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="schedules.csv"',
        ];
        $callback = function() use ($schedules) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Subject', 'Teacher', 'Room', 'Day', 'Start Time', 'End Time']);
            foreach ($schedules as $s) {
                fputcsv($handle, [
                    $s->subject->name ?? '',
                    $s->teacher->name ?? '',
                    $s->room->name ?? '',
                    $s->day,
                    $s->start_time,
                    $s->end_time
                ]);
            }
            fclose($handle);
        };
        return new \Symfony\Component\HttpFoundation\StreamedResponse($callback, 200, $headers);
    }
    public function exportPdf()
    {
        if (!class_exists('Barryvdh\\DomPDF\\Facade\\Pdf')) {
            abort(501, 'PDF export not available. Please install barryvdh/laravel-dompdf.');
        }
        $schedules = Schedule::with(['subject', 'teacher', 'room'])->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('exports.schedules', ['schedules' => $schedules]);
        return $pdf->download('schedules.pdf');
    }
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();
        return redirect()->back()->with('status', 'Schedule deleted!');
    }
}
