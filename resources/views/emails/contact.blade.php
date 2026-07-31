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
        .info-box { background-color: #f3f4f6; border-radius: 10px; padding: 24px; margin-bottom: 24px; }
        .info-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #e5e7eb; font-size: 14px; }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: #6b7280; font-weight: 500; }
        .info-value { color: #1f2937; font-weight: 600; }
        .message-box { background-color: #fffbeb; border: 1px solid #fde68a; border-radius: 10px; padding: 20px; font-size: 14px; line-height: 1.6; color: #374151; }
        .footer { background-color: #f9fafb; border-top: 1px solid #e5e7eb; padding: 24px 30px; text-align: center; font-size: 12px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">SN</div>
            <h1>SchoolNote</h1>
            <p>Nouveau message de contact</p>
        </div>

        <div class="body">
            <div class="info-box">
                <div class="info-row">
                    <span class="info-label">Nom</span>
                    <span class="info-value">{{ $nom }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Sujet</span>
                    <span class="info-value">{{ $sujet }}</span>
                </div>
            </div>

            <p style="font-size: 13px; color: #6b7280; margin-bottom: 12px;">Message :</p>
            <div class="message-box">
                {{ $message }}
            </div>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} SchoolNote — INT Éducation Paris</p>
            <p style="margin-top: 4px;">Répondre directement à cet email pour contacter {{ $nom }}.</p>
        </div>
    </div>
</body>
</html>