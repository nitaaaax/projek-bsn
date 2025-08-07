@extends('layout.app')

@section('content')
<div class="container my-5">
  <div class="card shadow-sm">
    <div class="card-body">

      {{-- Judul dan Tombol Tambah Akun --}}
      <div class="mb-2">
        <h4 class="fw-bold mb-0">Role Manajement</h4>
      </div>
      <div class="mb-3">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
          <i class="fa fa-plus"></i> Tambah Akun
        </a>
      </div>

      {{-- Search --}}
      <div class="d-flex justify-content-end mb-2">
        <form action="{{ route('admin.users.index') }}" method="GET" class="d-flex" style="width: 250px;">
          <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Cari nama/email..." value="{{ request('search') }}">
          <button class="btn btn-sm btn-outline-primary" type="submit">Cari</button>
        </form>
      </div>

      {{-- Tabel --}}
      <div class="table-responsive">
        <table class="table table-bordered align-middle">
          <thead class="bg-light text-dark text-center fw-bold">
            <tr>
              <th>Username</th>
              <th>Email</th>
              <th>Role</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($users as $user)
            <tr>
              <td>{{ $user->username }}</td>
              <td>{{ $user->email }}</td>
              <td>
                <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST">
                  @csrf
                  <select name="role_id" onchange="this.form.submit()" class="form-select form-select-sm" {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                    @foreach(App\Models\Role::all() as $role)
                      <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                      </option>
                    @endforeach
                  </select>
                </form>
              </td>
              <td class="text-center">
                {{-- Tombol Hapus --}}
                <button onclick="confirmDelete({{ $user->id }})" class="btn btn-sm btn-danger me-1">
                  <i class="fa fa-trash"></i>
                </button>
                <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-none">
                  @csrf
                  @method('DELETE')
                </form>

               <form id="reset-form-{{ $user->id }}" action="{{ route('admin.users.resetPassword', $user->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="button" class="btn btn-sm btn-warning reset-password-btn" data-id="{{ $user->id }}">
                  <i class="fa fa-key"></i>
                </button>
              </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="text-center text-muted">Belum ada data akun.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id) {
  Swal.fire({
    title: 'Yakin ingin menghapus?',
    text: "Data ini tidak bisa dikembalikan!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('delete-form-' + id).submit();
    }
  });
}
</script>

<script>
document.querySelectorAll('.reset-password-btn').forEach(button => {
  button.addEventListener('click', function () {
    const userId = this.dataset.id;

    Swal.fire({
      title: 'Reset Password?',
      text: "Password akan direset ke default!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#ffc107',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Ya, reset!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('reset-form-' + userId).submit();
      }
    });
  });
});
</script>

@endpush
