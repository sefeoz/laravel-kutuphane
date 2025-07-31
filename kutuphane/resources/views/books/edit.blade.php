@extends('books.layout')

@section('content')
<div class="container">
    <h1>Kitap Düzenle</h1>
    <form action="{{route('books.update', $book->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="kitap_adi">Kitap Adı</label>
            <input type="text" class="form-control" id="kitap_adi" name="kitap_adi" value="{{$book->kitap_adi}}">
        </div>
        <div class="form-group">
            <label for="yazar">Yazar</label>
            <input type="text" class="form-control" id="yazar" name="yazar" value="{{$book->yazar}}">
        </div>
        <div class="form-group">
            <label for="ISBN">ISBN</label>
            <input type="text" class="form-control" id="ISBN" name="ISBN" value="{{$book->ISBN}}">
        </div>
        <div class="form-group">
            <label for="image">Resim</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>
        <button type="submit" class="btn btn-primary">Kaydet</button>
        <a href="{{route('books.index')}}" class="btn btn-secondary">Geri Dön</a>
    </form>
</div>
@endsection