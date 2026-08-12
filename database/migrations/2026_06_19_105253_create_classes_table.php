<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('niveau');
            $table->string('annee_scolaire');
            // Effectif maximum autorisé dans la classe (par défaut 35 élèves)
            $table->integer('effectif_max')->default(35);
            // Publication des bulletins par semestre
            $table->boolean('bulletin_s1_publie')->default(false);
            $table->boolean('bulletin_s2_publie')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};