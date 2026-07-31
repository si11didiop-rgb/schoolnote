<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Affiche la page de connexion
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Traite la tentative de connexion
     * - Rate limiting intégré dans LoginRequest (5 tentatives max)
     * - Régénération de session (protection contre la fixation de session)
     * - Redirection selon le rôle
     * - Vérification si changement de mot de passe obligatoire
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authentification (avec rate limiting intégré)
        $request->authenticate();

        // Régénération de la session (sécurité anti-fixation de session)
        $request->session()->regenerate();

        $user = Auth::user();

        // Si l'utilisateur doit changer son mot de passe au premier login
        if ($user->must_change_password) {
            return redirect()->route('password.change');
        }

        // Redirection vers le bon espace selon le rôle
        return match ($user->role) {
            'administrateur' => redirect()->route('admin.dashboard'),
            'enseignant'     => redirect()->route('enseignant.dashboard'),
            'eleve'          => redirect()->route('eleve.dashboard'),
            'parent'         => redirect()->route('parent.dashboard'),
            default          => redirect()->route('dashboard'),
        };
    }

    /**
     * Déconnecte l'utilisateur
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}