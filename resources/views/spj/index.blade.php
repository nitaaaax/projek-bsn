@extends('layout.app')

@section('content')
<div class="container mt-4">
  <div class="card">
    <div class="card-body">

      {{-- Judul dan Tombol Aksi --}}
      <div class="row mb-4 align-items-center">
        <div class="col-md-6">
          <h2 class="fw-bold">Data SPJ</h2>
          <div class="d-flex gap-2 mt-2">
            <a href="{{ route('spj.create') }}" class="btn btn-primary btn-sm">
              <i class="fa fa-plus"></i> Tambah SPJ
            </a>
            <a href="{{ route('spj.export') }}" class="btn btn-success">
                <i class="fa fa-file-excel"></i> Export 
            </a>
            <a href="{{ route('spj.import') }}" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="fa fa-upload"></i> Import 
            </a>
          </div>
        </div>
      </div>

      {{-- Modal Import --}}
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('spj.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="importModalLabel">Import Data SPJ</h5>
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

      {{-- Tab Navigasi --}}
      <ul class="nav nav-tabs mb-3" id="spjTabs" role="tablist">
        <li class="nav-item">
          <button class="nav-link active" id="semua-tab" data-bs-toggle="tab" data-bs-target="#semua" type="button" role="tab">Semua SPJ</button>
        </li>
        <li class="nav-item">
          <button class="nav-link" id="sudah-tab" data-bs-toggle="tab" data-bs-target="#sudah" type="button" role="tab">Sudah Dibayar</button>
        </li>
        <li class="nav-item">
          <button class="nav-link" id="belum-tab" data-bs-toggle="tab" data-bs-target="#belum" type="button" role="tab">Belum Dibayar</button>
        </li>
      </ul>

      {{-- Isi Tab --}}
      <div class="tab-content" id="spjTabContent">
        {{-- TAB SEMUA --}}
        <div class="tab-pane fade show active" id="semua" role="tabpanel">
          <div class="table-responsive">
            <table class="table table-bordered table-striped" id="tabelSemua">
              <thead class="table-secondary text-center">
                <tr>
                  <th>No</th>
                  <th>Nama SPJ</th>
                  <th>Total</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($spj as $item)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->nama_spj }}</td>
                  <td class="text-end fw-bold">
                    Rp{{ number_format($item->details->sum('nominal'), 0, ',', '.') }}
                  </td>
                  <td>
                    <a href="{{ route('spj.show', $item->id) }}" class="btn btn-info btn-sm">Detail</a>
                   <a class="btn btn-sm btn-danger" onclick="confirmDelete({{ $item->id }})">
                    <i class="fa fa-trash"></i> Hapus
                  </a>
                  <form id="delete-form-{{ $item->id }}" action="{{ route('spj.destroy', $item->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                  </form>
                  </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted">Belum ada data.</td></tr>
                @endforelse
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="2" class="text-end">Total Keseluruhan:</th>
                  <th class="text-end fw-bold">
                    Rp{{ number_format($spj->sum(fn($s) => $s->details->sum('nominal')), 0, ',', '.') }}
                  </th>
                  <th></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>

       {{-- TAB SUDAH --}}
<div class="tab-pane fade" id="sudah" role="tabpanel">
  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle" id="tabelSudah">
      <thead class="table-success text-center">
        <tr>
          <th style="width: 60px;">No</th>
          <th>Nama SPJ</th>
          <th>Status</th>
          <th style="width: 100px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($sudahBayar->unique('spj_id') as $i => $item)
          <tr>
            <td class="text-center">{{ $i + 1 }}</td>
            <td>{{ $item->spj->nama_spj ?? '-' }}</td>
            <td class="text-center">
              <span class="badge bg-success px-3 py-2">Sudah Dibayar</span>
            </td>
            <td class="text-center">
              <a href="{{ route('spj.show', $item->spj->id ?? 0) }}" class="btn btn-sm btn-outline-info">
                <i class="fa fa-eye"></i> Detail
              </a>
            </td>
          </tr>
        @empty
          <tr><td colspan="4" class="text-center text-muted">Tidak ada data.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

        {{-- TAB BELUM --}}
     <div class="tab-pane fade" id="belum" role="tabpanel">
  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle" id="tabelBelum">
      <thead class="table-warning text-center">
        <tr>
          <th style="width: 60px;">No</th>
          <th>Nama SPJ</th>
          <th>Status</th>
          <th style="width: 100px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($belumBayar->unique('spj_id') as $i => $d)
          <tr>
            <td class="text-center">{{ $i + 1 }}</td>
            <td>{{ $d->spj->nama_spj ?? '-' }}</td>
            <td class="text-center">
              <span class="badge bg-warning text-dark px-3 py-2">Belum Dibayar</span>
            </td>
            <td class="text-center">
              <a href="{{ route('spj.show', $d->spj->id ?? 0) }}" class="btn btn-sm btn-outline-info">
                <i class="fa fa-eye"></i> Detail
              </a>
            </td>
          </tr>
        @empty
          <tr><td colspan="4" class="text-center text-muted">Tidak ada data.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>


          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Modal Import -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('spj.import') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Import SPJ</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="file" class="form-label">Pilih File Excel</label>
            <input type="file" name="file" class="form-control" required>
          </div>

        <div class="alert alert-warning mt-2 d-flex align-items-start" style="font-size: 14px;">
          <i class="bi bi-exclamation-triangle-fill me-2 mt-1 text-warning fs-5"></i>
          <div>
            <strong>Penting!</strong><br>
            Gunakan template berikut untuk mengisi data SPJ agar formatnya sesuai.<br>
            <a href="{{ asset('template/template_spj.xlsx') }}" class="text-decoration-underline text-primary" download>
              Klik di sini untuk download template.
            </a>
          </div>
        </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Import</button>
        </div>
      </div>
    </form>
  </div>
</div>


@endsection

@push('styles')
<style>
  table tr:hover {
    background-color: #f5f5f5;
  }
  .badge {
    font-size: 0.85rem;
    border-radius: 10px;
  }
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

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


  $(document).ready(function () {
    $('#tabelSemua').DataTable();
    $('#tabelSudah').DataTable();
    $('#tabelBelum').DataTable();
  });
</script>
@endpush
