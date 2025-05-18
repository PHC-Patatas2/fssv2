<?php

namespace App\Http\Controllers;

use App\Models\TeacherQualification;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TeacherQualificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $qualifications = TeacherQualification::all();
            return response()->json(['teacher_qualifications' => $qualifications]);
        }
        return Inertia::render('Admin/TeacherQualifications');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        TeacherQualification::create($request->all());
        return response()->json(['status' => 'Qualification created!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $qualification = TeacherQualification::findOrFail($id);
        $qualification->update($request->all());
        return response()->json(['status' => 'Qualification updated!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $qualification = TeacherQualification::findOrFail($id);
        $qualification->delete();
        return response()->json(['status' => 'Qualification deleted!']);
    }
}
