<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

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
        // Force HTTPS en production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Headers de sécurité HTTP sur toutes les réponses
        Response::macro('withSecurityHeaders', function ($response) {
            return $response
                ->header('X-Frame-Options', 'DENY')
                ->header('X-Content-Type-Options', 'nosniff')
                ->header('X-XSS-Protection', '1; mode=block')
                ->header('Referrer-Policy', 'strict-origin-when-cross-origin');
        });
    }
}