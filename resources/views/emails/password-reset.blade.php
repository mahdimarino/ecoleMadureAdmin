
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe - École Madaure</title>
</head>
<body style="margin:0; padding:0; background-color:#f3f5f9; font-family:Arial,Helvetica,sans-serif; color:#273449;">

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
       style="background-color:#f3f5f9; padding:35px 12px;">
    <tr>
        <td align="center">

            <table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0"
                   style="width:100%; max-width:600px; background-color:#ffffff; border-radius:12px; overflow:hidden;">

                <!-- Header -->
                <tr>
                    <td align="center" style="background-color:#123b70; padding:32px 24px;">
                        <img src="https://madaureacademy.com/ecollogo.png"
                             alt="École Madaure"
                             width="90"
                             style="display:block; max-width:90px; height:auto; margin:0 auto 14px; border:0;">

                        <h1 style="margin:0; color:#ffffff; font-size:25px; font-weight:700; letter-spacing:0.3px;">
                            École Madaure
                        </h1>

                        <p style="margin:8px 0 0; color:#dce8f8; font-size:13px;">
                            L'excellence au service de votre réussite
                        </p>
                    </td>
                </tr>

                <!-- Main content -->
                <tr>
                    <td style="padding:38px 32px 24px;">

                        <p style="margin:0 0 12px; font-size:16px; line-height:1.7;">
                            Bonjour,
                        </p>

                        <h2 style="margin:0 0 18px; color:#123b70; font-size:23px; line-height:1.4;">
                            Réinitialisation de votre mot de passe
                        </h2>

                        <p style="margin:0 0 18px; color:#596579; font-size:15px; line-height:1.8;">
                            Nous avons reçu une demande de réinitialisation du mot de passe
                            associé à votre compte <strong>École Madaure</strong>.
                        </p>

                        <p style="margin:0 0 28px; color:#596579; font-size:15px; line-height:1.8;">
                            Pour choisir un nouveau mot de passe et retrouver l'accès à votre
                            compte, cliquez sur le bouton ci-dessous.
                        </p>

                        <!-- Reset button -->
                        <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center">
                            <tr>
                                <td align="center" bgcolor="#1769d2" style="border-radius:7px;">
                                    <a href="{{ $url }}"
                                       style="display:inline-block; padding:16px 30px; color:#ffffff; text-decoration:none; font-size:15px; font-weight:bold; border-radius:7px;">
                                        Réinitialiser mon mot de passe
                                    </a>
                                </td>
                            </tr>
                        </table>

                        <!-- Expiration notice -->
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                               style="margin-top:30px; background-color:#fff8e6; border-radius:7px;">
                            <tr>
                                <td style="padding:15px 17px;">
                                    <p style="margin:0; color:#815c13; font-size:13px; line-height:1.7;">
                                        <strong>Important :</strong> ce lien est valable pendant
                                        60 minutes uniquement. Après ce délai, vous devrez
                                        demander un nouveau lien.
                                    </p>
                                </td>
                            </tr>
                        </table>

                        <p style="margin:26px 0 8px; color:#596579; font-size:13px; line-height:1.8;">
                            Si le bouton ne fonctionne pas, copiez et collez le lien suivant
                            dans votre navigateur :
                        </p>

                        <p style="margin:0 0 24px; font-size:12px; line-height:1.8; word-break:break-all;">
                            <a href="{{ $url }}" style="color:#1769d2; text-decoration:underline;">
                                {{ $url }}
                            </a>
                        </p>

                        <p style="margin:0; color:#596579; font-size:14px; line-height:1.8;">
                            Si vous n'êtes pas à l'origine de cette demande, ignorez simplement
                            cet e-mail. Votre mot de passe actuel restera inchangé.
                        </p>

                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="padding:24px 30px; background-color:#f8fafc; border-top:1px solid #e7ebf1;"
                        align="center">

                        <p style="margin:0 0 8px; color:#123b70; font-size:14px; font-weight:bold;">
                            École Madaure
                        </p>

                        <p style="margin:0 0 12px; color:#788397; font-size:12px; line-height:1.8;">
                            Cet e-mail a été envoyé automatiquement dans le cadre de la
                            sécurité de votre compte.
                            <br>
                            Merci de ne pas répondre directement à ce message.
                        </p>

                        <p style="margin:0; color:#9aa3b2; font-size:11px;">
                            © {{ date('Y') }} École Madaure. Tous droits réservés.
                        </p>

                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
