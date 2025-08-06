@extends('authors.layout')
@section('content')
<div class="container">
    <h1>Yazar Düzenle</h1>
    <form action="{{ route('authors.update', $author->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Yazar Adı</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $author->name }}">
        </div>
        <button type="submit" class="btn btn-primary">Güncelle</button>
    </form>
</div>
@endsection