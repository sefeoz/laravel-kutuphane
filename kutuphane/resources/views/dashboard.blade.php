<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Dashboard</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Kutuphane</a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    Hoşgeldin, {{ Auth::user()->name }}!
                </span>
                <span class="badge badge-primary me-3 text-white">{{Auth::user()->role}}</span>
                <form action="{{ route('logout') }}" method="post" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Çıkış Yap</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h1>Dashboard</h1>
                <p>Kütüphane yönetim sistemine hoşgeldiniz!</p>
                <div class="row mt-4">
                    <div class="col-md-4 {{Auth::user()->role === 'admin' ? '' : 'd-none'}}">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Kullanıcılar</h5>
                                <p class="card-text">Kullanıcıları görüntüle ve yönet</p>
                                <a href="{{ route('users.index') }}" class="btn btn-primary">Kullanıcılara Git</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Kitaplar</h5>
                                <p class="card-text">Kitap koleksiyonunu yönet</p>
                                <a href="{{ route('books.index') }}" class="btn btn-primary">Kitapları Görüntüle</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Favori Kitaplarım</h5>
                                <p class="card-text">Favori Kitaplarımı Görüntüle</p>
                                <a href="{{ route('books.favorite') }}" class="btn btn-primary ">Favori Kitaplarımı Görüntüle</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>