<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoş Geldiniz</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif; }
    </style>
    </head>
<body>
    <h2>Merhaba, {{ $user->name }} 👋</h2>
    <p>Kayıt işleminiz başarıyla tamamlandı. Kutuphane uygulamasına hoş geldiniz.</p>
    <p>Giriş yapmak için uygulamayı ziyaret edebilirsiniz.</p>
    <hr>
    <p style="color:#666; font-size:12px;">Bu e-posta otomatik olarak gönderilmiştir. Lütfen yanıtlamayınız.</p>
</body>
</html>


