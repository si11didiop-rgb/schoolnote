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
        .info-box h3 { font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #065f46; margin: 0 0 16px 0; }
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
            <p>Nouvelle affectation</p>
        </div>

        <div class="body">
            <p class="greeting">Bonjour {{ $enseignant->prenom }} {{ $enseignant->nom }},</p>

            <p class="text">
                Vous avez été affecté(e) à une nouvelle matière dans le cadre de l'année scolaire
                <strong>{{ $affectation->classe->annee_scolaire }}</strong>.
            </p>

            <div class="info-box">
                <h3>Détails de l'affectation</h3>
                <div class="info-row">
                    <span class="info-label">Matière</span>
                    <span class="info-value">{{ $affectation->matiere->nom }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Coefficient</span>
                    <span class="info-value">{{ $affectation->matiere->coefficient }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Classe</span>
                    <span class="info-value">{{ $affectation->classe->nom }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Niveau</span>
                    <span class="info-value">{{ $affectation->classe->niveau }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Effectif</span>
                    <span class="info-value">{{ $affectation->classe->afficherEffectif() }} élève(s)</span>
                </div>
            </div>

            <a href="{{ config('app.url') }}/enseignant/dashboard" class="btn">
                Accéder à mon espace →
            </a>

            <p class="text">
                Vous pouvez dès maintenant consulter votre classe et planifier vos évaluations
                depuis votre espace enseignant.
            </p>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} SchoolNote — INT Éducation Paris</p>
            <p style="margin-top: 4px;">Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
        </div>
    </div>
</body>
</html>