<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Déclare les alias de middleware utilisables dans les routes
        $middleware->alias([
            'role'                  => \App\Http\Middleware\CheckRole::class,
            'force.password.change' => \App\Http\Middleware\ForcePasswordChange::class,
        ]);

        // Applique le ForcePasswordChange sur toutes les routes web
        // Redirige automatiquement vers /change-password si must_change_password = true
        $middleware->appendToGroup('web', \App\Http\Middleware\ForcePasswordChange::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();