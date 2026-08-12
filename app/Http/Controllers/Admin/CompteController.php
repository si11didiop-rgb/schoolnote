<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CompteCreeMail;
use App\Models\Classe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class CompteController extends Controller
{
    /**
     * Affiche la liste de tous les comptes
     */
    public function index()
    {
        $users = User::orderBy('role')->orderBy('nom')->get();

        return view('admin.comptes.index', compact('users'));
    }

    /**
     * Affiche le formulaire de création d'un compte
     */
    public function create()
    {
        $classes = Classe::orderBy('nom')->get();
        $parents = User::where('role', 'parent')->orderBy('nom')->get();

        return view('admin.comptes.create', compact('classes', 'parents'));
    }

    /**
     * Enregistre un nouveau compte en base
     * Vérifie que la classe n'est pas complète avant d'y inscrire un élève
     * Envoie un email de bienvenue avec les identifiants
     */
    public function store(Request $request)
    {
        $validated = $this->validerCompte($request);

        // Vérification de l'effectif max si c'est un élève
        if ($validated['role'] === 'eleve' && isset($validated['classe_id'])) {
            $classe = Classe::find($validated['classe_id']);
            if ($classe && $classe->estComplete()) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'classe_id' => "La classe {$classe->nom} est complète ({$classe->effectif_max} élèves max).",
                    ]);
            }
        }

        // On garde le mot de passe en clair AVANT de le chiffrer
        // car on en a besoin pour l'envoyer par email
        $motDePasseEnClair = $validated['password'];

        $validated['password']             = bcrypt($validated['password']);
        $validated['must_change_password'] = true;

        $user = User::create($validated);

        // Envoi de l'email de bienvenue avec les identifiants (via Queue)
        Mail::to($user->email)
            ->queue(new CompteCreeMail($user, $motDePasseEnClair));

        return redirect()->route('admin.comptes.index')
            ->with('success', 'Compte créé avec succès. Un email de bienvenue a été envoyé à ' . $user->email . '.');
    }

    /**
     * Affiche le formulaire de modification d'un compte
     */
    public function edit(User $compte)
    {
        $classes = Classe::orderBy('nom')->get();
        $parents = User::where('role', 'parent')->orderBy('nom')->get();

        return view('admin.comptes.edit', [
            'user'    => $compte,
            'classes' => $classes,
            'parents' => $parents,
        ]);
    }

    /**
     * Met à jour un compte existant
     */
    public function update(Request $request, User $compte)
    {
        $validated = $this->validerCompte($request, $compte->id);

        // Vérification effectif max si changement de classe pour un élève
        if (
            $validated['role'] === 'eleve' &&
            isset($validated['classe_id']) &&
            $validated['classe_id'] != $compte->classe_id
        ) {
            $classe = Classe::find($validated['classe_id']);
            if ($classe && $classe->estComplete()) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'classe_id' => "La classe {$classe->nom} est complète ({$classe->effectif_max} élèves max).",
                    ]);
            }
        }

        // Le mot de passe n'est mis à jour que s'il a été renseigné
        if (! empty($validated['password'])) {
            $validated['password']             = bcrypt($validated['password']);
            $validated['must_change_password'] = true;
        } else {
            unset($validated['password']);
        }

        $compte->update($validated);

        return redirect()->route('admin.comptes.index')
            ->with('success', 'Compte modifié avec succès.');
    }

    /**
     * Supprime un compte
     */
    public function destroy(User $compte)
    {
        $compte->delete();

        return redirect()->route('admin.comptes.index')
            ->with('success', 'Compte supprimé avec succès.');
    }

    /**
     * Règles de validation communes pour create() et update()
     */
    private function validerCompte(Request $request, ?int $ignoreId = null): array
    {
        $isUpdate = $ignoreId !== null;

        // Vérifie qu'il n'y a pas déjà un administrateur
        if ($request->role === 'administrateur') {
            $adminExistant = User::where('role', 'administrateur')
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists();

            if ($adminExistant) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'role' => 'Il ne peut y avoir qu\'un seul administrateur dans le système.',
                ]);
            }
        }

        return $request->validate([
            'nom'    => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'genre'  => 'nullable|in:M,F',
            'email'  => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($ignoreId),
            ],
            'password'  => $isUpdate ? 'nullable|min:8' : 'required|min:8',
            'role'      => 'required|in:administrateur,enseignant,eleve,parent',

            'date_de_naissance' => [
                'required_if:role,eleve',
                'nullable',
                'date',
                'before:' . now()->subYears(10)->format('Y-m-d'),
                'after:'  . now()->subYears(20)->format('Y-m-d'),
            ],

            'classe_id'    => 'required_if:role,eleve|nullable|exists:classes,id',
            'parent_id'    => 'nullable|exists:users,id',
            'specialite'   => 'required_if:role,enseignant|nullable|string|max:255',
            'lien_parente' => 'required_if:role,parent|nullable|string|max:255',
        ], [
            'date_de_naissance.required_if' => 'La date de naissance est obligatoire pour un élève.',
            'date_de_naissance.before'      => 'L\'élève doit avoir au moins 10 ans.',
            'date_de_naissance.after'       => 'L\'élève ne peut pas avoir plus de 20 ans.',
            'classe_id.required_if'         => 'La classe est obligatoire pour un élève.',
            'specialite.required_if'        => 'La spécialité est obligatoire pour un enseignant.',
            'lien_parente.required_if'      => 'Le lien de parenté est obligatoire pour un parent.',
            'password.min'                  => 'Le mot de passe doit contenir au moins 8 caractères.',
            'email.unique'                  => 'Cette adresse email est déjà utilisée.',
        ]);
    }
}