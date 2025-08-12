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
            <input type="text" name="book_name" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="yazar">Yazar</label>
            <select name="author_id" class="form-control" required>
                <option value="">Yazar Seçin</option>
                    @foreach($authors as $author)
                <option value="{{$author->id}}">{{$author->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="ISBN">ISBN</label>
            <input type="text" name="ISBN" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="image">Resim</label>
            <input type="file" name="image" class="form-control">
        </div>
        
        <div class="form-group mb-3">
            <label>Satış Yerleri</label>
            @if($stores->count() === 0)
                <div class="alert alert-warning">Henüz satış yeri yok. Önce mağaza ekleyin.</div>
            @endif
            @foreach($stores as $store)
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="form-check">
                            <input type="checkbox" name="stores[{{$store->id}}][attach]" value="1" class="form-check-input" id="store_{{$store->id}}">
                            <label class="form-check-label" for="store_{{$store->id}}">
                                <strong>{{$store->name}}</strong> - {{$store->address}}
                            </label>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <input type="number" name="stores[{{$store->id}}][price]" placeholder="Fiyat (TL)" class="form-control" step="0.01">
                            </div>
                            <div class="col-md-4">
                                <input type="number" name="stores[{{$store->id}}][stock]" placeholder="Stok Adedi" class="form-control" min="0">
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input type="checkbox" name="stores[{{$store->id}}][is_active]" value="1" class="form-check-input" checked>
                                    <label class="form-check-label">Aktif</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <button type="submit" class="btn btn-primary">Kaydet</button>
        <a href="{{ route('books.index') }}" class="btn btn-secondary">İptal</a>
    </form>
</div>
@endsection