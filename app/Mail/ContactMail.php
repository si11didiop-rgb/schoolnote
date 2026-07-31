<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 10;

    public function __construct(
        public string $nomExpediteur,
        public string $emailExpediteur,
        public string $sujet,
        public string $messageContenu
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'SchoolNote — Contact : ' . $this->sujet,
            replyTo: [$this->emailExpediteur],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
        );
    }
}