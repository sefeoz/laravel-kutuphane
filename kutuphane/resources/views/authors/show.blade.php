@extends('authors.layout')
@section('content')
<div class="container">
    <h1>Yazar Detayı</h1>
    <table class="table">
        <tbody>
            <tr>
                <th scope="row">Yazar Adı</th>
                <td>{{ $author->name }}</td>
            </tr>
            <tr>
                <th scope="row">Kitaplar</th>
                <td>
                    @foreach($author->books as $book)
                    <a href="{{ route('books.show', $book->id) }}" class="btn ">{{ $book->book_name }}</a>
                    <span>|</span>
                    @endforeach
                </td>
            </tr>
        </tbody>
    </table>
    <a href="{{ route('authors.index') }}" class="btn btn-primary">Geri Dön</a>
</div>
@endsection