@extends('layout.app')

@section('content')
<div class="container mt-4">
  <div class="card border-0 shadow rounded-4">
    <div class="card-body">
      
      {{-- Judul --}}
      <h3 class="mb-4 text-primary fw-bold"><i class="fa fa-database me-2"></i>Data UMKM Proses</h3>

      {{-- Tombol Aksi --}}
      <div class="mb-4">
  <a href="{{ route('tahap.create.tahap', ['tahap' => 1]) }}" class="btn btn-primary mr-2">
    <i class="fa fa-plus mr-1"></i> Tambah UMKM
  </a>
  <a href="{{ route('umkm.proses.exportWord') }}" class="btn btn-success">
    <i class="fa fa-download mr-1"></i> Export
  </a>
</div>



      {{-- Judul dan Tombol Aksi --}}
      <div class="row mb-4 align-items-center">
        <div class="col-md-6">
          <h2 class="fw-bold mb-3">Data UMKM</h2>
          <div class="d-flex gap-2">
            <a href="{{ route('tahap.create.tahap', ['tahap' => 1]) }}" class="btn btn-primary btn-sm">
              <i class="fa fa-plus me-1"></i> Tambah UMKM
            </a>
            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#importModal">
              Import Excel
            </button>
          </div>
        </div>
      </div>
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
            </tr>
          </thead>
          <tbody>
            @forelse ($data as $item)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="text-start">{{ $item->nama_pelaku }}</td>
                <td>{{ $item->produk }}</td>
                <td>
                  @if (strtolower($item->status) == 'sudah')
                    <span class="badge bg-success">Sudah</span>
                  @elseif(strtolower($item->status) == 'belum')
                    <span class="badge bg-danger">Belum</span>
                  @else
                    <span class="badge bg-secondary">{{ $item->status }}</span>
                  @endif
                </td>
                <td>
                  <a href="{{ route('umkm.show', $item->id) }}" class="btn btn-info btn-sm">
                    <i class="fa fa-eye"></i>
                  </a>

                  <form action="{{ route('umkm.destroy', $item->id) }}" method="POST" class="d-inline delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm btn-delete">
                      <i class="fa fa-trash"></i>
                    </button>
                  <a href="{{ route('umkm.show', $t->id) }}" class="btn btn-info btn-sm">Detail</a>
                  <form action="{{ route('umkm.sertifikasi', $t->id) }}" method="POST" class="d-inline" id="sertifikasi-form-{{ $t->id }}">
                    @csrf
                    <button type="button" class="btn btn-success btn-sm" onclick="confirmSertifikasi({{ $t->id }})">Sertifikasi</button>
                  </form>
                       <a href="{{ route('umkm.proses.export.word',  $t->id) }}" class="btn btn-success btn-sm">
                      Export Word
                    </a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-muted">Belum ada data.</td>
              </tr>
            @endforelse
                    {{-- Modal Import --}}
      <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <form action="{{ route('umkm.proses.import.excel',  $t->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Data UMKM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup">x</button>
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
            @endforeach
          </tbody>
        </table>
      </div>
            
    </div>
  </div>
</div>
@endsection


@push('scripts')
<script>
  function confirmSertifikasi(id) {
    Swal.fire({
      title: 'Pindahkan ke sertifikasi?',
      text: "Data UMKM ini akan dipindahkan ke daftar tersertifikasi.",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#198754', // warna hijau
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Ya, pindahkan!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('sertifikasi-form-' + id).submit();
      }
    });
  }
</script>

@endpush