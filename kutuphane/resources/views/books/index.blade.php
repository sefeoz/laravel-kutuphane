@extends('books.layout')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mt-5">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Geri Dön</a>
        <h1>Kitaplar</h1>
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('books.create') }}" class="btn btn-primary">Yeni Kitap Ekle</a>
        @else
            <div></div>
        @endif
    </div>

    <div class="search-container">
        <form action="{{ route('books.search') }}" method="GET">
            <input type="text" name="search" placeholder="Kitap ara">
            <button type="submit" class="btn btn-primary">Ara</button>
            <a href="{{ route('books.index') }}" class="btn btn-secondary">Temizle</a>
        </form>
    </div>
    @if($books->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kitap Adı</th>
                    <th>Yazar</th>
                    <th>ISBN</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $book)
                    <tr>
                        <td>{{ $book->id }}</td>
                        <td>{{ $book->kitap_adi }}</td>
                        <td>{{ $book->yazar }}</td>
                        <td>{{ $book->ISBN }}</td>
                        <td>
                            <a href="{{ route('books.show', $book->id) }}" class="btn btn-info">Detay</a>
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-primary">Düzenle</a>
                                <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Bu kitabı silmek istediğinizden emin misiniz?')">Sil</button>
                                </form>
                            @endif
                            
                            @if(auth()->user()->favoriteBooks->contains($book->id))
                                <form action="{{ route('books.removeFromFavorite', $book->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Favorilerden Kaldır</button>
                                </form>
                            @else
                                <form action="{{ route('books.addToFavorite', $book->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Favoriye Ekle</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">
            <p>Henüz hiç kitap eklenmemiş.</p>
        </div>
    @endif
</div>
@endsection