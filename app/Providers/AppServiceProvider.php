<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }

    /**
     * Get the shared props for Inertia.
     */
    public function share(): array
    {
        return [
            'auth' => [
                'user' => Auth::user(),
            ],
            'csrf_token' => csrf_token(),
        ];
    }
}
