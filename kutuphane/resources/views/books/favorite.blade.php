@extends('books.layout')
@section('content')
<div class="container">
    <h1>Favori Kitaplarım</h1>
    <div>
        <a href="{{route('dashboard')}}" class="btn btn-primary">Geri Dön</a>
    </div>
    <div class="row">
        @foreach($favoriteBooks as $book)
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $book->book_name }}</h5>
                    <p class="card-text">{{ $book->author->name }}</p>
                    <a href="{{ route('books.show', $book->id) }}" class="btn btn-primary">Detaylar</a>
                    <form action="{{ route('books.removeFromFavorite', $book->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Favorilerden Kaldır</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection