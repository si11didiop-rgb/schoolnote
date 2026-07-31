<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentController extends Controller
{
    /**
     * Affiche le tableau de bord avec la liste des enfants du parent connecté
     */
    public function dashboard()
    {
        $enfants = Auth::user()->enfants;

        return view('parent.dashboard', compact('enfants'));
    }

    /**
     * Affiche la liste des notes d'un enfant donné
     */
    public function notes(User $enfant)
    {
        $this->verifierAppartenance($enfant);

        $notes = $enfant->consulterNotes()->load('evaluation.enseigner.matiere');

        return view('parent.notes', compact('enfant', 'notes'));
    }

    /**
     * Affiche le bulletin d'un enfant donné, pour un semestre précis
     * Uniquement si l'admin a autorisé la publication pour cette classe
     */
    public function bulletin(Request $request, User $enfant)
    {
        $this->verifierAppartenance($enfant);

        $semestre = (int) $request->get('semestre', 1);

        // Vérifie si l'admin a publié les bulletins pour ce semestre
        $publie = $enfant->classe?->bulletinsPublies($semestre) ?? false;

        if (! $publie) {
            return view('parent.bulletin', [
                'enfant' => $enfant,
                'semestre' => $semestre,
                'publie' => false,
                'complet' => false,
                'moyennesParMatiere' => collect(),
                'moyenneGenerale' => null,
                'rang' => null,
            ]);
        }

        $complet = $enfant->bulletinComplet($semestre);

        $moyennesParMatiere = $complet ? $enfant->moyennesParMatiere($semestre) : collect();
        $moyenneGenerale = $complet ? $enfant->consulterMoyenne($semestre) : null;
        $rang = $complet ? $enfant->rangDansLaClasse($semestre) : null;

        return view('parent.bulletin', compact(
            'enfant',
            'moyennesParMatiere',
            'moyenneGenerale',
            'semestre',
            'complet',
            'rang',
            'publie'
        ));
    }

    /**
     * Vérifie que cet élève est bien un enfant du parent connecté
     * Bloque l'accès sinon (sécurité contre la manipulation d'URL)
     */
    private function verifierAppartenance(User $enfant): void
    {
        if ($enfant->parent_id !== Auth::id()) {
            abort(403, 'Cet élève n\'est pas votre enfant.');
        }
    }
}