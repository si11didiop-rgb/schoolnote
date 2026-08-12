<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    /**
     * Nom de la table associée (différent du nom par défaut "matieres"
     * pour éviter un conflit technique persistant sur cet environnement)
     */
    protected $table = 'matiere_scolaire';

    protected $fillable = [
        'nom',
    ];

    public function enseignements()
    {
        return $this->hasMany(Enseigner::class);
    }

    public function getEleves()
    {
        $classeIds = $this->enseignements()->pluck('classe_id');

        return User::where('role', 'eleve')
            ->whereIn('classe_id', $classeIds)
            ->get();
    }
}