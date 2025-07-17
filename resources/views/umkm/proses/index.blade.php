@extends('layout.app')

@section('content')
<div class="container mt-4">
  <div class="card shadow-sm">
    <div class="card-body">

      {{-- Judul dan Tombol Aksi --}}
      <div class="row mb-4 align-items-center">
        <div class="col-md-6">
          <h2 class="fw-bold">Data UMKM</h2>
          <div class="d-flex gap-2 mt-2">
            <a href="{{ route('tahap.create.tahap', ['tahap' => 1]) }}" class="btn btn-primary btn-sm">
              <i class="fa fa-plus"></i> Tambah UMKM
            </a>
          </div>
        </div>
      </div>
      {{-- Tabel --}}
      <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle text-center">
          <thead class="table-light">
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
            @foreach($tahap1 as $i => $t)
              <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $t->nama_pelaku }}</td>
                <td>{{ $t->produk }}</td>
                <td>{{ $t->status }}</td>
                <td>
                  <a href="{{ route('umkm.show', $t->id) }}" class="btn btn-info btn-sm">Detail</a>
                  <form action="{{ route('umkm.sertifikasi', $t->id) }}" method="POST" class="d-inline" id="sertifikasi-form-{{ $t->id }}">
                    @csrf
                    <button type="button" class="btn btn-success btn-sm" onclick="confirmSertifikasi({{ $t->id }})">Sertifikasi</button>
                  </form>
                       <a href="{{ route('umkm.proses.export.word',  $t->id) }}" class="btn btn-success btn-sm">
                      Export Word
                    </a>
                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#importModal">
                      Import Excel
                    </button>
                </td>
              </tr>
                    {{-- Modal Import --}}
      <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <form action="{{ route('umkm.proses.import.excel',  $t->id) }}" method="POST" enctype="multipart/form-data">
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