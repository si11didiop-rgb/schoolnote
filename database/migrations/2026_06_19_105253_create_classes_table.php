<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Création de la table "classes" qui correspond à la classe UML "Classe"
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('niveau');
            $table->string('annee_scolaire');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};