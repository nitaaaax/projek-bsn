@extends('layout.app')

@section('content')
<style>
/* Anda dapat menjaga thead styling jika diinginkan */
thead {
  background-color: #d4edda;
  color: #155724;
}
/* Baris ini TIDAK ADA di sini, dan itu bagus karena tidak menghambat responsivitas DataTables */
/* .table-responsive {
  overflow-x: unset !important;
} */
</style>

<div class="container mt-4">
  <div class="card shadow-sm border-0">
    <div class="card-body">
      <h3 class="mb-4 text-primary">
        <i class="fa fa-certificate"></i> Data UMKM Tersertifikasi
      </h3>

      <div class="table-responsive"> {{-- Biarkan kelas ini untuk DataTables Responsive --}}
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
            @forelse($items ?? [] as $item) {{-- Pastikan $items tidak null --}}
              @php
                $role = optional(Auth::user()->role)->name;
                $isSertif = $item->status_pembinaan === 'SPPT SNI (TERSERTIFIKASI)';
              @endphp
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="text-start">{{ $item->nama_pelaku ?? '-' }}</td> {{-- Tambah null coalescing --}}
                <td>{{ $item->produk ?? '-' }}</td> {{-- Tambah null coalescing --}}
                <td>
                  <span class="badge {{ $isSertif ? 'bg-success' : 'bg-secondary' }}">
                    {{ $item->status_pembinaan ?? '-' }}
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

@push('styles')
{{-- DataTables CSS --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
{{-- DataTables Bootstrap 5 CSS (untuk styling DataTables agar cocok dengan Bootstrap) --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
{{-- DataTables Responsive CSS (penting untuk responsivitas di layar kecil) --}}
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
{{-- Font Awesome untuk ikon --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" xintegrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0x0zNyXfUaJ/gL7vX7+P/xM/uJ+fR/M+xT1pQ8/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@push('scripts')
{{-- JQuery (DataTables membutuhkan ini) --}}
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
{{-- SweetAlert2 untuk notifikasi --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- DataTables Core JS --}}
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
{{-- DataTables Bootstrap 5 JS (untuk integrasi dengan Bootstrap 5) --}}
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
{{-- DataTables Responsive Core JS (penting untuk fungsionalitas responsif) --}}
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
{{-- DataTables Responsive Bootstrap 5 JS (untuk styling responsif agar cocok dengan Bootstrap) --}}
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>


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
      responsive: true, // FITUR RESPONSIVE DATATABLES AKAN MENYEMBUNYIKAN KOLOM KE DALAM DETAIL BARIS
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
