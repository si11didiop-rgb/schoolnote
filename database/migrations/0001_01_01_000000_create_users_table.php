<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->enum('genre', ['M', 'F'])->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // Rôle de l'utilisateur (Single Table Inheritance)
            $table->enum('role', ['administrateur', 'enseignant', 'eleve', 'parent']);

            // Oblige l'utilisateur à changer son mot de passe à la première connexion
            $table->boolean('must_change_password')->default(true);

            // -- Champs spécifiques à Eleve --
            $table->date('date_de_naissance')->nullable();
            $table->unsignedBigInteger('classe_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            // Statut de l'élève (actif par défaut)
            $table->enum('statut', ['actif', 'suspendu', 'diplome'])->default('actif')->nullable();

            // -- Champ spécifique à Enseignant --
            $table->string('specialite')->nullable();

            // -- Champ spécifique à Parent --
            $table->string('lien_parente')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};