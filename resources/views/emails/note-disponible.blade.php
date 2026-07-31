<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #f9fafb; margin: 0; padding: 0; color: #374151; }
        .container { max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.07); }
        .header { background: linear-gradient(135deg, #4f46e5, #6366f1); padding: 40px 30px; text-align: center; }
        .header .logo { display: inline-flex; align-items: center; justify-content: center; width: 50px; height: 50px; background-color: rgba(255,255,255,0.2); border-radius: 10px; font-weight: bold; font-size: 18px; color: white; margin-bottom: 12px; }
        .header h1 { color: white; margin: 0; font-size: 24px; font-weight: 700; }
        .header p { color: rgba(255,255,255,0.8); margin: 8px 0 0 0; font-size: 14px; }
        .body { padding: 40px 30px; }
        .greeting { font-size: 18px; font-weight: 600; color: #1f2937; margin-bottom: 16px; }
        .text { font-size: 14px; line-height: 1.6; color: #6b7280; margin-bottom: 24px; }
        .note-box { border-radius: 12px; padding: 30px; margin-bottom: 24px; text-align: center; }
        .note-box.good { background-color: #ecfdf5; border: 1px solid #a7f3d0; }
        .note-box.average { background-color: #fffbeb; border: 1px solid #fde68a; }
        .note-box.bad { background-color: #fef2f2; border: 1px solid #fecaca; }
        .note-value { font-size: 48px; font-weight: 800; margin-bottom: 4px; }
        .note-box.good .note-value { color: #059669; }
        .note-box.average .note-value { color: #d97706; }
        .note-box.bad .note-value { color: #dc2626; }
        .note-label { font-size: 13px; color: #6b7280; }
        .info-box { background-color: #f3f4f6; border-radius: 10px; padding: 24px; margin-bottom: 24px; }
        .info-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #e5e7eb; font-size: 14px; }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: #6b7280; font-weight: 500; }
        .info-value { color: #1f2937; font-weight: 600; }
        .btn { display: block; text-align: center; background: linear-gradient(135deg, #4f46e5, #6366f1); color: white; text-decoration: none; padding: 14px 24px; border-radius: 8px; font-weight: 600; font-size: 15px; margin-bottom: 24px; }
        .footer { background-color: #f9fafb; border-top: 1px solid #e5e7eb; padding: 24px 30px; text-align: center; font-size: 12px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">SN</div>
            <h1>SchoolNote</h1>
            <p>Nouvelle note disponible</p>
        </div>

        <div class="body">
            <p class="greeting">Bonjour {{ $destinataire->prenom }} {{ $destinataire->nom }},</p>

            @if ($destinataire->id !== $eleve->id)
                <p class="text">
                    Une nouvelle note a été saisie pour votre enfant
                    <strong>{{ $eleve->prenom }} {{ $eleve->nom }}</strong> :
                </p>
            @else
                <p class="text">
                    Une nouvelle note a été saisie pour l'évaluation suivante :
                </p>
            @endif

            <!-- Note mise en valeur -->
            @php
                $valeur = $note->valeur;
                $classe = $valeur >= 14 ? 'good' : ($valeur >= 10 ? 'average' : 'bad');
            @endphp
            <div class="note-box {{ $classe }}">
                <div class="note-value">{{ $note->valeur }}/20</div>
                <div class="note-label">{{ $note->evaluation->titre }}</div>
            </div>

            <!-- Détails -->
            <div class="info-box">
                <div class="info-row">
                    <span class="info-label">Matière</span>
                    <span class="info-value">{{ $note->evaluation->enseigner->matiere->nom }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Type</span>
                    <span class="info-value">{{ $note->evaluation->type }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Date de l'évaluation</span>
                    <span class="info-value">{{ $note->evaluation->date_evaluation->format('d/m/Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Date de saisie</span>
                    <span class="info-value">{{ $note->date_de_saisie->format('d/m/Y') }}</span>
                </div>
            </div>

            @if ($destinataire->id !== $eleve->id)
                <a href="{{ config('app.url') }}/parent/enfants/{{ $eleve->id }}/notes" class="btn">
                    Voir toutes les notes →
                </a>
            @else
                <a href="{{ config('app.url') }}/eleve/notes" class="btn">
                    Voir toutes mes notes →
                </a>
            @endif
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} SchoolNote — INT Éducation Paris</p>
            <p style="margin-top: 4px;">Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
        </div>
    </div>
</body>
</html>