<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserApprovalController extends Controller
{
    public function index(): Response
    {
        $pendingUsers = User::where('status', 'pending')->get();
        return Inertia::render('Admin/UserApprovals', [
            'pendingUsers' => $pendingUsers,
            'csrf_token' => csrf_token(),
        ]);
    }

    public function approve($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->status = 'approved';
        $user->save();
        return back()->with('status', 'User approved.');
    }

    public function decline($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->status = 'declined';
        $user->save();
        return back()->with('status', 'User declined.');
    }
}
