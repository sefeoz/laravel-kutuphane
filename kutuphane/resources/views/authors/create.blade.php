@extends('authors.layout')
@section('content')
<div class="container">
    <h1>Yazar Ekle</h1>
    <form action="{{ route('authors.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Yazar Adı</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <button type="submit" class="btn btn-primary">Ekle</button>
    </form>
</div>
@endsection