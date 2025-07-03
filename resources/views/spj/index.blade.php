@extends('layout.app')

@section('content')
<div class="container mt-4">
  <div class="card">
    <div class="card-body">
      <h2 class="font-weight-bold mb-4">Data SPJ</h2>

      <div class="mb-3">
        <a href="{{ route('spj.create') }}" class="btn btn-primary btn-sm">
          <i class="fa fa-plus"></i> Tambah SPJ
        </a>
      </div>

      <div class="table-responsive">
        <table id="tabelSPJ" class="table table-bordered table-hover table-striped">
          <thead>
            <tr>
              <th>Nama SPJ</th>
              <th style="width: 200px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($spj as $item)
              <tr>
                <td>{{ $item->nama_spj }}</td>
                <td>
                <div class="row gx-2">
              <div class="col-auto">
                <a href="{{ route('spj.show', $item->id) }}" class="btn btn-info btn-sm">
                  <i class="fa fa-eye"></i> Detail
                </a>
              </div>
              <div class="col-auto">
                <a href="{{ route('spj.edit', $item->id) }}" class="btn btn-warning btn-sm">
                  <i class="fa fa-edit"></i> Edit
                </a>
              </div>
              <div class="col-auto">
                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $item->id }})">
                  <i class="fa fa-trash"></i> Hapus
                </button>
              </div>

              <form id="delete-form-{{ $item->id }}" action="{{ route('spj.destroy', $item->id) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
              </form>
            </div>

              </tr>
            @empty
              <tr>
                <td colspan="2" class="text-center text-muted">Belum ada data SPJ.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
  <!-- Font Awesome CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush

@push('scripts')
  <!-- jQuery dan DataTables -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

  <!-- Konfirmasi hapus -->
  <script>
    function confirmDelete(id) {
      if (confirm("Yakin ingin menghapus data ini?")) {
        document.getElementById('delete-form-' + id).submit();
      }
    }
  </script>

  <!-- Aktifkan DataTable -->
  <script>
    $(document).ready(function () {
      $('#tabelSPJ').DataTable({
        lengthChange: false,
        order: [[0, 'asc']], // Urutkan default berdasarkan kolom pertama
        language: {
          search: "Cari:",
          searchPlaceholder: "Ketik untuk mencari...",
          zeroRecords: "Data tidak ditemukan.",
          info: "Menampilkan START - END dari TOTAL data",
          infoEmpty: "Menampilkan 0 dari 0 data",
          emptyTable: "Tidak ada data yang tersedia",
          paginate: {
            previous: "← Sebelumnya",
            next: "Berikutnya →"
          }
        }
      });
    });
  </script>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
