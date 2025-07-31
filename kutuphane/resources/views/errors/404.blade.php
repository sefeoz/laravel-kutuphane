<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <title>404 - Sayfa Bulunamadı</title>
</head>
<body>
    <div class="container">
        <h1>404 - Sayfa Bulunamadı</h1>
        <p>Aradığınız sayfa veya kayıt bulunamadı. Lütfen URL'yi kontrol edin veya ana sayfaya dönün.</p>
        <a href="{{ route('books.index') }}" class="btn btn-primary">Ana Sayfaya Dön</a>
    </div>
</body>
</html>