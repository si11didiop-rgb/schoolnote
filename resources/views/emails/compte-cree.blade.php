<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f9fafb;
            margin: 0;
            padding: 0;
            color: #374151;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        }
        .header {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            padding: 40px 30px;
            text-align: center;
        }
        .header .logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background-color: rgba(255,255,255,0.2);
            border-radius: 10px;
            font-weight: bold;
            font-size: 18px;
            color: white;
            margin-bottom: 12px;
        }
        .header h1 {
            color: white;
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        .header p {
            color: rgba(255,255,255,0.8);
            margin: 8px 0 0 0;
            font-size: 14px;
        }
        .body {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 16px;
        }
        .text {
            font-size: 14px;
            line-height: 1.6;
            color: #6b7280;
            margin-bottom: 24px;
        }
        .credentials {
            background-color: #f3f4f6;
            border-radius: 10px;
            padding: 24px;
            margin-bottom: 24px;
        }
        .credentials h3 {
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #9ca3af;
            margin: 0 0 16px 0;
        }
        .credential-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }
        .credential-row:last-child {
            border-bottom: none;
        }
        .credential-label {
            color: #6b7280;
            font-weight: 500;
        }
        .credential-value {
            color: #1f2937;
            font-weight: 600;
        }
        .credential-value.password {
            background-color: #e0e7ff;
            color: #4338ca;
            padding: 4px 10px;
            border-radius: 6px;
            font-family: monospace;
            font-size: 15px;
        }
        .role-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .role-administrateur { background-color: #e0e7ff; color: #4338ca; }
        .role-enseignant { background-color: #d1fae5; color: #065f46; }
        .role-eleve { background-color: #fef3c7; color: #92400e; }
        .role-parent { background-color: #fce7f3; color: #9d174d; }
        .btn {
            display: block;
            text-align: center;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: white;
            text-decoration: none;
            padding: 14px 24px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            margin-bottom: 24px;
        }
        .warning {
            background-color: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 8px;
            padding: 14px;
            font-size: 13px;
            color: #92400e;
            margin-bottom: 24px;
        }
        .footer {
            background-color: #f9fafb;
            border-top: 1px solid #e5e7eb;
            padding: 24px 30px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
        }
    </style>
</head>
<body>
    <div class="container">

        <!-- En-tête -->
        <div class="header">
            <div class="logo">SN</div>
            <h1>SchoolNote</h1>
            <p>Plateforme de gestion scolaire</p>
        </div>

        <!-- Corps -->
        <div class="body">
            <p class="greeting">Bonjour {{ $user->prenom }} {{ $user->nom }},</p>

            <p class="text">
                Votre compte a été créé sur <strong>SchoolNote</strong>, la plateforme de gestion
                des notes et évaluations de votre établissement.
                Voici vos identifiants de connexion :
            </p>

            <!-- Identifiants -->
            <div class="credentials">
                <h3>Vos identifiants</h3>

                <div class="credential-row">
                    <span class="credential-label">Rôle</span>
                    <span class="role-badge role-{{ $user->role }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>

                <div class="credential-row">
                    <span class="credential-label">Adresse email</span>
                    <span class="credential-value">{{ $user->email }}</span>
                </div>

                <div class="credential-row">
                    <span class="credential-label">Mot de passe</span>
                    <span class="credential-value password">{{ $motDePasse }}</span>
                </div>
            </div>

            <!-- Bouton de connexion -->
            <a href="{{ config('app.url') }}/login" class="btn">
                Se connecter à SchoolNote →
            </a>

            <!-- Avertissement -->
            <div class="warning">
                ⚠️ <strong>Important :</strong> Pour des raisons de sécurité, nous vous recommandons
                de changer votre mot de passe dès votre première connexion via votre espace "Profil".
            </div>

            <p class="text">
                Si vous avez des questions, contactez l'administration de votre établissement.
            </p>
        </div>

        <!-- Pied de page -->
        <div class="footer">
            <p>© {{ date('Y') }} SchoolNote — INT Éducation Paris</p>
            <p style="margin-top: 4px;">
                Cet email a été envoyé automatiquement, merci de ne pas y répondre.
            </p>
        </div>
    </div>
</body>
</html>