@extends('layout.app')

@section('content')
<style>
.btn.border:hover {
  background-color: rgba(0,0,0,0.03);
}
</style>

<div class="container mt-4">
  <div class="card">
    <div class="card-body">

      {{-- Judul dan Tombol Aksi --}}
      <div class="row mb-4 align-items-center">
        <div class="col-md-6">
          <h2 class="fw-bold">Data SPJ</h2>
          <div class="d-flex gap-2 mt-2">
            <a href="{{ route('admin.spj.create') }}" class="btn btn-primary">
              <i class="fa fa-plus"></i> Tambah SPJ
            </a>
            <a href="{{ route('admin.spj.export') }}" class="btn btn-success">
                <i class="fa fa-file-excel"></i> Dowload Data
            </a>
            <a href="{{ route('admin.spj.import') }}" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="fa fa-upload"></i>  Upload Data
            </a>
          </div>
        </div>
      </div>

      {{-- Modal Import --}}
      <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 600px;">
        <div class="d-flex gap-2 mt-2">
          <a href="{{ route('admin.spj.create') }}" class="btn border" style="color: #2EC6DF; border-color: #2EC6DF; background-color: #fff;">
            <i class="fa fa-plus"></i> Tambah SPJ
          </a>
          <a href="{{ route('admin.spj.export') }}" class="btn border" style="color: #28a745; border-color: #28a745; background-color: #fff;">
            <i class="fa fa-file-excel"></i> Dowload Data
          </a>
          <a href="{{ route('admin.spj.import') }}" class="btn border" style="color: #ffc107; border-color: #ffc107; background-color: #fff;" data-bs-toggle="modal" data-bs-target="#importModal">
            <i class="fa fa-upload"></i> Upload Data
          </a>
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
                    <a href="{{ route('admin.spj.show', $item->id) }}" class="btn btn-info btn-sm">Detail</a>
                   <a class="btn btn-sm btn-danger" onclick="confirmDelete({{ $item->id }})">
                    <i class="fa fa-trash"></i> Hapus
                  </a>
                  <form id="delete-form-{{ $item->id }}" action="{{ route('admin.spj.destroy', $item->id) }}" method="POST" style="display: none;">
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
            <a href="{{ route('admin.spj.show', $item->spj->id ?? 0) }}" class="btn btn-sm btn-outline-info">
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
        @forelse($belumBayar->unique('spj_id') as $i => $item)
        <tr>
          <td class="text-center">{{ $i + 1 }}</td>
          <td>{{ $item->spj->nama_spj ?? '-' }}</td>
          <td class="text-center">
            <span class="badge bg-warning text-dark px-3 py-2">Belum Dibayar</span>
          </td>
          <td class="text-center">
            <a href="{{ route('admin.spj.show', $item->spj->id ?? 0) }}" class="btn btn-sm btn-outline-info">
              <i class="fa fa-eye"></i> Detail
            </a>
          </td>
        </tr>
        @empty
       <tr>
          <td colspan="5" class="text-muted">Belum Ada Data</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

      </div>
    </div>
  </div>
</div>

<!-- Modal Import -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('admin.spj.import') }}" method="POST" enctype="multipart/form-data">
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
