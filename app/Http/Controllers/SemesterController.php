<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $semesters = Semester::all();
            return response()->json(['semesters' => $semesters]);
        }
        return Inertia::render('Admin/Semesters');
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
        ]);
        Semester::create($request->all());
        return response()->json(['status' => 'Semester created!']);
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
        $semester = Semester::findOrFail($id);
        $semester->update($request->all());
        return response()->json(['status' => 'Semester updated!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $semester = Semester::findOrFail($id);
        $semester->delete();
        return response()->json(['status' => 'Semester deleted!']);
    }
}
