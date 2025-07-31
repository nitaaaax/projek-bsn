@extends('layout.app')

@section('content')
<div class="container mt-4">
  <div class="card shadow-sm">
    <div class="card-body">

      {{-- Judul dan Tombol Tambah Akun --}}
      <div class="mb-2">
        <h4 class="fw-bold mb-0">Daftar Akun</h4>
      </div>
      <div class="mb-3">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
          <i class="fa fa-plus"></i> Tambah Akun
        </a>
      </div>

      {{-- Flash Message --}}
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      {{-- Search di kanan atas tabel, sejajar dengan judul kolom Aksi --}}
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
              <th>Nama</th>
              <th>Email</th>
              <th>Role</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($users as $user)
            <tr>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->role->name }}</td>
              <td class="text-center">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning me-1">
                  <i class="fa fa-edit"></i>
                </a>
                <button onclick="confirmDelete({{ $user->id }})" class="btn btn-sm btn-danger">
                  <i class="fa fa-trash"></i>
                </button>
                <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-none">
                  @csrf
                  @method('DELETE')
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
@endpush
