@extends('yazarlar.layout')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <a href="{{route('dashboard')}}" class="btn btn-secondary">Geri Dön</a>
          <h1>Yazarlar</h1>
    <a href="{{ route('yazarlar.create') }}" class="btn btn-primary">Yazar Ekle</a>
    </div>
  
    
    <table class="table">
        <thead>
            <tr>
                <th>Yazar Adı</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            @foreach($yazarlar as $yazar)
            <tr>
                <td>{{ $yazar->isim }}</td>
                <td>
                    <a href="{{ route('yazarlar.show', $yazar->id) }}" class="btn btn-primary">Detay</a>
                    <a href="{{ route('yazarlar.edit', $yazar->id) }}" class="btn btn-primary">Düzenle</a>
                    <form action="{{ route('yazarlar.destroy', $yazar->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
            </tr>
            @endforeach
        </tbody>
</table>
</div>
@endsection