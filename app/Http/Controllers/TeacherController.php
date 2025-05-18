<?php
namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TeacherController extends Controller
{
    public function index(): Response
    {
        $teachers = Teacher::all();
        return Inertia::render('Admin/Teachers', ['teachers' => $teachers]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email',
            'contact' => 'nullable|string|max:255',
        ]);
        Teacher::create($request->all());
        return redirect()->back()->with('status', 'Teacher created!');
    }
    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->update($request->all());
        return redirect()->back()->with('status', 'Teacher updated!');
    }
    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();
        return redirect()->back()->with('status', 'Teacher deleted!');
    }
}
