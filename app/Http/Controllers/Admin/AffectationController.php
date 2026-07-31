<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AffectationCreeMail;
use App\Models\Classe;
use App\Models\Enseigner;
use App\Models\Matiere;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AffectationController extends Controller
{
    /**
     * Affiche la liste de toutes les affectations
     */
    public function index()
    {
        // with() charge les relations en une seule requête (évite le N+1)
        $affectations = Enseigner::with(['enseignant', 'matiere', 'classe'])->get();

        return view('admin.affectations.index', compact('affectations'));
    }

    /**
     * Affiche le formulaire de création d'une affectation
     */
    public function create()
    {
        $enseignants = User::where('role', 'enseignant')->orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        $classes = Classe::orderBy('nom')->get();

        return view('admin.affectations.create', compact('enseignants', 'matieres', 'classes'));
    }

    /**
     * Enregistre une nouvelle affectation en base
     * et envoie un email de notification à l'enseignant
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'enseignant_id' => 'required|exists:users,id',
            'matiere_id'    => 'required|exists:matiere_scolaire,id',
            'classe_id'     => 'required|exists:classes,id',
        ]);

        // Empêche les doublons
        $existe = Enseigner::where($validated)->exists();

        if ($existe) {
            return back()->withErrors([
                'matiere_id' => 'Cette affectation existe déjà.',
            ])->withInput();
        }

        $affectation = Enseigner::create($validated);

        // Charge les relations nécessaires pour l'email
        $affectation->load('matiere', 'classe');

        // Envoi email de notification à l'enseignant
        $enseignant = User::find($validated['enseignant_id']);
        Mail::to($enseignant->email)
            ->send(new AffectationCreeMail($enseignant, $affectation));

        return redirect()->route('admin.affectations.index')
            ->with('success', 'Affectation créée. Un email a été envoyé à ' . $enseignant->email . '.');
    }

    /**
     * Affiche le formulaire de modification d'une affectation
     */
    public function edit(Enseigner $affectation)
    {
        $enseignants = User::where('role', 'enseignant')->orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();
        $classes = Classe::orderBy('nom')->get();

        return view('admin.affectations.edit', compact('affectation', 'enseignants', 'matieres', 'classes'));
    }

    /**
     * Met à jour une affectation existante
     */
    public function update(Request $request, Enseigner $affectation)
    {
        $validated = $request->validate([
            'enseignant_id' => 'required|exists:users,id',
            'matiere_id'    => 'required|exists:matiere_scolaire,id',
            'classe_id'     => 'required|exists:classes,id',
        ]);

        $affectation->update($validated);

        return redirect()->route('admin.affectations.index')
            ->with('success', 'Affectation modifiée avec succès.');
    }

    /**
     * Supprime une affectation
     */
    public function destroy(Enseigner $affectation)
    {
        $affectation->delete();

        return redirect()->route('admin.affectations.index')
            ->with('success', 'Affectation supprimée avec succès.');
    }
}