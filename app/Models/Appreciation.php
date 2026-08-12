<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appreciation extends Model
{
    protected $fillable = [
        'enseigner_id',
        'eleve_id',
        'semestre',
        'appreciation',
    ];

    protected function casts(): array
    {
        return [
            'semestre' => 'integer',
        ];
    }

    public function enseigner()
    {
        return $this->belongsTo(Enseigner::class);
    }

    public function eleve()
    {
        return $this->belongsTo(User::class, 'eleve_id');
    }
}