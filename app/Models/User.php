<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at'    => 'datetime',
            'date_de_naissance'    => 'date',
            'password'             => 'hashed',
            'must_change_password' => 'boolean',
        ];
    }

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

    public function consulterNotes()
    {
        return Note::where('eleve_id', $this->id)->get();
    }

    public function consulterEvaluations()
    {
        return Evaluation::whereHas('enseigner', function ($query) {
            $query->where('classe_id', $this->classe_id);
        })->get();
    }

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
     * Le coefficient est maintenant lu depuis la table enseigner (par classe)
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
            $enseigner = $notesGroup->first()->evaluation->enseigner;
            $matiere   = $enseigner->matiere;

            return [
                'matiere'     => $matiere->nom,
                // Coefficient lu depuis enseigner (spécifique à la classe)
                'coefficient' => $enseigner->coefficient,
                'moyenne'     => round($notesGroup->avg('valeur'), 2),
            ];
        });
    }

    /**
     * Calcule la moyenne générale pondérée par les coefficients de la classe
     */
    public function consulterMoyenne(?int $semestre = null): ?float
    {
        $moyennes = $this->moyennesParMatiere($semestre);

        if ($moyennes->isEmpty()) {
            return null;
        }

        $totalPondere      = 0;
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
     * Retourne la mention selon la moyenne générale
     */
    public function getMention(?float $moyenne): string
    {
        if ($moyenne === null) return '—';

        return match (true) {
            $moyenne >= 16 => 'Très Bien',
            $moyenne >= 14 => 'Bien',
            $moyenne >= 12 => 'Assez Bien',
            $moyenne >= 10 => 'Passable',
            default        => 'Insuffisant',
        };
    }

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

    public function consulterClasses()
    {
        return Classe::whereHas('enseignements', function ($query) {
            $query->where('enseignant_id', $this->id);
        })->get();
    }

    public function consulterMatieres()
    {
        return Matiere::whereHas('enseignements', function ($query) {
            $query->where('enseignant_id', $this->id);
        })->get();
    }
}