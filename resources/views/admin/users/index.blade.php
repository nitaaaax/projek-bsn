@extends('layout.app')

@section('content')
<div class="container mt-4">
  <h2>Tambah Akun</h2>

  {{-- Notifikasi jika ada error --}}
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.users.store') }}" method="POST">
    @csrf

    <div class="mb-3">
      <label for="name" class="form-label fw-bold">Nama</label>
      <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
    </div>

    <div class="mb-3">
      <label for="username" class="form-label fw-bold">Username</label>
      <input type="text" class="form-control" name="username" value="{{ old('username') }}" required>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label fw-bold">Email</label>
      <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label fw-bold">Password</label>
      <input type="password" class="form-control" name="password" required>
    </div>

    <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select name="role" id="role" class="form-control" required>
            <option value="">-- Pilih Role --</option>
            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
        </select>
    </div>


    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kembali</a>
  </form>
</div>
@endsection
