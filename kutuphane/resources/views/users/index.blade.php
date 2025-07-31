@extends("users.layout")    
@section("content")
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Geri Dön</a>
        <h1>Kullanıcılar</h1>
        <a href="{{ route('users.create') }}" class="btn btn-primary">Kullanıcı Ekle</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>İsim</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Oluşturulma Tarihi</th>
                <th>Güncellenme Tarihi</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->created_at }}</td>
                <td>{{ $user->updated_at }}</td>
                <td>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Düzenle</a>
                    <form action="{{ route('users.destroy', $user->id) }}" method="post" class="d-inline">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-danger">Sil</button>
                    </form>
                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-info">Görüntüle</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection