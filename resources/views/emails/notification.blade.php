<!doctype html>
<html lang="fr">
<body style="margin:0;background:#1C1614;color:#F5F0EE;font-family:Arial,sans-serif;">
    <div style="max-width:560px;margin:0 auto;padding:32px;">
        <h1 style="color:#E8B020;">{{ $notification->title }}</h1>
        <p style="line-height:1.6;">{{ $notification->body }}</p>
        <a href="{{ url('/client/dashboard') }}" style="display:inline-block;margin-top:16px;background:#E03030;color:white;padding:12px 18px;border-radius:8px;text-decoration:none;">Ouvrir le dashboard</a>
    </div>
</body>
</html>
