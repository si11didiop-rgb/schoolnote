<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\BulletinDisponibleMail;
use App\Models\Classe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BulletinController extends Controller
{
    /**
     * Active ou désactive la publication des bulletins
     * pour une classe et un semestre donnés
     * Envoie une notification email aux élèves et parents lors de la publication
     */
    public function toggle(Request $request, Classe $classe)
    {
        $validated = $request->validate([
            'semestre' => 'required|integer|in:1,2',
        ]);

        // Cast explicite en int pour éviter les problèmes de comparaison string/int
        $semestre = (int) $validated['semestre'];

        // On inverse la valeur actuelle (publié → masqué, masqué → publié)
        if ($semestre === 1) {
            $classe->update(['bulletin_s1_publie' => ! $classe->bulletin_s1_publie]);
            $estPublie = $classe->fresh()->bulletin_s1_publie;
        } else {
            $classe->update(['bulletin_s2_publie' => ! $classe->bulletin_s2_publie]);
            $estPublie = $classe->fresh()->bulletin_s2_publie;
        }

        $statut = $estPublie ? 'publiés' : 'masqués';

        // On envoie les emails uniquement lors de la publication, pas du masquage
        if ($estPublie) {
            $eleves = User::where('role', 'eleve')
                ->where('classe_id', $classe->id)
                ->get();

            // Délai progressif pour respecter la limite SMTP (Mailtrap : 1 email/seconde)
            $delai = 0;

            foreach ($eleves as $eleve) {
                // Notification à l'élève
                Mail::to($eleve->email)
                    ->later(now()->addSeconds($delai), new BulletinDisponibleMail($eleve, $eleve, $semestre, $classe));
                $delai += 5;

                // Notification au parent si existant
                if ($eleve->parent_id) {
                    $parent = User::find($eleve->parent_id);
                    if ($parent) {
                        Mail::to($parent->email)
                            ->later(now()->addSeconds($delai), new BulletinDisponibleMail($parent, $eleve, $semestre, $classe));
                        $delai += 5;
                    }
                }
            }
        }

        return back()->with('success', "Bulletins semestre {$semestre} {$statut} pour {$classe->nom}. Les élèves et parents ont été notifiés.");
    }
}