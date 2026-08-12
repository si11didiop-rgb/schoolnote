<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appreciations', function (Blueprint $table) {
            $table->id();

            // Lien vers l'affectation (enseignant + matière + classe)
            $table->foreignId('enseigner_id')->constrained('enseigner')->cascadeOnDelete();

            // Lien vers l'élève
            $table->foreignId('eleve_id')->constrained('users')->cascadeOnDelete();

            // Semestre concerné (1 ou 2)
            $table->tinyInteger('semestre')->unsigned();

            // Appréciation de l'enseignant
            $table->text('appreciation');

            $table->timestamps();

            // Un enseignant ne peut donner qu'une seule appréciation par élève par semestre
            $table->unique(['enseigner_id', 'eleve_id', 'semestre']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appreciations');
    }
};