# SchoolNote 🎓

Plateforme de gestion des notes et évaluations pour lycées.

## 📋 Description

SchoolNote est une application web complète développée dans le cadre du **Titre Professionnel DWWM (Développeur Web et Web Mobile — RNCP Niveau 5)** à INT Éducation Paris.

L'objectif est de numériser et centraliser la gestion pédagogique d'un lycée privé : notes, évaluations, bulletins scolaires et suivi des résultats, pour l'ensemble des acteurs de l'établissement.

## ✨ Fonctionnalités

- 🛡️ **Administrateur** : gestion des classes (effectif max), matières, comptes, affectations avec coefficient par classe, publication des bulletins, gestion du statut des élèves
- 👨‍🏫 **Enseignant** : planification des évaluations, saisie des notes et appréciations par élève
- 🎓 **Élève** : consultation des notes, évaluations, bulletin avec rang, mention, appréciations et téléchargement PDF
- 👨‍👩‍👧 **Parent** : suivi des notes et bulletins de ses enfants
- 📧 **Notifications email** automatiques (création de compte, évaluation, notes, bulletin)
- 🔐 **Sécurité** : changement de mot de passe obligatoire, rate limiting, rôles, protection OWASP Top 12

## 🛠️ Stack technique

- **Framework** : Laravel 12 (PHP 8.2)
- **CSS** : Tailwind CSS
- **Base de données** : MySQL / MariaDB
- **Authentification** : Laravel Breeze
- **PDF** : barryvdh/laravel-dompdf
- **Emails** : Laravel Mail + Mailtrap (dev) / Resend (prod)
- **Queue** : Laravel Queue (database driver)
- **Versionning** : Git / GitHub

## 🚀 Installation

### Prérequis
- PHP 8.2+
- Composer
- Node.js & npm
- MySQL / MariaDB

### Étapes

```bash
# Cloner le projet
git clone https://github.com/si11didiop-rgb/schoolnote.git
cd schoolnote

# Installer les dépendances PHP
composer install

# Installer les dépendances JS
npm install

# Copier le fichier d'environnement
cp .env.example .env

# Générer la clé d'application
php artisan key:generate

# Configurer la base de données dans .env
DB_DATABASE=schoolnote
DB_USERNAME=root
DB_PASSWORD=

# Configurer Mailtrap dans .env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=votre_username
MAIL_PASSWORD=votre_password

# Lancer les migrations et le seeder
php artisan migrate
php artisan db:seed

# Créer la table jobs manuellement
# (via phpMyAdmin ou MySQL)

# Compiler les assets
npm run build

# Lancer le serveur
php artisan serve

# Lancer le worker (dans un terminal séparé)
php artisan queue:work
```

### Comptes de démonstration

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| Administrateur | admin@schoolnote.fr | password |
| Enseignant | jean.martin@schoolnote.fr | password |
| Élève | lucas.durand@schoolnote.fr | password |
| Parent | paul.durand@schoolnote.fr | password |

## 📁 Structure du projet

app/
├── Http/
│ ├── Controllers/
│ │ ├── Admin/ # Contrôleurs administrateur
│ │ │ ├── AffectationController.php
│ │ │ ├── BulletinController.php
│ │ │ ├── ClasseController.php
│ │ │ ├── CompteController.php
│ │ │ └── MatiereController.php
│ │ ├── Enseignant/ # Contrôleurs enseignant
│ │ │ ├── ClasseController.php
│ │ │ ├── EvaluationController.php
│ │ │ ├── MatiereController.php
│ │ │ └── NoteController.php
│ │ ├── Eleve/ # Contrôleurs élève
│ │ │ └── EleveController.php
│ │ ├── Parent/ # Contrôleurs parent
│ │ │ └── ParentController.php
│ │ └── Auth/ # Contrôleurs authentification
│ │ ├── AuthenticatedSessionController.php
│ │ └── ChangePasswordController.php
│ └── Middleware/
│ ├── CheckRole.php # Vérification des rôles
│ └── ForcePasswordChange.php # Changement mdp obligatoire
├── Mail/ # Mailables (emails)
│ ├── AffectationCreeMail.php
│ ├── BulletinDisponibleMail.php
│ ├── CompteCreeMail.php
│ ├── EvaluationPlanifieMail.php
│ └── NoteDisponibleMail.php
└── Models/ # Modèles Eloquent
├── Appreciation.php
├── Classe.php
├── Enseigner.php
├── Evaluation.php
├── Matiere.php
├── Note.php
└── User.php

resources/views/
├── admin/ # Vues administrateur
├── enseignant/ # Vues enseignant
├── eleve/ # Vues élève
├── parent/ # Vues parent
├── emails/ # Templates emails
├── legal/ # Pages légales
└── components/ # Composants réutilisables


## 🗄️ Structure de la base de données

| Table | Description |
|-------|-------------|
| `users` | Tous les utilisateurs avec colonne `role` (STI) |
| `classes` | Classes scolaires avec effectif maximum |
| `matiere_scolaire` | Matières scolaires |
| `enseigner` | Affectations (enseignant + matière + classe + coefficient) |
| `evaluations` | Évaluations planifiées |
| `notes` | Notes des élèves |
| `appreciations` | Appréciations des enseignants par élève et semestre |
| `jobs` | File d'attente pour les emails |

## 🔐 Sécurité

- Mots de passe chiffrés via **bcrypt**
- Protection **CSRF** sur tous les formulaires
- **Rate limiting** sur la connexion (5 tentatives max)
- **Middleware de rôle** (RBAC) — accès protégé par espace
- **Changement de mot de passe obligatoire** à la première connexion
- **Mots de passe forts** (majuscule, chiffre, symbole)
- **HTTPS forcing** en production
- **Headers de sécurité HTTP** (X-Frame-Options, X-Content-Type-Options...)
- Protection contre les **12 principales vulnérabilités web**
- Conformité **RGPD / CNIL**

## 📧 Notifications email

| Événement | Destinataire |
|-----------|--------------|
| Création de compte | Nouvel utilisateur |
| Affectation enseignant | Enseignant concerné |
| Évaluation planifiée | Tous les élèves de la classe |
| Notes saisies | Élève + parent |
| Bulletin publié | Élève + parent |

## 📊 Fonctionnalités avancées

- **Coefficient par classe** — une matière peut avoir un coefficient différent selon la classe
- **Contrainte métier** — une matière ne peut être enseignée que par un seul enseignant par classe
- **Mentions automatiques** — Très Bien (≥16), Bien (≥14), Assez Bien (≥12), Passable (≥10), Insuffisant (<10)
- **Appréciations enseignant** — visible sur le bulletin par matière
- **Effectif maximum** — impossible d'inscrire un élève dans une classe complète
- **Statut élève** — actif, suspendu, diplômé

## 📄 Licence

Projet pédagogique — INT Éducation Paris — 2026