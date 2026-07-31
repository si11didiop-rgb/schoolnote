<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClasseController extends Controller
{
    /**
     * Affiche la liste des classes où l'enseignant connecté intervient
     */
    public function index()
    {
        $classes = Auth::user()->consulterClasses();

        return view('enseignant.classes.index', compact('classes'));
    }

    /**
     * Affiche le détail d'une classe : ses élèves, avec recherche et tri
     * Uniquement si l'enseignant intervient bien dans cette classe
     */
    public function show(Request $request, Classe $classe)
    {
        $this->verifierAppartenance($classe);

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

        return view('enseignant.classes.show', compact('classe', 'eleves', 'recherche', 'tri'));
    }

    /**
     * Vérifie que l'enseignant connecté intervient bien dans cette classe
     * Bloque l'accès sinon (sécurité contre la manipulation d'URL)
     */
    private function verifierAppartenance(Classe $classe): void
    {
        $intervient = $classe->enseignements()
            ->where('enseignant_id', Auth::id())
            ->exists();

        if (! $intervient) {
            abort(403, 'Vous n\'enseignez pas dans cette classe.');
        }
    }
}