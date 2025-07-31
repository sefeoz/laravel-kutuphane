@extends('users.layout')

@section('content')
<div class="container">
    <h1>Kullanıcı Düzenle</h1>
    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('users.update', $user->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Adı</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                </div>
                <div class="form-group">
                    <label for="password">Şifre (Boş bırakılırsa değişmez)</label>
                    <input type="password" name="password" class="form-control" placeholder="Yeni şifre girin">
                </div>
                <div class="form-group">
                    <label for="role">Rol</label>
                    <select name="role" class="form-control">
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Kaydet</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">İptal</a>
            </form>
        </div>
    </div>
</div>
@endsection