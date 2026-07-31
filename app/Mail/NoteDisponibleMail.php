<?php

namespace App\Mail;

use App\Models\Note;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NoteDisponibleMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 30;

    public function __construct(
        public User $destinataire,
        public User $eleve,
        public Note $note
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'SchoolNote — Nouvelle note disponible',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.note-disponible',
        );
    }
}