<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécute la migration (création de la table)
     */
    public function up(): void
    {
        // Création de la table "matieres" qui correspond à la classe UML "Matiere"
        Schema::create('matieres', function (Blueprint $table) {

            // Clé primaire auto-incrémentée (id_matiere dans le diagramme)
            $table->id();

            // Nom de la matière, ex: "Mathématiques"
            $table->string('nom');

            // Coefficient de la matière, ex: 3
            $table->integer('coefficient');

            // Ajoute automatiquement created_at et updated_at
            $table->timestamps();
        });
    }

    /**
     * Annule la migration (suppression de la table)
     */
    public function down(): void
    {
        Schema::dropIfExists('matieres');
    }
};