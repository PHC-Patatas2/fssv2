<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $user = \App\Models\User::where('email', $this->email)->first();
        $valid = $user && \Illuminate\Support\Facades\Hash::check($this->password, $user->password);

        if (! $user || ! $valid) {
            \Illuminate\Support\Facades\RateLimiter::hit($this->throttleKey());
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }
        if ($user->status === 'declined') {
            \Illuminate\Support\Facades\RateLimiter::hit($this->throttleKey());
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => 'Your registration has been declined by the admin. Please submit another registration if you find this a mistake.',
            ]);
        }
        if ($user->status === 'pending') {
            \Illuminate\Support\Facades\RateLimiter::hit($this->throttleKey());
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => 'Your account is pending approval. Please wait for admin approval.',
            ]);
        }
        if ($user->status !== 'approved') {
            \Illuminate\Support\Facades\RateLimiter::hit($this->throttleKey());
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => 'Your account is not approved. Please contact support.',
            ]);
        }

        $attempted = Auth::attempt($this->only('email', 'password'), $this->boolean('remember'));
        if (! $attempted) {
            \Illuminate\Support\Facades\RateLimiter::hit($this->throttleKey());
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 3)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
