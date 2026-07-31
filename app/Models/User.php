<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Les attributs qu'on peut remplir en masse (mass assignment)
     */
    protected $fillable = [
        'nom',
        'prenom',
        'genre',
        'email',
        'password',
        'role',
        'must_change_password',
        'date_de_naissance',
        'classe_id',
        'parent_id',
        'specialite',
        'lien_parente',
    ];

    /**
     * Les attributs cachés lors de la sérialisation
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les attributs à transformer (cast) en types PHP
     */
    protected function casts(): array
    {
        return [
            'email_verified_at'    => 'datetime',
            'date_de_naissance'    => 'date',
            'password'             => 'hashed',
            'must_change_password' => 'boolean',
        ];
    }

    /**
     * Recompose un "name" complet à partir de prenom + nom
     * Permet de garder {{ $user->name }} fonctionnel dans les vues Breeze
     */
    public function getNameAttribute(): string
    {
        return "{$this->prenom} {$this->nom}";
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function enfants()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    // ===================================================
    // Méthodes spécifiques au rôle ELEVE
    // ===================================================

    /**
     * Retourne toutes les notes de cet élève
     * Correspond à ConsulterNotes() dans le diagramme UML
     */
    public function consulterNotes()
    {
        return Note::where('eleve_id', $this->id)->get();
    }

    /**
     * Retourne toutes les évaluations prévues pour la classe de cet élève
     * Correspond à ConsulterEvaluation() dans le diagramme UML
     */
    public function consulterEvaluations()
    {
        return Evaluation::whereHas('enseigner', function ($query) {
            $query->where('classe_id', $this->classe_id);
        })->get();
    }

    /**
     * Calcule la moyenne de cet élève pour UNE matière donnée
     */
    public function moyenneParMatiere(int $matiereId): ?float
    {
        $notes = Note::where('eleve_id', $this->id)
            ->whereHas('evaluation.enseigner', function ($query) use ($matiereId) {
                $query->where('matiere_id', $matiereId);
            })
            ->get();

        if ($notes->isEmpty()) {
            return null;
        }

        return round($notes->avg('valeur'), 2);
    }

    /**
     * Retourne la moyenne de cet élève pour CHAQUE matière étudiée
     * Si $semestre est précisé, ne prend en compte que ce semestre
     */
    public function moyennesParMatiere(?int $semestre = null)
    {
        $query = Note::where('eleve_id', $this->id)
            ->with('evaluation.enseigner.matiere');

        if ($semestre !== null) {
            $query->whereHas('evaluation', function ($q) use ($semestre) {
                $q->where('semestre', $semestre);
            });
        }

        $notes = $query->get();

        return $notes->groupBy(function ($note) {
            return $note->evaluation->enseigner->matiere->id;
        })->map(function ($notesGroup) {
            $matiere = $notesGroup->first()->evaluation->enseigner->matiere;

            return [
                'matiere'     => $matiere->nom,
                'coefficient' => $matiere->coefficient,
                'moyenne'     => round($notesGroup->avg('valeur'), 2),
            ];
        });
    }

    /**
     * Calcule la moyenne générale de cet élève (toute l'année, ou un semestre donné)
     * Correspond à ConsulterMoyenne() dans le diagramme UML
     */
    public function consulterMoyenne(?int $semestre = null): ?float
    {
        $moyennes = $this->moyennesParMatiere($semestre);

        if ($moyennes->isEmpty()) {
            return null;
        }

        $totalPondere    = 0;
        $totalCoefficients = 0;

        foreach ($moyennes as $data) {
            $totalPondere      += $data['moyenne'] * $data['coefficient'];
            $totalCoefficients += $data['coefficient'];
        }

        return $totalCoefficients > 0
            ? round($totalPondere / $totalCoefficients, 2)
            : null;
    }

    /**
     * Vérifie si le bulletin de ce semestre est complet
     */
    public function bulletinComplet(int $semestre): bool
    {
        $evaluations = $this->consulterEvaluations()
            ->filter(fn ($evaluation) => $evaluation->semestre === $semestre);

        if ($evaluations->isEmpty()) {
            return false;
        }

        $idsEvaluationsNotees = Note::where('eleve_id', $this->id)
            ->whereIn('evaluation_id', $evaluations->pluck('id'))
            ->pluck('evaluation_id');

        return $evaluations->pluck('id')->diff($idsEvaluationsNotees)->isEmpty();
    }

    /**
     * Calcule le rang de cet élève dans sa classe, pour un semestre donné
     */
    public function rangDansLaClasse(int $semestre): ?array
    {
        $elevesDeLaClasse = User::where('role', 'eleve')
            ->where('classe_id', $this->classe_id)
            ->get();

        $moyennes = $elevesDeLaClasse
            ->map(function ($eleve) use ($semestre) {
                return [
                    'id'      => $eleve->id,
                    'moyenne' => $eleve->consulterMoyenne($semestre),
                ];
            })
            ->filter(fn ($item) => $item['moyenne'] !== null)
            ->sortByDesc('moyenne')
            ->values();

        $position = $moyennes->search(fn ($item) => $item['id'] === $this->id);

        if ($position === false) {
            return null;
        }

        return [
            'rang'  => $position + 1,
            'total' => $moyennes->count(),
        ];
    }

    // ===================================================
    // Méthodes spécifiques au rôle ENSEIGNANT
    // ===================================================

    /**
     * Retourne les classes où cet enseignant intervient (lecture seule)
     * Correspond à ConsulterClasses() dans le diagramme UML
     */
    public function consulterClasses()
    {
        return Classe::whereHas('enseignements', function ($query) {
            $query->where('enseignant_id', $this->id);
        })->get();
    }

    /**
     * Retourne les matières enseignées par cet enseignant (lecture seule)
     * Correspond à ConsulterMatiere() dans le diagramme UML
     */
    public function consulterMatieres()
    {
        return Matiere::whereHas('enseignements', function ($query) {
            $query->where('enseignant_id', $this->id);
        })->get();
    }
}