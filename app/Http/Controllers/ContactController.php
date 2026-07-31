<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Affiche le formulaire de contact
     */
    public function index()
    {
        return view('contact');
    }

    /**
     * Traite l'envoi du formulaire de contact
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom'     => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'sujet'   => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ], [
            'nom.required'     => 'Votre nom est obligatoire.',
            'email.required'   => 'Votre email est obligatoire.',
            'email.email'      => 'L\'adresse email n\'est pas valide.',
            'sujet.required'   => 'Le sujet est obligatoire.',
            'message.required' => 'Le message est obligatoire.',
            'message.max'      => 'Le message ne peut pas dépasser 2000 caractères.',
        ]);

        // Envoi de l'email à l'administrateur
        Mail::send('emails.contact', $validated, function ($mail) use ($validated) {
            $mail->to(config('mail.from.address'))
                 ->subject('SchoolNote — Contact : ' . $validated['sujet'])
                 ->replyTo($validated['email'], $validated['nom']);
        });

        return redirect()->route('contact')
            ->with('success', 'Votre message a bien été envoyé. Nous vous répondrons dans les 5 jours ouvrés.');
    }
}