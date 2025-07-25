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
      <div class="mb-4 d-flex gap-2">
        <a href="{{ route('tahap.create.tahap', ['tahap' => 1]) }}" class="btn btn-primary">
          <i class="fa fa-plus mr-1"></i> Tambah UMKM
        </a>
        
        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#importModal">
          Import Excel
        </button>
      </div>

      {{-- Tabel --}}
      <div class="table-responsive">
        <table class="table table-hover table-bordered text-center align-middle">
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
            @forelse ($tahap1 as $t)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="text-start">{{ $t->nama_pelaku }}</td>
                <td>{{ $t->produk }}</td>
                <td>
                  @if (strtolower($t->status) == 'sudah')
                    <span class="badge bg-success">Sudah</span>
                  @elseif(strtolower($t->status) == 'belum')
                    <span class="badge bg-danger">Belum</span>
                  @else
                    <span class="badge bg-secondary">{{ $t->status }}</span>
                  @endif
                </td>
                <td>
                  <a href="{{ route('umkm.show', $t->id) }}" class="btn btn-info btn-sm">
                    <i class="fa fa-eye"></i> Detail
                  </a>

                  <form action="{{ route('umkm.destroy', $t->id) }}" method="POST" class="d-inline delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm btn-delete">
                      <i class="fa fa-trash"></i>
                    </button>
                  </form>

                 <a href="{{ route('umkm.proses.export.word') }}" class="btn btn-success">
                    Export Word
                </a>

                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-muted">Belum ada data.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- Modal Import --}}
      <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <form action="{{ route('umkm.proses.import.excel') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Data UMKM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
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


@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
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
  </script>
@endpush
