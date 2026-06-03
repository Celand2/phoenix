<!doctype html>
<html lang="fr">
<body style="margin:0;padding:20px;background-color:#FEF8E0;color:#1C1614;font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <table role="presentation" style="width:100%;border-collapse:collapse;">
        <tr>
            <td align="center">
                <div style="max-width:600px;background-color:#ffffff;border-radius:16px;border:1px solid #FCEAA0;overflow:hidden;box-shadow:0 4px 6px rgba(0,0,0,0.05);">
                    <div style="background-color:#A31E1E;padding:24px;text-align:center;">
                        <h2 style="color:#ffffff;margin:0;font-size:24px;font-weight:bold;letter-spacing:1px;">phenix TRADERS</h2>
                    </div>
                    <div style="padding:40px 32px;">
                        <h1 style="color:#1C1614;margin-top:0;font-size:22px;font-weight:800;line-height:1.2;">{{ $notification->title }}</h1>
                        <p style="line-height:1.6;color:#5E504A;font-size:16px;margin-top:20px;">{{ $notification->body }}</p>
                        
                        <div style="margin-top:40px;text-align:center;">
                            <a href="{{ url('/client/dashboard') }}" style="display:inline-block;background-color:#E03030;color:#ffffff;padding:16px 32px;border-radius:12px;text-decoration:none;font-weight:bold;font-size:16px;box-shadow:0 4px 12px rgba(224,48,48,0.3);">
                                Accéder à mon compte
                            </a>
                        </div>
                    </div>
                    <div style="background-color:#F5F0EE;padding:20px;text-align:center;font-size:12px;color:#8C7E78;">
                        <p style="margin:0;">&copy; 2026 phenix Traders Platform. Tous droits réservés.</p>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
