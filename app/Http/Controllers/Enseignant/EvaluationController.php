<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use App\Mail\EvaluationPlanifieMail;
use App\Models\Enseigner;
use App\Models\Evaluation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EvaluationController extends Controller
{
    /**
     * Affiche la liste des évaluations créées par l'enseignant connecté,
     * séparées entre évaluations à venir et évaluations passées
     */
    public function index()
    {
        $evaluations = Evaluation::whereHas('enseigner', function ($query) {
            $query->where('enseignant_id', Auth::id());
        })->with('enseigner.matiere', 'enseigner.classe')->get();

        $aujourdHui = now()->startOfDay();

        $evaluationsAVenir = $evaluations
            ->filter(fn ($evaluation) => $evaluation->date_evaluation->greaterThanOrEqualTo($aujourdHui))
            ->sortBy('date_evaluation');

        $evaluationsPassees = $evaluations
            ->filter(fn ($evaluation) => $evaluation->date_evaluation->lessThan($aujourdHui))
            ->sortByDesc('date_evaluation');

        return view('enseignant.evaluations.index', compact('evaluationsAVenir', 'evaluationsPassees'));
    }

    /**
     * Affiche le formulaire de création d'une évaluation
     */
    public function create()
    {
        $enseignements = Enseigner::where('enseignant_id', Auth::id())
            ->with('matiere', 'classe')
            ->get();

        return view('enseignant.evaluations.create', compact('enseignements'));
    }

    /**
     * Enregistre une nouvelle évaluation en base
     * et envoie une notification email à tous les élèves de la classe
     * Les emails sont envoyés en arrière-plan via Laravel Queue
     */
    public function store(Request $request)
    {
        $validated = $this->validerEvaluation($request);

        // Vérifie que l'affectation appartient bien à cet enseignant
        $appartientAEnseignant = Enseigner::where('id', $validated['enseigner_id'])
            ->where('enseignant_id', Auth::id())
            ->exists();

        if (! $appartientAEnseignant) {
            abort(403, 'Cette affectation ne vous appartient pas.');
        }

        $evaluation = Evaluation::create($validated);
        $evaluation->load('enseigner.matiere', 'enseigner.classe');

        // Récupère tous les élèves de la classe
        $eleves = User::where('role', 'eleve')
            ->where('classe_id', $evaluation->enseigner->classe_id)
            ->get();

       // Envoie un email personnalisé à chaque élève via Queue
        // Délai de 3 secondes entre chaque email (limite Mailtrap plan gratuit)
        foreach ($eleves as $index => $eleve) {
            Mail::to($eleve->email)
                ->later(now()->addSeconds($index * 10), new EvaluationPlanifieMail($eleve, $evaluation));
        }

        return redirect()->route('enseignant.evaluations.index')
            ->with('success', 'Évaluation créée. ' . $eleves->count() . ' élève(s) seront notifiés par email.');
    }

    /**
     * Affiche le formulaire de modification d'une évaluation
     */
    public function edit(Evaluation $evaluation)
    {
        $this->verifierAppartenance($evaluation);

        $enseignements = Enseigner::where('enseignant_id', Auth::id())
            ->with('matiere', 'classe')
            ->get();

        return view('enseignant.evaluations.edit', compact('evaluation', 'enseignements'));
    }

    /**
     * Met à jour une évaluation existante
     */
    public function update(Request $request, Evaluation $evaluation)
    {
        $this->verifierAppartenance($evaluation);

        $validated = $this->validerEvaluation($request);

        $appartientAEnseignant = Enseigner::where('id', $validated['enseigner_id'])
            ->where('enseignant_id', Auth::id())
            ->exists();

        if (! $appartientAEnseignant) {
            abort(403, 'Cette affectation ne vous appartient pas.');
        }

        $evaluation->update($validated);

        return redirect()->route('enseignant.evaluations.index')
            ->with('success', 'Évaluation modifiée avec succès.');
    }

    /**
     * Supprime une évaluation
     */
    public function destroy(Evaluation $evaluation)
    {
        $this->verifierAppartenance($evaluation);

        $evaluation->delete();

        return redirect()->route('enseignant.evaluations.index')
            ->with('success', 'Évaluation supprimée avec succès.');
    }

    /**
     * Règles de validation communes pour store() et update()
     * - Jour de semaine uniquement (lundi à vendredi)
     * - Heures entre 07h30 et 18h00
     * - Carbon::parse() utilisé pour accepter H:i et H:i:s
     */
    private function validerEvaluation(Request $request): array
    {
        return $request->validate([
            'enseigner_id' => 'required|exists:enseigner,id',
            'type'         => 'required|string|max:255',
            'titre'        => 'required|string|max:255',

            // La date doit être un jour de semaine (lundi à vendredi)
            'date_evaluation' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $jour = Carbon::parse($value)->dayOfWeek;
                    if ($jour === 0 || $jour === 6) {
                        $fail('Les évaluations ne peuvent pas avoir lieu le week-end (samedi ou dimanche).');
                    }
                },
            ],

            // Heure de début : entre 07h30 et 17h00
            'heure_debut' => [
                'required',
                function ($attribute, $value, $fail) {
                    $heure = Carbon::parse($value);
                    $min   = Carbon::parse('07:30');
                    $max   = Carbon::parse('17:00');
                    if ($heure->lt($min) || $heure->gt($max)) {
                        $fail('L\'heure de début doit être entre 07h30 et 17h00.');
                    }
                },
            ],

            // Heure de fin : après heure_debut et avant 18h00
            'heure_fin' => [
                'required',
                'after:heure_debut',
                function ($attribute, $value, $fail) {
                    $heure = Carbon::parse($value);
                    $max   = Carbon::parse('18:00');
                    if ($heure->gt($max)) {
                        $fail('L\'heure de fin ne peut pas dépasser 18h00.');
                    }
                },
            ],

            'semestre' => 'required|integer|in:1,2',
        ], [
            'heure_fin.after' => 'L\'heure de fin doit être après l\'heure de début.',
        ]);
    }

    /**
     * Vérifie que l'évaluation appartient bien à l'enseignant connecté
     * Bloque l'accès sinon (sécurité contre la manipulation d'URL)
     */
    private function verifierAppartenance(Evaluation $evaluation): void
    {
        if ($evaluation->enseigner->enseignant_id !== Auth::id()) {
            abort(403, 'Cette évaluation ne vous appartient pas.');
        }
    }
}