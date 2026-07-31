<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    /**
     * Vérifie si l'utilisateur doit changer son mot de passe
     * Si oui, le redirige vers la page de changement de mot de passe
     * avant de pouvoir accéder à n'importe quelle autre page
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (
            Auth::check() &&
            Auth::user()->must_change_password &&
            ! $request->routeIs('password.change') &&
            ! $request->routeIs('password.change.store') &&
            ! $request->routeIs('logout')
        ) {
            return redirect()->route('password.change');
        }

        return $next($request);
    }
}