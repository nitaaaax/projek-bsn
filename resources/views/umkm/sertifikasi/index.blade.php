@extends('layout.app')

@section('content')
<div class="container mt-4">
  <div class="card shadow-sm border-0">
    <div class="card-body">
      <h3 class="mb-4 text-primary">
        <i class="fa fa-certificate"></i> Data UMKM Tersertifikasi
      </h3>
      
      {{-- Tabel --}}
      <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle text-center">
          <thead class="table-primary">
            <tr>
              <th>No</th>
              <th>Nama Pelaku</th>
              <th>Produk</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($tahap1 as $t)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $t->nama_pelaku }}</td>
                <td>{{ $t->produk }}</td>
                <td>
                  @if(strtolower($t->status) === 'tersertifikasi')
                    <span class="badge bg-success">Tersertifikasi</span>
                  @else
                    <span class="badge bg-secondary">{{ $t->status }}</span>
                  @endif
                </td>
                <td>
                 <form action="{{ route('umkm.sertifikasi.destroy', $t->id) }}" method="POST" class="d-inline" id="delete-form-{{ $t->id }}">

                  @csrf
                  @method('DELETE')
                  <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmDelete({{ $t->id }})">
                    <i class="fa fa-trash"></i> Hapus
                  </button>
                </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-muted">Belum ada UMKM tersertifikasi.</td>
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
<script>
  function confirmDelete(id) {
  Swal.fire({
    title: 'Yakin ingin menghapus?',
    text: "Data yang dihapus tidak bisa dikembalikan!",
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
