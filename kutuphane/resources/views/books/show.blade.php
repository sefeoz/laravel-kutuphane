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
      <td>{{$book->name}}</td>
    </tr>
    <tr>
        <tr>
            <th scope="row">Yazar</th>
            <td>{{$book->author->name}}</td>
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

@if($book->stores->count() > 0)
    <h3>Satış Yerleri</h3>
    <div class="row">
        @foreach($book->stores as $store)
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{$store->name}}</h5>
                        <p class="card-text">
                            <strong>Adres:</strong> {{$store->address}}<br>
                            <strong>Telefon:</strong> {{$store->phone}}<br>
                            <strong>Email:</strong> {{$store->email}}<br>
                            <strong>Website:</strong> <a href="{{$store->website}}" target="_blank">{{$store->website}}</a><br>
                            @if($store->pivot->price)
                                <strong>Fiyat:</strong> {{$store->pivot->price}} TL<br>
                            @endif
                            <strong>Stok:</strong> {{$store->pivot->stock ?? 0}} adet<br>
                            <strong>Durum:</strong> {{$store->pivot->is_active ? 'Aktif' : 'Pasif'}}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="alert alert-info">
        Bu kitap henüz hiçbir satış yerinde bulunmuyor.
    </div>
@endif

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