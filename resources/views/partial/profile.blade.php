@extends('layout.app') {{-- Sesuaikan dengan layout kamu --}}

@section('content')
<div class="container mt-5">
    <div class="box shadow p-4 rounded bg-white mx-auto" style="max-width: 700px;">
        <h2 class="text-center mb-4 fw-bold">Profil Anda</h2>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Username</label>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Password Baru <small class="text-muted">(biarkan kosong jika tidak ingin ubah)</small></label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
