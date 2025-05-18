<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Year;
use App\Models\Major;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $sections = Section::with(['year', 'major'])->get();
            return response()->json(['sections' => $sections]);
        }
        return Inertia::render('Admin/Sections');
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
            'year_id' => 'required|exists:years,id',
            'major_id' => 'nullable|exists:majors,id',
        ]);
        Section::create($request->all());
        return response()->json(['status' => 'Section created!']);
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
        $section = Section::findOrFail($id);
        $section->update($request->all());
        return response()->json(['status' => 'Section updated!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $section = Section::findOrFail($id);
        $section->delete();
        return response()->json(['status' => 'Section deleted!']);
    }
}
