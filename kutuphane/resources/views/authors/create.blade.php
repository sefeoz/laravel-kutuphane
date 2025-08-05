@extends('yazarlar.layout')
@section('content')
<div class="container">
    <h1>Yazar Ekle</h1>
    <form action="{{ route('yazarlar.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="isim">Yazar Adı</label>
            <input type="text" class="form-control" id="isim" name="isim">
        </div>
        <button type="submit" class="btn btn-primary">Ekle</button>
    </form>
</div>
@endsection