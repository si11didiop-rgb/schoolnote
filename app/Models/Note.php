<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    /**
     * Les attributs qu'on peut remplir en masse
     *
     * @var list<string>
     */
    protected $fillable = [
        'eleve_id',
        'evaluation_id',
        'valeur',
        'date_de_saisie',
    ];

    /**
     * Les attributs à transformer (cast) en types PHP
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date_de_saisie' => 'date',
        ];
    }

    /**
     * L'élève concerné par cette note (un user avec role=eleve)
     */
    public function eleve()
    {
        return $this->belongsTo(User::class, 'eleve_id');
    }

    /**
     * L'évaluation concernée par cette note
     */
    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }
}