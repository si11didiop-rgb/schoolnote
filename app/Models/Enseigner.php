<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enseigner extends Model
{
    /**
     * Le nom de la table associée à ce modèle
     * (sans "s" car Eloquent mettrait "enseigners" par défaut)
     */
    protected $table = 'enseigner';

    /**
     * Les attributs qu'on peut remplir en masse
     */
    protected $fillable = [
        'enseignant_id',
        'matiere_id',
        'classe_id',
        'coefficient',
    ];

    protected function casts(): array
    {
        return [
            'coefficient' => 'integer',
        ];
    }

    public function enseignant()
    {
        return $this->belongsTo(User::class, 'enseignant_id');
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    /**
     * Appréciations données par cet enseignant aux élèves de sa classe
     */
    public function appreciations()
    {
        return $this->hasMany(Appreciation::class);
    }
}