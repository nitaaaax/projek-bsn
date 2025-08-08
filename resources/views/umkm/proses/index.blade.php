@extends('layout.app')

@section('content')
<div class="container mt-4">
  <div class="card border-0 shadow rounded-4">
    <div class="card-body">

      {{-- Judul --}}
      <h3 class="mb-4 text-primary fw-bold">
        <i class="fa fa-database me-2"></i> Data UMKM Proses
      </h3>

      {{-- Tombol Aksi --}}
   <div class="d-flex flex-wrap mb-4">
  @if(optional(Auth::user()->role)->name === 'admin')
    <a href="{{ route('admin.umkm.create', ['tahap' => 1, 'id' => $id ?? null]) }}" class="btn btn-primary mb-2 me-2">
      <i class="fa fa-plus me-1"></i> Tambah UMKM
    </a>
  @endif

  @if(optional(Auth::user()->role)->name === 'admin')
    <button type="button" class="btn btn-warning text-dark mb-2" data-bs-toggle="modal" data-bs-target="#importModal">
      <i class="fa fa-file-import me-1"></i> Import Excel
    </button>
  @endif
</div>




      {{-- Tabel --}}
      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center" id="tabelUMKM">
          <thead class="table-primary">
            <tr>
              <th>No</th>
              <th>Nama Pelaku</th>
              <th>Produk</th>
              <th>Status</th>
              <th>Status Pembinaan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($tahap1 as $t)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="text-start">{{ $t->nama_pelaku }}</td>
                <td>{{ $t->produk }}</td>
                <td><span class="badge bg-secondary">{{ $t->status }}</span></td>
                <td><span class="badge bg-secondary">{{ $t->status_pembinaan }}</span></td>
                <td>
                  @php $role = optional(Auth::user()->role)->name; @endphp
                  @if($role === 'admin')
                    <a href="{{ route('admin.umkm.show', $t->id) }}#top" class="btn btn-warning btn-sm" title="Detail">
                      <i class="fa fa-edit"></i>
                    </a>
                  @endif
                  @if($role === 'user')
                    <a href="{{ route('user.umkm.showuser', $t->id) }}#top" class="btn btn-info btn-sm" title="Detail">
                      <i class="fa fa-eye"></i>
                    </a>
                    @endif
                  <a href="{{ route('umkm.export.word.single', $t->id) }}" class="btn btn-success btn-sm" title="Download">
                    <i class="fa fa-download"></i>
                  </a>
                  @if($role === 'admin')
                    <form action="{{ route('admin.umkm.destroy', $t->id) }}" method="POST" class="d-inline delete-form">
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
              <tr><td colspan="6" class="text-muted">Belum ada data.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- Modal Import --}}
      <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <form action="{{ route('admin.umkm.import') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Data UMKM</h5>
            <button type="button" class="btn btn-sm btn-danger rounded-circle d-flex align-items-center justify-content-center" 
                    style="width: 32px; height: 32px;" 
                    data-bs-dismiss="modal" 
                    aria-label="Close">
                <i class="fa fa-times text-white"></i>
            </button>
              </div>
              <div class="modal-body">
                <div class="mb-3">
                  <label for="file" class="form-label">Pilih file Excel (.xlsx / .xls / .csv)</label>
                  <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Import Sekarang</button>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
  $(document).ready(function () {
  $('#tabelUMKM').DataTable({
    language: {
      search: "Cari:",
      lengthMenu: "Tampilkan _MENU_ data",
      info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
      paginate: {
        previous: '<i class="fa fa-chevron-left"></i>',  // panah kiri
        next: '<i class="fa fa-chevron-right"></i>'      // panah kanan
      },
      zeroRecords: "Tidak ada data ditemukan",
      infoEmpty: "Menampilkan 0 data",
    },
    columnDefs: [
      { orderable: false, targets: [5] }
    ],
    escape: false // penting supaya ikon bisa dirender
  });

  // SweetAlert untuk tombol hapus (tetap sama)
  document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!'
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
