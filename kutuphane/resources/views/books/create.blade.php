@extends('books.layout')
@section('content')
<div class="container">
    <h1>Kitap Ekle</h1>
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-3">
            <label for="kitap_adi">Kitap Adı</label>
            <input type="text" name="kitap_adi" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="yazar">Yazar</label>
            <input type="text" name="yazar" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="ISBN">ISBN</label>
            <input type="text" name="ISBN" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="image">Resim</label>
            <input type="file" name="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Kaydet</button>
        <a href="{{ route('books.index') }}" class="btn btn-secondary">İptal</a>
    </form>
</div>
@endsection