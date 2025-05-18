<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Year;
use App\Models\Semester;
use App\Models\Major;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CurriculumController extends Controller
{
    // Fetch assigned and available subjects for a curriculum combination
    public function index(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'year_id' => 'required|exists:years,id',
            'semester_id' => 'required|exists:semesters,id',
            'major_id' => 'nullable|exists:majors,id',
        ]);
        $query = DB::table('curricula')
            ->where('course_id', $validated['course_id'])
            ->where('year_id', $validated['year_id'])
            ->where('semester_id', $validated['semester_id']);
        if ($request->major_id) {
            $query->where('major_id', $validated['major_id']);
        } else {
            $query->whereNull('major_id');
        }
        $subjectIds = $query->pluck('subject_id');
        $subjects = Subject::whereIn('id', $subjectIds)->get();
        $availableSubjects = Subject::whereNotIn('id', $subjectIds)->get();
        return response()->json([
            'subjects' => $subjects,
            'availableSubjects' => $availableSubjects,
        ]);
    }
    // Assign a subject to a curriculum combination
    public function assign(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'year_id' => 'required|exists:years,id',
            'semester_id' => 'required|exists:semesters,id',
            'major_id' => 'nullable|exists:majors,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);
        DB::table('curricula')->updateOrInsert([
            'course_id' => $validated['course_id'],
            'year_id' => $validated['year_id'],
            'semester_id' => $validated['semester_id'],
            'major_id' => $validated['major_id'],
            'subject_id' => $validated['subject_id'],
        ], []);
        return response()->json(['status' => 'Subject assigned to curriculum.']);
    }
    // Remove a subject from a curriculum combination
    public function remove(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'year_id' => 'required|exists:years,id',
            'semester_id' => 'required|exists:semesters,id',
            'major_id' => 'nullable|exists:majors,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);
        DB::table('curricula')->where([
            'course_id' => $validated['course_id'],
            'year_id' => $validated['year_id'],
            'semester_id' => $validated['semester_id'],
            'major_id' => $validated['major_id'],
            'subject_id' => $validated['subject_id'],
        ])->delete();
        return response()->json(['status' => 'Subject removed from curriculum.']);
    }
}
