<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Table "evaluations" qui correspond à la classe UML "Evaluation"
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();

            // Lien vers le triplet enseignant/matière/classe concerné
            $table->foreignId('enseigner_id')->constrained('enseigner')->cascadeOnDelete();

            $table->string('type');
            $table->string('titre');
            $table->date('date_evaluation');
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->unsignedTinyInteger('semestre');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};