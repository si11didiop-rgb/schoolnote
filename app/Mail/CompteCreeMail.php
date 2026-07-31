<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CompteCreeMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Crée une nouvelle instance du Mailable
     * On passe l'utilisateur et le mot de passe en clair (avant chiffrement)
     * car on ne pourra plus le récupérer après bcrypt
     */
    public function __construct(
        public User $user,
        public string $motDePasse
    ) {}

    /**
     * Définit l'objet de l'email
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bienvenue sur SchoolNote — Vos identifiants de connexion',
        );
    }

    /**
     * Définit le contenu de l'email (vue Blade)
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.compte-cree',
        );
    }
}
