<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Création de la table "matiere_scolaire" qui correspond à la classe UML "Matiere"
        // (nommée différemment de "matieres" pour éviter un conflit technique persistant sur cet environnement)
        Schema::create('matiere_scolaire', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->integer('coefficient');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matiere_scolaire');
    }
};