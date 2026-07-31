<?php

namespace App\Mail;

use App\Models\Classe;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BulletinDisponibleMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    // Nombre maximum de tentatives
    public int $tries = 3;

    // Délai en secondes entre chaque tentative
    public int $backoff = 30;

    public function __construct(
        public User $destinataire,
        public User $eleve,
        public int $semestre,
        public Classe $classe
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'SchoolNote — Bulletin semestre ' . $this->semestre . ' disponible',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.bulletin-disponible',
        );
    }
}