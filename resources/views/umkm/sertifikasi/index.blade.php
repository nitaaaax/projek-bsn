@extends('layout.app')

@section('content')
<style>
thead {
  background-color: #d4edda;
  color: #155724;
}
.table-responsive {
  overflow-x: unset !important;
}
</style>

<div class="container mt-4">
  <div class="card shadow-sm border-0">
    <div class="card-body">
      <h3 class="mb-4 text-primary">
        <i class="fa fa-certificate"></i> Data UMKM Tersertifikasi
      </h3>

      <div class="table-responsive">
        <table id="sertifikasiTable" class="table table-hover table-bordered align-middle text-center">
          <thead class="table-success">
            <tr>
              <th>No</th>
              <th>Nama Pelaku</th>
              <th>Produk</th>
              <th>Status Pembinaan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($items as $item)
              @php
                $role = optional(Auth::user()->role)->name;
                $isSertif = $item->status_pembinaan === 'SPPT SNI (TERSERTIFIKASI)';
              @endphp
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="text-start">{{ $item->nama_pelaku }}</td>
                <td>{{ $item->produk }}</td>
                <td>
                  <span class="badge {{ $isSertif ? 'bg-success' : 'bg-secondary' }}">
                    {{ $item->status_pembinaan }}
                  </span>
                </td>
                <td>
                  @if($role === 'user')
                    <a href="{{ route('user.umkm.showuser', $item->id) }}#top" class="btn btn-info btn-sm" title="Detail">
                      <i class="fa fa-eye"></i>
                    </a>
                  @endif

                  @if($role === 'admin')
                    <a href="{{ route('admin.sertifikasi.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit">
                      <i class="fa fa-edit"></i>
                    </a>
                  @endif

                  <a href="{{ route('umkm.export.word.single', $item->id) }}" class="btn btn-success btn-sm" title="Download">
                    <i class="fa fa-download"></i>
                  </a>

                  @if($role === 'admin')
                    <form action="{{ route('admin.sertifikasi.destroy', $item->id) }}" method="POST" class="d-inline delete-form">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                        <i class="fa fa-trash"></i>
                      </button>
                    </form>
                  @endif
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
  $(document).ready(function () {
    // Matikan warning DataTables
    $.fn.dataTable.ext.errMode = 'none';

    $('#sertifikasiTable').DataTable({
      language: {
        search: "Cari:",
        lengthMenu: "Tampilkan _MENU_ entri",
        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
        paginate: {
          previous: '<i class="fa fa-chevron-left"></i>',
          next: '<i class="fa fa-chevron-right"></i>'
        },
        emptyTable: "Belum ada UMKM tersertifikasi.",
        zeroRecords: "Tidak ditemukan data yang cocok."
      },
      responsive: true,
      columnDefs: [
        { orderable: false, targets: [4] } // kolom aksi tidak di-sort
      ]
    });

    // Konfirmasi hapus
    document.querySelectorAll('.delete-form').forEach(form => {
      form.addEventListener('submit', function (e) {
        e.preventDefault();
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
            this.submit();
          }
        });
      });
    });
  });
</script>
@endpush
