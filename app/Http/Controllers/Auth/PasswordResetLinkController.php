<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/ForgotPassword', [
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Check if email exists in users table
        $userExists = \App\Models\User::where('email', $request->email)->exists();
        if (!$userExists) {
            $status = 'This email is not registered.';
        } else {
            try {
                $result = \Illuminate\Support\Facades\Password::sendResetLink(
                    $request->only('email')
                );
                $status = $result === \Illuminate\Support\Facades\Password::RESET_LINK_SENT
                    ? 'Password reset email sent successfully.'
                    : 'Failed to send password reset email.';
            } catch (\Exception $e) {
                $status = 'Failed to send email: ' . $e->getMessage();
            }
        }

        // If AJAX or Inertia request, return JSON
        if ($request->expectsJson() || $request->header('X-Inertia')) {
            return response()->json(['status' => $status]);
        }

        // Otherwise, fallback to redirect (for non-AJAX)
        return back()->with('status', $status);
    }
}
