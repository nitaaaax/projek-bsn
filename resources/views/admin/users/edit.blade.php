@extends('layout.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm rounded-4">
        <div class="card-header bg-warning text-dark rounded-top-4">
            <h5 class="mb-0">Edit Akun</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" value="{{ $user->username }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
                    <input type="password" class="form-control" name="password">
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role_id" class="form-control" required>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
