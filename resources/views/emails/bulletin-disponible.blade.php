<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #f9fafb; margin: 0; padding: 0; color: #374151; }
        .container { max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.07); }
        .header { background: linear-gradient(135deg, #10b981, #059669); padding: 40px 30px; text-align: center; }
        .header .logo { display: inline-flex; align-items: center; justify-content: center; width: 50px; height: 50px; background-color: rgba(255,255,255,0.2); border-radius: 10px; font-weight: bold; font-size: 18px; color: white; margin-bottom: 12px; }
        .header h1 { color: white; margin: 0; font-size: 24px; font-weight: 700; }
        .header p { color: rgba(255,255,255,0.8); margin: 8px 0 0 0; font-size: 14px; }
        .body { padding: 40px 30px; }
        .greeting { font-size: 18px; font-weight: 600; color: #1f2937; margin-bottom: 16px; }
        .text { font-size: 14px; line-height: 1.6; color: #6b7280; margin-bottom: 24px; }
        .info-box { background-color: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 10px; padding: 24px; margin-bottom: 24px; }
        .info-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #d1fae5; font-size: 14px; }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: #6b7280; font-weight: 500; }
        .info-value { color: #1f2937; font-weight: 600; }
        .btn { display: block; text-align: center; background: linear-gradient(135deg, #10b981, #059669); color: white; text-decoration: none; padding: 14px 24px; border-radius: 8px; font-weight: 600; font-size: 15px; margin-bottom: 24px; }
        .footer { background-color: #f9fafb; border-top: 1px solid #e5e7eb; padding: 24px 30px; text-align: center; font-size: 12px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">SN</div>
            <h1>SchoolNote</h1>
            <p>Bulletin disponible</p>
        </div>

        <div class="body">
            <p class="greeting">Bonjour {{ $destinataire->prenom }} {{ $destinataire->nom }},</p>

            @if ($destinataire->id !== $eleve->id)
                <p class="text">
                    Le bulletin scolaire du semestre <strong>{{ $semestre }}</strong> de votre enfant
                    <strong>{{ $eleve->prenom }} {{ $eleve->nom }}</strong> est maintenant disponible.
                </p>
            @else
                <p class="text">
                    Votre bulletin scolaire du semestre <strong>{{ $semestre }}</strong> est maintenant disponible.
                    Vous pouvez le consulter et le télécharger depuis votre espace.
                </p>
            @endif

            <div class="info-box">
                <div class="info-row">
                    <span class="info-label">Élève</span>
                    <span class="info-value">{{ $eleve->prenom }} {{ $eleve->nom }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Classe</span>
                    <span class="info-value">{{ $classe->nom }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Semestre</span>
                    <span class="info-value">Semestre {{ $semestre }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Année scolaire</span>
                    <span class="info-value">{{ $classe->annee_scolaire }}</span>
                </div>
            </div>

            @if ($destinataire->id !== $eleve->id)
                <a href="{{ config('app.url') }}/parent/enfants/{{ $eleve->id }}/bulletin?semestre={{ $semestre }}" class="btn">
                    Voir le bulletin →
                </a>
            @else
                <a href="{{ config('app.url') }}/eleve/bulletin?semestre={{ $semestre }}" class="btn">
                    Voir mon bulletin →
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