<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    /**
     * Les attributs qu'on peut remplir en masse
     *
     * @var list<string>
     */
    protected $fillable = [
        'enseigner_id',
        'type',
        'titre',
        'date_evaluation',
        'heure_debut',
        'heure_fin',
        'semestre',
    ];

    /**
     * Les attributs à transformer (cast) en types PHP
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date_evaluation' => 'date',
        ];
    }

    /**
     * L'enseignement concerné (triplet enseignant/matière/classe)
     */
    public function enseigner()
    {
        return $this->belongsTo(Enseigner::class);
    }

    /**
     * Les notes liées à cette évaluation
     * (correspond à getNotes() dans le diagramme UML)
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}