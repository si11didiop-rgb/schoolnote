<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enseigner', function (Blueprint $table) {
            $table->id();

            $table->foreignId('enseignant_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('matiere_id')->constrained('matiere_scolaire')->cascadeOnDelete();
            $table->foreignId('classe_id')->constrained('classes')->cascadeOnDelete();

            // Coefficient spécifique à chaque matière par classe
            $table->integer('coefficient')->default(1);

            $table->timestamps();

            // Une matière ne peut être enseignée que par un seul enseignant par classe
            $table->unique(['matiere_id', 'classe_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enseigner');
    }
};