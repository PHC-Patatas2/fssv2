<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MajorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $majors = Major::with('course')->get();
            return response()->json(['majors' => $majors]);
        }
        return Inertia::render('Admin/Majors');
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
            'course_id' => 'required|exists:courses,id',
        ]);
        Major::create($request->all());
        return response()->json(['status' => 'Major created!']);
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
    public function update(Request $request, $id)
    {
        $major = Major::findOrFail($id);
        $major->update($request->all());
        return response()->json(['status' => 'Major updated!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $major = Major::findOrFail($id);
        $major->delete();
        return response()->json(['status' => 'Major deleted!']);
    }
}
