<?php

namespace Database\Seeders;

use App\Models\Classe;
use App\Models\Enseigner;
use App\Models\Evaluation;
use App\Models\Matiere;
use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Remplit la base avec des données de test réalistes et cohérentes
     * must_change_password = false car ce sont des comptes de démonstration
     * Les coefficients sont maintenant par affectation (matière + classe)
     */
    public function run(): void
    {
        // ===================================================
        // ADMINISTRATEUR
        // ===================================================
        $admin = User::create([
            'nom'                  => 'Diop',
            'prenom'               => 'Sidy',
            'email'                => 'admin@schoolnote.fr',
            'password'             => bcrypt('password'),
            'role'                 => 'administrateur',
            'must_change_password' => false,
        ]);

        // ===================================================
        // CLASSES
        // ===================================================
        $terminaleA = Classe::create([
            'nom'            => 'Terminale A',
            'niveau'         => 'Terminale',
            'annee_scolaire' => '2025-2026',
        ]);

        $premiereB = Classe::create([
            'nom'            => 'Première B',
            'niveau'         => 'Première',
            'annee_scolaire' => '2025-2026',
        ]);

        // ===================================================
        // MATIERES (sans coefficient — il est dans enseigner)
        // ===================================================
        $maths    = Matiere::create(['nom' => 'Mathématiques']);
        $francais = Matiere::create(['nom' => 'Français']);
        $svt      = Matiere::create(['nom' => 'SVT']);

        // ===================================================
        // ENSEIGNANTS
        // ===================================================
        $profMaths = User::create([
            'nom'                  => 'Martin',
            'prenom'               => 'Jean',
            'genre'                => 'M',
            'email'                => 'jean.martin@schoolnote.fr',
            'password'             => bcrypt('password'),
            'role'                 => 'enseignant',
            'specialite'           => 'Mathématiques',
            'must_change_password' => false,
        ]);

        $profFrancais = User::create([
            'nom'                  => 'Bernard',
            'prenom'               => 'Claire',
            'genre'                => 'F',
            'email'                => 'claire.bernard@schoolnote.fr',
            'password'             => bcrypt('password'),
            'role'                 => 'enseignant',
            'specialite'           => 'Français',
            'must_change_password' => false,
        ]);

        $profSvt = User::create([
            'nom'                  => 'Dupont',
            'prenom'               => 'Marc',
            'genre'                => 'M',
            'email'                => 'marc.dupont@schoolnote.fr',
            'password'             => bcrypt('password'),
            'role'                 => 'enseignant',
            'specialite'           => 'SVT',
            'must_change_password' => false,
        ]);

        // ===================================================
        // PARENTS
        // ===================================================
        $parent1 = User::create([
            'nom'                  => 'Durand',
            'prenom'               => 'Paul',
            'genre'                => 'M',
            'email'                => 'paul.durand@schoolnote.fr',
            'password'             => bcrypt('password'),
            'role'                 => 'parent',
            'lien_parente'         => 'père',
            'must_change_password' => false,
        ]);

        $parent2 = User::create([
            'nom'                  => 'Lefevre',
            'prenom'               => 'Marie',
            'genre'                => 'F',
            'email'                => 'marie.lefevre@schoolnote.fr',
            'password'             => bcrypt('password'),
            'role'                 => 'parent',
            'lien_parente'         => 'mère',
            'must_change_password' => false,
        ]);

        $parent3 = User::create([
            'nom'                  => 'Mbaye',
            'prenom'               => 'Fatou',
            'genre'                => 'F',
            'email'                => 'fatou.mbaye@schoolnote.fr',
            'password'             => bcrypt('password'),
            'role'                 => 'parent',
            'lien_parente'         => 'mère',
            'must_change_password' => false,
        ]);

        // ===================================================
        // ELEVES (Terminale A)
        // ===================================================
        $eleve1 = User::create([
            'nom'                  => 'Durand',
            'prenom'               => 'Lucas',
            'genre'                => 'M',
            'email'                => 'lucas.durand@schoolnote.fr',
            'password'             => bcrypt('password'),
            'role'                 => 'eleve',
            'date_de_naissance'    => '2008-03-15',
            'classe_id'            => $terminaleA->id,
            'parent_id'            => $parent1->id,
            'must_change_password' => false,
        ]);

        $eleve2 = User::create([
            'nom'                  => 'Lefevre',
            'prenom'               => 'Emma',
            'genre'                => 'F',
            'email'                => 'emma.lefevre@schoolnote.fr',
            'password'             => bcrypt('password'),
            'role'                 => 'eleve',
            'date_de_naissance'    => '2008-07-22',
            'classe_id'            => $terminaleA->id,
            'parent_id'            => $parent2->id,
            'must_change_password' => false,
        ]);

        $eleve3 = User::create([
            'nom'                  => 'Mbaye',
            'prenom'               => 'Aminata',
            'genre'                => 'F',
            'email'                => 'aminata.mbaye@schoolnote.fr',
            'password'             => bcrypt('password'),
            'role'                 => 'eleve',
            'date_de_naissance'    => '2008-11-05',
            'classe_id'            => $terminaleA->id,
            'parent_id'            => $parent3->id,
            'must_change_password' => false,
        ]);

        // ===================================================
        // AFFECTATIONS avec coefficients par classe
        // Terminale A : Maths coeff 4, Français coeff 3, SVT coeff 2
        // Première B  : Français coeff 4 (coefficient différent !)
        // ===================================================
        $enseignerMaths = Enseigner::create([
            'enseignant_id' => $profMaths->id,
            'matiere_id'    => $maths->id,
            'classe_id'     => $terminaleA->id,
            'coefficient'   => 4,
        ]);

        $enseignerFrancais = Enseigner::create([
            'enseignant_id' => $profFrancais->id,
            'matiere_id'    => $francais->id,
            'classe_id'     => $terminaleA->id,
            'coefficient'   => 3,
        ]);

        $enseignerSvt = Enseigner::create([
            'enseignant_id' => $profSvt->id,
            'matiere_id'    => $svt->id,
            'classe_id'     => $terminaleA->id,
            'coefficient'   => 2,
        ]);

        // Français en Première B avec un coefficient différent
        Enseigner::create([
            'enseignant_id' => $profFrancais->id,
            'matiere_id'    => $francais->id,
            'classe_id'     => $premiereB->id,
            'coefficient'   => 4,
        ]);

        // ===================================================
        // EVALUATIONS SEMESTRE 1 (passées)
        // ===================================================
        $evalMaths1 = Evaluation::create([
            'enseigner_id'    => $enseignerMaths->id,
            'type'            => 'Contrôle',
            'titre'           => 'Chapitre 1 - Les suites',
            'date_evaluation' => '2026-01-15',
            'heure_debut'     => '08:00',
            'heure_fin'       => '09:00',
            'semestre'        => 1,
        ]);

        $evalFrancais1 = Evaluation::create([
            'enseigner_id'    => $enseignerFrancais->id,
            'type'            => 'Dissertation',
            'titre'           => 'Commentaire de texte - Zola',
            'date_evaluation' => '2026-01-20',
            'heure_debut'     => '10:00',
            'heure_fin'       => '12:00',
            'semestre'        => 1,
        ]);

        $evalSvt1 = Evaluation::create([
            'enseigner_id'    => $enseignerSvt->id,
            'type'            => 'Contrôle',
            'titre'           => 'La cellule et son environnement',
            'date_evaluation' => '2026-01-22',
            'heure_debut'     => '14:00',
            'heure_fin'       => '15:00',
            'semestre'        => 1,
        ]);

        // ===================================================
        // EVALUATIONS A VENIR (semestre 2)
        // ===================================================
        Evaluation::create([
            'enseigner_id'    => $enseignerMaths->id,
            'type'            => 'Devoir surveillé',
            'titre'           => 'Chapitre 2 - Les fonctions',
            'date_evaluation' => '2026-09-15',
            'heure_debut'     => '08:00',
            'heure_fin'       => '10:00',
            'semestre'        => 2,
        ]);

        Evaluation::create([
            'enseigner_id'    => $enseignerFrancais->id,
            'type'            => 'Interrogation',
            'titre'           => 'Lecture - Le Rouge et le Noir',
            'date_evaluation' => '2026-09-20',
            'heure_debut'     => '10:00',
            'heure_fin'       => '11:00',
            'semestre'        => 2,
        ]);

        // ===================================================
        // NOTES SEMESTRE 1 (complètes pour les 3 élèves)
        // ===================================================

        // Notes de Lucas
        Note::create(['eleve_id' => $eleve1->id, 'evaluation_id' => $evalMaths1->id,    'valeur' => 14.5, 'date_de_saisie' => '2026-01-16']);
        Note::create(['eleve_id' => $eleve1->id, 'evaluation_id' => $evalFrancais1->id, 'valeur' => 12,   'date_de_saisie' => '2026-01-21']);
        Note::create(['eleve_id' => $eleve1->id, 'evaluation_id' => $evalSvt1->id,      'valeur' => 15,   'date_de_saisie' => '2026-01-23']);

        // Notes d'Emma
        Note::create(['eleve_id' => $eleve2->id, 'evaluation_id' => $evalMaths1->id,    'valeur' => 16,   'date_de_saisie' => '2026-01-16']);
        Note::create(['eleve_id' => $eleve2->id, 'evaluation_id' => $evalFrancais1->id, 'valeur' => 17,   'date_de_saisie' => '2026-01-21']);
        Note::create(['eleve_id' => $eleve2->id, 'evaluation_id' => $evalSvt1->id,      'valeur' => 14,   'date_de_saisie' => '2026-01-23']);

        // Notes d'Aminata
        Note::create(['eleve_id' => $eleve3->id, 'evaluation_id' => $evalMaths1->id,    'valeur' => 11,   'date_de_saisie' => '2026-01-16']);
        Note::create(['eleve_id' => $eleve3->id, 'evaluation_id' => $evalFrancais1->id, 'valeur' => 13,   'date_de_saisie' => '2026-01-21']);
        Note::create(['eleve_id' => $eleve3->id, 'evaluation_id' => $evalSvt1->id,      'valeur' => 12,   'date_de_saisie' => '2026-01-23']);
    }
}