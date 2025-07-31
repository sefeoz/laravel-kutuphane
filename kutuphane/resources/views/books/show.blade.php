@extends('books.layout')

@section('content')
<div class="container">
    <h1>Kitap Detayı</h1>
    <div class="row">
        
    </div>
    <table class="table">
  <tbody>
    <tr>
      <th scope="row">Kitap Adı</th>
      <td>{{$book->kitap_adi}}</td>
    </tr>
    <tr>
        <tr>
            <th scope="row">Yazar</th>
            <td>{{$book->yazar->isim}}</td>
        </tr>
        <tr>
      <th scope="row">ISBN</th>
      <td>{{$book->ISBN}}</td>
    </tr>
    <tr>
            <th scope="row">Resim</th>
            <td><img src="{{asset('storage/'.$book->image)}}" alt="Resim" class="img-fluid"></td>
        </tr>
    </tr>
  </tbody>
</table>
    <a href="{{route('books.index')}}" class="btn btn-primary">Geri Dön</a>
    
    @if(auth()->user()->favoriteBooks->contains($book->id))
        <form action="{{ route('books.removeFromFavorite', $book->id) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">❤️ Favorilerden Kaldır</button>
        </form>
    @else
        <form action="{{ route('books.addToFavorite', $book->id) }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-success">🤍 Favoriye Ekle</button>
        </form>
    @endif
</div>
@endsection