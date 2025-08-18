@extends('books.layout')

@section('content')
<div class="container">
    <h1>Kitap Düzenle</h1>
    <form action="{{route('books.update', $book->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label for="kitap_adi">Kitap Adı</label>
            <input type="text" class="form-control" id="kitap_adi" name="name" value="{{$book->name}}">
        </div>
        <div class="form-group mb-3">
            <label for="yazar">Yazar</label>
           <select name="author_id" class="form-control">
            @foreach($authors as $author)
            <option value="{{$author->id}}" {{$book->author_id == $author->id ? 'selected' : ''}}>{{$author->name}}</option>
            @endforeach
           </select>
        </div>
        <div class="form-group mb-3">
            <label for="ISBN">ISBN</label>
            <input type="text" class="form-control" id="ISBN" name="ISBN" value="{{$book->ISBN}}">
        </div>
        <div class="form-group mb-3">
            <label for="image">Resim</label>
            <input type="file" class="form-control" id="image" name="image">
            @if($book->image)
                <small class="text-muted">Mevcut resim: {{$book->image}}</small>
            @endif
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
                            <input type="checkbox" name="stores[{{$store->id}}][attach]" value="1" class="form-check-input" id="store_{{$store->id}}"
                                   {{$book->stores->contains($store->id) ? 'checked' : ''}}>
                            <label class="form-check-label" for="store_{{$store->id}}">
                                <strong>{{$store->name}}</strong> - {{$store->address}}
                            </label>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <input type="number" name="stores[{{$store->id}}][price]" placeholder="Fiyat (TL)" class="form-control" step="0.01"
                                       value="{{$book->stores->find($store->id)?->pivot->price ?? ''}}">
                            </div>
                            <div class="col-md-4">
                                <input type="number" name="stores[{{$store->id}}][stock]" placeholder="Stok Adedi" class="form-control" min="0"
                                       value="{{$book->stores->find($store->id)?->pivot->stock ?? ''}}">
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input type="checkbox" name="stores[{{$store->id}}][is_active]" value="1" class="form-check-input"
                                           {{$book->stores->find($store->id)?->pivot->is_active ? 'checked' : ''}}>
                                    <label class="form-check-label">Aktif</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <button type="submit" class="btn btn-primary">Kaydet</button>
        <a href="{{route('books.index')}}" class="btn btn-secondary">Geri Dön</a>
    </form>
</div>
@endsection