# SchoolNote 🎓

Plateforme de gestion des notes et évaluations pour lycées.

## 📋 Description

SchoolNote est une application web complète développée dans le cadre du **Titre Professionnel DWWM (Développeur Web et Web Mobile - RNCP Niveau 5)** à INT Éducation Paris.

## ✨ Fonctionnalités

- 🛡️ **Administrateur** : gestion des classes, matières, comptes, affectations, publication des bulletins
- 👨‍🏫 **Enseignant** : planification des évaluations, saisie des notes
- 🎓 **Élève** : consultation des notes, évaluations, bulletin avec rang et téléchargement PDF
- 👨‍👩‍👧 **Parent** : suivi des notes et bulletins de ses enfants
- 📧 **Notifications email** automatiques (création de compte, évaluation, notes, bulletin)
- 🔐 **Sécurité** : changement de mot de passe obligatoire, rate limiting, rôles

## 🛠️ Stack technique

- **Framework** : Laravel 12
- **CSS** : Tailwind CSS
- **Base de données** : MySQL / MariaDB
- **Authentification** : Laravel Breeze
- **PDF** : barryvdh/laravel-dompdf
- **Emails** : Laravel Mail + Mailtrap (dev) / Resend (prod)
- **Queue** : Laravel Queue (database driver)

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

# Compiler les assets
npm run build

# Lancer le serveur
php artisan serve
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
├── Classe.php
├── Enseigner.php
├── Evaluation.php
├── Matiere.php
├── Note.php
└── User.php

resources/
└── views/
├── admin/ # Vues administrateur
├── enseignant/ # Vues enseignant
├── eleve/ # Vues élève
├── parent/ # Vues parent
├── emails/ # Templates emails
├── legal/ # Pages légales
└── components/ # Composants réutilisables

database/
├── migrations/ # Migrations de base de données
└── seeders/ # Données de test


## 🗄️ Structure de la base de données

| Table | Description |
|-------|-------------|
| `users` | Tous les utilisateurs (admin, enseignant, élève, parent) |
| `classes` | Classes scolaires |
| `matiere_scolaire` | Matières avec coefficient |
| `enseigner` | Affectations (enseignant + matière + classe) |
| `evaluations` | Évaluations planifiées |
| `notes` | Notes des élèves |
| `jobs` | File d'attente pour les emails |

## 🔐 Sécurité

- Mots de passe chiffrés via **bcrypt**
- Protection **CSRF** sur tous les formulaires
- **Rate limiting** sur la connexion (5 tentatives max)
- **Middleware de rôle** — accès protégé par espace
- **Changement de mot de passe obligatoire** à la première connexion
- **Mots de passe forts** obligatoires (majuscule, chiffre, symbole)
- Vérification d'appartenance dans les contrôleurs
- Conformité **RGPD / CNIL**

## 📧 Notifications email

| Événement | Destinataire |
|-----------|--------------|
| Création de compte | Nouvel utilisateur |
| Affectation enseignant | Enseignant concerné |
| Évaluation planifiée | Tous les élèves de la classe |
| Notes saisies | Élève + parent |
| Bulletin publié | Élève + parent |

## 📄 Licence

Projet pédagogique — INT Éducation Paris — 2026

