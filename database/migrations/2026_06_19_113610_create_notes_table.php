<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Table "notes" : classe-association entre Eleve et Evaluation
        Schema::create('notes', function (Blueprint $table) {
            $table->id();

            // Lien vers l'élève concerné (un user avec role=eleve)
            $table->foreignId('eleve_id')->constrained('users')->cascadeOnDelete();

            $table->foreignId('evaluation_id')->constrained('evaluations')->cascadeOnDelete();
            $table->float('valeur');
            $table->date('date_de_saisie');
            $table->timestamps();

            $table->unique(['eleve_id', 'evaluation_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};