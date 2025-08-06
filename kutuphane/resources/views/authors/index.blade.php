@extends('authors.layout')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        @if(auth()->user()->role === 'admin')
        <a href="{{route('dashboard')}}" class="btn btn-secondary">Geri Dön</a>
        <a href="{{ route('authors.create') }}" class="btn btn-primary">Yazar Ekle</a>
        @endif
        <h1>Yazarlar</h1>
    </div>
  
    
    <table class="table">
        <thead>
            <tr>
                <th>Yazar Adı</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            @foreach($authors as $author)
            <tr>
                <td>{{ $author->name }}</td>
                <td>
                    <a href="{{ route('authors.show', $author->id) }}" class="btn btn-primary">Detay</a>
                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('authors.edit', $author->id) }}" class="btn btn-primary">Düzenle</a>
                    <form action="{{ route('authors.destroy', $author->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Sil</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
</table>
</div>
@endsection