<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    protected $fillable = [
        'nom',
        'niveau',
        'annee_scolaire',
        'bulletin_s1_publie',
        'bulletin_s2_publie',
    ];

    protected function casts(): array
    {
        return [
            'bulletin_s1_publie' => 'boolean',
            'bulletin_s2_publie' => 'boolean',
        ];
    }

    /**
     * Les élèves de cette classe
     */
    public function eleves()
    {
        return $this->hasMany(User::class, 'classe_id');
    }

    /**
     * Les enseignements liés à cette classe (via la table enseigner)
     */
    public function enseignements()
    {
        return $this->hasMany(Enseigner::class);
    }

    /**
     * Retourne le nombre d'élèves dans cette classe
     * Correspond à afficherEffectif() dans le diagramme UML
     */
    public function afficherEffectif(): int
    {
        return $this->eleves()->count();
    }

    /**
     * Vérifie si les bulletins sont publiés pour un semestre donné
     */
    public function bulletinsPublies(int $semestre): bool
    {
        return $semestre === 1
            ? $this->bulletin_s1_publie
            : $this->bulletin_s2_publie;
    }
}