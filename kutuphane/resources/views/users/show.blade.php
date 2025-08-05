@extends("users.layout")

@section("content")
<div class="container mt-4">
    <a href="{{ route('users.index') }}" class="btn btn-primary">Back</a>
    <h1>User Details</h1>
    <p class="mt-3"><strong>Name:</strong> {{ $user->name }}</p>
    <p class="mt-3"><strong>Email:</strong> {{ $user->email }}</p>
    <p class="mt-3"><strong>Role:</strong> {{ $user->role }}</p>
    <p class="mt-3"><strong>Created At:</strong> {{ $user->created_at }}</p>
    <p><strong>Updated At:</strong> {{ $user->updated_at }}</p>
</div>
@endsection