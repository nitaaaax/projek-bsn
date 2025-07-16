@extends('layout.app')

@section('content')
<div class="container mt-4">
  <div class="card shadow-sm">
    <div class="card-body">
      
      {{-- Judul --}}
      <h3 class="mb-3">Data UMKM Proses</h3>

      {{-- Tombol Aksi di Bawah Judul --}}
      <div class="mb-4">
        <a href="{{ route('tahap.create.tahap', ['tahap' => 1]) }}" class="btn btn-primary me-2">
          <i class="fa fa-plus me-1"></i> Tambah UMKM
        </a>
        <a href="{{ route('umkm.proses.exportWord') }}" class="btn btn-success">
          <i class="fa fa-download me-1"></i> Export
        </a>
      </div>

      {{-- Tabel Data --}}
      <div class="table-responsive mt-3">
        <table class="table table-bordered table-striped align-middle text-center">
          <thead class="table-light">
            <tr>
              <th>No</th>
              <th>Nama Pelaku</th>
              <th>Produk</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($data as $item)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nama_pelaku }}</td>
                <td>{{ $item->produk }}</td>
                <td>{{ $item->status }}</td>
                <td>
                  <a href="{{ route('umkm.show', $item->id) }}" class="btn btn-info btn-sm">Detail</a>

                  <form action="{{ route('umkm.destroy', $item->id) }}" method="POST" class="d-inline delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm btn-delete">Hapus</button>
                  </form>
                </td>
              </tr>
            @endforeach
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
  document.addEventListener("DOMContentLoaded", function () {
    const deleteForms = document.querySelectorAll(".delete-form");

    deleteForms.forEach(form => {
      form.addEventListener("submit", function (e) {
        e.preventDefault(); // Cegah submit langsung

        Swal.fire({
          title: 'Yakin ingin menghapus?',
          text: "Data tidak bisa dikembalikan!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Ya, hapus!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit(); // Submit kalau konfirmasi OK
          }
        });
      });
    });
  });
</script>
@endpush
