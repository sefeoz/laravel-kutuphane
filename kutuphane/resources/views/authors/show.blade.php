@extends('yazarlar.layout')
@section('content')
<div class="container">
    <h1>Yazar Detayı</h1>
    <table class="table">
        <tbody>
            <tr>
                <th scope="row">Yazar Adı</th>
                <td>{{ $yazar->isim }}</td>
            </tr>
            <tr>
                <th scope="row">Kitaplar</th>
                <td>
                    @foreach($yazar->books as $book)
                    <a href="{{ route('books.show', $book->id) }}" class="btn ">{{ $book->kitap_adi }}</a>
                    <span>|</span>
                    @endforeach
                </td>
            </tr>
        </tbody>
    </table>
    <a href="{{ route('yazarlar.index') }}" class="btn btn-primary">Geri Dön</a>
</div>
@endsection