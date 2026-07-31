<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Matiere;
use Illuminate\Http\Request;

class MatiereController extends Controller
{
    /**
     * Affiche la liste de toutes les matières
     */
    public function index()
    {
        $matieres = Matiere::orderBy('nom')->get();

        return view('admin.matieres.index', compact('matieres'));
    }

    /**
     * Affiche le formulaire de création d'une matière
     */
    public function create()
    {
        return view('admin.matieres.create');
    }

    /**
     * Enregistre une nouvelle matière en base
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'coefficient' => 'required|integer|min:1|max:20',
        ]);

        Matiere::create($validated);

        return redirect()->route('admin.matieres.index')
            ->with('success', 'Matière créée avec succès.');
    }

    /**
     * Affiche le formulaire de modification d'une matière
     */
    public function edit(Matiere $matiere)
    {
        return view('admin.matieres.edit', compact('matiere'));
    }

    /**
     * Met à jour une matière existante
     */
    public function update(Request $request, Matiere $matiere)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'coefficient' => 'required|integer|min:1|max:20',
        ]);

        $matiere->update($validated);

        return redirect()->route('admin.matieres.index')
            ->with('success', 'Matière modifiée avec succès.');
    }

    /**
     * Supprime une matière
     */
    public function destroy(Matiere $matiere)
    {
        $matiere->delete();

        return redirect()->route('admin.matieres.index')
            ->with('success', 'Matière supprimée avec succès.');
    }
}