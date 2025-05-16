<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $existing = User::where('email', $request->email)->first();
        if ($existing) {
            if ($existing->status === 'pending') {
                // Always show generic pending message, do not reveal password mismatch
                return redirect()->route('login')->with('status', 'You already have a pending registration. Please wait for admin approval.');
            } elseif ($existing->status === 'approved') {
                return redirect()->route('login')->with('status', 'An account with this email already exists.');
            } elseif ($existing->status === 'declined') {
                // Allow declined users to re-register: update their info and set to pending
                $existing->name = $request->name;
                $existing->password = Hash::make($request->password);
                $existing->status = 'pending';
                $existing->save();
                event(new Registered($existing));
                return redirect()->route('login')->with('status', 'Your new registration has been submitted and is pending admin approval.');
            } else {
                return redirect()->route('login')->with('status', 'An account with this email already exists.');
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'scheduler',
            'status' => 'pending',
        ]);

        event(new Registered($user));

        return redirect()->route('login')->with('status', 'Your account is pending approval by an admin.');
    }
}
