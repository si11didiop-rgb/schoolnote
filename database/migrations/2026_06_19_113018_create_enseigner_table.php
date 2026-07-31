<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Table "enseigner" : association ternaire Enseignant/Matiere/Classe
        Schema::create('enseigner', function (Blueprint $table) {
            $table->id();

            // Lien vers l'enseignant concerné (un user avec role=enseignant)
            $table->foreignId('enseignant_id')->constrained('users')->cascadeOnDelete();

            $table->foreignId('matiere_id')->constrained('matiere_scolaire')->cascadeOnDelete();
            $table->foreignId('classe_id')->constrained('classes')->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['enseignant_id', 'matiere_id', 'classe_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enseigner');
    }
};