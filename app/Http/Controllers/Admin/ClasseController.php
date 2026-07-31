<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\User;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    /**
     * Affiche la liste de toutes les classes
     */
    public function index()
    {
        $classes = Classe::orderBy('nom')->get();

        return view('admin.classes.index', compact('classes'));
    }

    /**
     * Affiche le détail d'une classe : ses élèves, avec recherche et tri
     */
    public function show(Request $request, Classe $classe)
    {
        $recherche = $request->get('recherche');
        $tri = $request->get('tri', 'nom');

        $eleves = User::where('role', 'eleve')
            ->where('classe_id', $classe->id)
            ->when($recherche, function ($query) use ($recherche) {
                $query->where(function ($q) use ($recherche) {
                    $q->where('nom', 'like', "%{$recherche}%")
                      ->orWhere('prenom', 'like', "%{$recherche}%");
                });
            })
            ->orderBy($tri === 'genre' ? 'genre' : 'nom')
            ->get();

        return view('admin.classes.show', compact('classe', 'eleves', 'recherche', 'tri'));
    }

    /**
     * Affiche le formulaire de création d'une classe
     */
    public function create()
    {
        return view('admin.classes.create');
    }

    /**
     * Enregistre une nouvelle classe en base
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'niveau' => 'required|string|max:255',
            'annee_scolaire' => 'required|string|max:255',
        ]);

        Classe::create($validated);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Classe créée avec succès.');
    }

    /**
     * Affiche le formulaire de modification d'une classe
     */
    public function edit(Classe $classe)
    {
        return view('admin.classes.edit', compact('classe'));
    }

    /**
     * Met à jour une classe existante
     */
    public function update(Request $request, Classe $classe)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'niveau' => 'required|string|max:255',
            'annee_scolaire' => 'required|string|max:255',
        ]);

        $classe->update($validated);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Classe modifiée avec succès.');
    }

    /**
     * Supprime une classe
     */
    public function destroy(Classe $classe)
    {
        $classe->delete();

        return redirect()->route('admin.classes.index')
            ->with('success', 'Classe supprimée avec succès.');
    }
}