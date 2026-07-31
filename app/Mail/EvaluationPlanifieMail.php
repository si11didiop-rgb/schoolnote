<?php

namespace App\Mail;

use App\Models\Evaluation;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EvaluationPlanifieMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    // Nombre maximum de tentatives
    public int $tries = 3;

    // Délai en secondes entre chaque tentative
    public int $backoff = 10;

    public function __construct(
        public User $eleve,
        public Evaluation $evaluation
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'SchoolNote — Nouvelle évaluation planifiée',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.evaluation-planifie',
        );
    }
}