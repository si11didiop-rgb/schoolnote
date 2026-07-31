<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ChangePasswordController extends Controller
{
    /**
     * Affiche le formulaire de changement de mot de passe obligatoire
     * Redirige vers le dashboard si le changement n'est pas requis
     */
    public function index()
    {
        if (! Auth::user()->must_change_password) {
            return redirect()->route('dashboard');
        }

        return view('auth.change-password');
    }

    /**
     * Traite le changement de mot de passe obligatoire
     * - Valide la force du mot de passe
     * - Met à jour le mot de passe
     * - Désactive le flag must_change_password
     * - Redirige vers le bon espace
     */
    public function store(Request $request)
    {
        $request->validate([
            'password' => [
                'required',
                'confirmed',
                // Mot de passe fort : min 8 caractères, majuscule, chiffre, symbole
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ], [
            'password.required'  => 'Le mot de passe est obligatoire.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'password.min'       => 'Le mot de passe doit contenir au moins 8 caractères.',
        ]);

        $user = Auth::user();

        // Met à jour le mot de passe et désactive l'obligation de changement
        $user->update([
            'password'             => Hash::make($request->password),
            'must_change_password' => false,
        ]);

        // Redirige vers le bon espace selon le rôle
        return match ($user->role) {
            'administrateur' => redirect()->route('admin.dashboard')
                ->with('success', 'Mot de passe mis à jour avec succès. Bienvenue sur SchoolNote !'),
            'enseignant' => redirect()->route('enseignant.dashboard')
                ->with('success', 'Mot de passe mis à jour avec succès. Bienvenue sur SchoolNote !'),
            'eleve' => redirect()->route('eleve.dashboard')
                ->with('success', 'Mot de passe mis à jour avec succès. Bienvenue sur SchoolNote !'),
            'parent' => redirect()->route('parent.dashboard')
                ->with('success', 'Mot de passe mis à jour avec succès. Bienvenue sur SchoolNote !'),
            default => redirect()->route('dashboard'),
        };
    }
}