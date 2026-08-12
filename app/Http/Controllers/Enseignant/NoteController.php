<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use App\Mail\NoteDisponibleMail;
use App\Models\Appreciation;
use App\Models\Evaluation;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class NoteController extends Controller
{
    /**
     * Affiche le formulaire de saisie des notes pour une évaluation donnée
     * Liste tous les élèves de la classe concernée, avec leur note actuelle si elle existe
     */
    public function edit(Evaluation $evaluation)
    {
        $this->verifierAppartenance($evaluation);

        $eleves = User::where('role', 'eleve')
            ->where('classe_id', $evaluation->enseigner->classe_id)
            ->orderBy('nom')
            ->get();

        // Récupère les notes déjà saisies pour cette évaluation, indexées par eleve_id
        $notesExistantes = Note::where('evaluation_id', $evaluation->id)
            ->get()
            ->keyBy('eleve_id');

        // Récupère les appréciations existantes pour ce semestre, indexées par eleve_id
        $appreciationsExistantes = Appreciation::where('enseigner_id', $evaluation->enseigner_id)
            ->where('semestre', $evaluation->semestre)
            ->get()
            ->keyBy('eleve_id');

        return view('enseignant.notes.edit', compact(
            'evaluation',
            'eleves',
            'notesExistantes',
            'appreciationsExistantes'
        ));
    }

    /**
     * Enregistre ou met à jour les notes et appréciations de tous les élèves
     * Envoie une notification email à chaque élève et son parent avec délai progressif
     */
    public function update(Request $request, Evaluation $evaluation)
    {
        $this->verifierAppartenance($evaluation);

        $validated = $request->validate([
            'notes'           => 'required|array',
            'notes.*'         => 'nullable|numeric|min:0|max:20',
            'appreciations'   => 'nullable|array',
            'appreciations.*' => 'nullable|string|max:500',
        ]);

        $evaluation->load('enseigner.matiere');

        // Délai progressif pour éviter de dépasser la limite SMTP
        $delai = 0;

        foreach ($validated['notes'] as $eleveId => $valeur) {
            // On ignore les champs laissés vides (élève pas encore noté)
            if ($valeur === null || $valeur === '') {
                continue;
            }

            // Crée ou met à jour la note
            $note = Note::updateOrCreate(
                [
                    'eleve_id'      => $eleveId,
                    'evaluation_id' => $evaluation->id,
                ],
                [
                    'valeur'         => $valeur,
                    'date_de_saisie' => now()->toDateString(),
                ]
            );

            // Sauvegarde l'appréciation si elle est renseignée
            $appreciation = $validated['appreciations'][$eleveId] ?? null;
            if ($appreciation && trim($appreciation) !== '') {
                Appreciation::updateOrCreate(
                    [
                        'enseigner_id' => $evaluation->enseigner_id,
                        'eleve_id'     => $eleveId,
                        'semestre'     => $evaluation->semestre,
                    ],
                    [
                        'appreciation' => trim($appreciation),
                    ]
                );
            }

            // Charge les relations nécessaires pour l'email
            $note->load('evaluation.enseigner.matiere');

            $eleve = User::find($eleveId);

            if ($eleve) {
                // Notification à l'élève avec délai progressif
                Mail::to($eleve->email)
                    ->later(now()->addSeconds($delai), new NoteDisponibleMail($eleve, $eleve, $note));
                $delai += 5;

                // Notification au parent si existant
                if ($eleve->parent_id) {
                    $parent = User::find($eleve->parent_id);
                    if ($parent) {
                        Mail::to($parent->email)
                            ->later(now()->addSeconds($delai), new NoteDisponibleMail($parent, $eleve, $note));
                        $delai += 5;
                    }
                }
            }
        }

        return redirect()->route('enseignant.evaluations.index')
            ->with('success', 'Notes et appréciations enregistrées. Les élèves et parents ont été notifiés par email.');
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