<?php
namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RoomController extends Controller
{
    public function index(): Response
    {
        $rooms = Room::all();
        return Inertia::render('Admin/Rooms', ['rooms' => $rooms]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'nullable|integer',
            'status' => 'required|in:available,unavailable',
        ]);
        Room::create($request->all());
        return redirect()->back()->with('status', 'Room created!');
    }
    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        $room->update($request->all());
        return redirect()->back()->with('status', 'Room updated!');
    }
    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();
        return redirect()->back()->with('status', 'Room deleted!');
    }
}
