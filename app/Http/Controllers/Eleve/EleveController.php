<?php

namespace App\Http\Controllers\Eleve;

use App\Http\Controllers\Controller;
use App\Models\Appreciation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EleveController extends Controller
{
    /**
     * Affiche la liste des notes de l'élève connecté
     */
    public function notes()
    {
        $notes = Auth::user()->consulterNotes()->load('evaluation.enseigner.matiere');

        return view('eleve.notes', compact('notes'));
    }

    /**
     * Affiche les évaluations de l'élève, séparées entre à venir et passées
     */
    public function evaluations()
    {
        $evaluations = Auth::user()->consulterEvaluations()
            ->load('enseigner.matiere', 'enseigner.classe');

        $aujourdHui = now()->startOfDay();

        $evaluationsAVenir = $evaluations
            ->filter(fn ($e) => $e->date_evaluation->greaterThanOrEqualTo($aujourdHui))
            ->sortBy('date_evaluation');

        $evaluationsPassees = $evaluations
            ->filter(fn ($e) => $e->date_evaluation->lessThan($aujourdHui))
            ->sortByDesc('date_evaluation');

        return view('eleve.evaluations', compact('evaluationsAVenir', 'evaluationsPassees'));
    }

    /**
     * Affiche le bulletin de l'élève pour un semestre donné
     * Uniquement si l'admin a autorisé la publication pour cette classe
     */
    public function bulletin(Request $request)
    {
        $semestre = (int) $request->get('semestre', 1);
        $eleve    = Auth::user();

        // Vérifie si l'admin a publié les bulletins pour ce semestre
        $publie = $eleve->classe?->bulletinsPublies($semestre) ?? false;

        if (! $publie) {
            return view('eleve.bulletin', [
                'semestre'           => $semestre,
                'publie'             => false,
                'complet'            => false,
                'moyennesParMatiere' => collect(),
                'moyenneGenerale'    => null,
                'rang'               => null,
                'appreciations'      => collect(),
            ]);
        }

        $complet = $eleve->bulletinComplet($semestre);

        $moyennesParMatiere = $complet ? $eleve->moyennesParMatiere($semestre) : collect();
        $moyenneGenerale    = $complet ? $eleve->consulterMoyenne($semestre) : null;
        $rang               = $complet ? $eleve->rangDansLaClasse($semestre) : null;

        // Récupère les appréciations des enseignants pour ce semestre
        // indexées par matiere_id pour faciliter l'affichage
        $appreciations = $complet
            ? Appreciation::where('eleve_id', $eleve->id)
                ->where('semestre', $semestre)
                ->with('enseigner.matiere')
                ->get()
                ->keyBy(fn ($a) => $a->enseigner->matiere->id)
            : collect();

        return view('eleve.bulletin', compact(
            'moyennesParMatiere',
            'moyenneGenerale',
            'semestre',
            'complet',
            'rang',
            'publie',
            'appreciations'
        ));
    }

    /**
     * Génère et télécharge le bulletin au format PDF
     * Uniquement si l'admin a autorisé la publication
     */
    public function bulletinPdf(Request $request)
    {
        $semestre = (int) $request->get('semestre', 1);
        $eleve    = Auth::user();

        if (! $eleve->classe?->bulletinsPublies($semestre)) {
            abort(403, 'Le bulletin n\'est pas encore disponible pour ce semestre.');
        }

        if (! $eleve->bulletinComplet($semestre)) {
            abort(403, 'Le bulletin n\'est pas encore complet pour ce semestre.');
        }

        $moyennesParMatiere = $eleve->moyennesParMatiere($semestre);
        $moyenneGenerale    = $eleve->consulterMoyenne($semestre);
        $rang               = $eleve->rangDansLaClasse($semestre);

        // Appréciations pour le PDF
        $appreciations = Appreciation::where('eleve_id', $eleve->id)
            ->where('semestre', $semestre)
            ->with('enseigner.matiere')
            ->get()
            ->keyBy(fn ($a) => $a->enseigner->matiere->id);

        $pdf = Pdf::loadView('eleve.bulletin-pdf', compact(
            'eleve',
            'moyennesParMatiere',
            'moyenneGenerale',
            'semestre',
            'rang',
            'appreciations'
        ));

        return $pdf->download("bulletin-semestre-{$semestre}.pdf");
    }
}