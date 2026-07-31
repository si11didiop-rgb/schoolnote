<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Vérifie que l'utilisateur connecté a bien le rôle requis
     * pour accéder à cette route.
     *
     * Utilisation dans les routes : ->middleware('role:administrateur')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Si l'utilisateur n'est pas connecté, on le renvoie à la connexion
        if (! $request->user()) {
            return redirect()->route('login');
        }

        // Si le rôle de l'utilisateur n'est pas dans la liste des rôles autorisés
        if (! in_array($request->user()->role, $roles)) {
            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }
}