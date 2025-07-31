@extends('layout.app')

@section('content')
<div class="container">
    <h4>Daftar User</h4>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-2">Tambah User</a>
    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
