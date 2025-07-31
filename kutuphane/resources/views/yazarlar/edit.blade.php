@extends('yazarlar.layout')
@section('content')
<div class="container">
    <h1>Yazar Düzenle</h1>
    <form action="{{ route('yazarlar.update', $yazar->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="isim">Yazar Adı</label>
            <input type="text" class="form-control" id="isim" name="isim" value="{{ $yazar->isim }}">
        </div>
        <button type="submit" class="btn btn-primary">Güncelle</button>
    </form>
</div>
@endsection