@extends('layout.app')

@section('content')
<div class="container mt-4">
  <div class="card">
    <div class="card-body">
      <h2 class="fw-bold mb-4">Data SPJ</h2>

      <a href="{{ route('spj.create') }}" class="btn btn-primary btn-sm mb-3">
        <i class="fa fa-plus"></i> Tambah SPJ
      </a>

      <!-- Tab Navigasi -->
      <ul class="nav nav-tabs mb-3" id="spjTabs" role="tablist">
        <li class="nav-item">
          <button class="nav-link active" id="semua-tab" data-bs-toggle="tab" data-bs-target="#semua" type="button" role="tab">
            Semua SPJ
          </button>
        </li>
        <li class="nav-item">
          <button class="nav-link" id="sudah-tab" data-bs-toggle="tab" data-bs-target="#sudah" type="button" role="tab">
            Sudah Dibayar
          </button>
        </li>
        <li class="nav-item">
          <button class="nav-link" id="belum-tab" data-bs-toggle="tab" data-bs-target="#belum" type="button" role="tab">
            Belum Dibayar
          </button>
        </li>
      </ul>

      <!-- Isi Tab -->
      <div class="tab-content" id="spjTabContent">

        <!-- Tab SEMUA SPJ -->
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
                      <form action="{{ route('spj.destroy', $item->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" class="text-center text-muted">Belum ada data.</td>
                  </tr>
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

        <!-- Tab SUDAH DIBAYAR -->
        <div class="tab-pane fade" id="sudah" role="tabpanel">
          <div class="table-responsive">
            <table class="table table-bordered table-striped" id="tabelSudah">
              <thead class="table-success text-center">
                <tr>
                  <th>No</th>
                  <th>Nama SPJ</th>
                  <th>Item</th>
                  <th>Nominal</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                @forelse($sudahBayar as $item)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->spj->nama_spj }}</td>
                    <td>{{ $item->item }}</td>
                    <td class="text-end">Rp{{ number_format($item->nominal, 0, ',', '.') }}</td>
                    <td>{{ $item->keterangan }}</td>
                  </tr>
                @empty
                  <tr><td colspan="5" class="text-center text-muted">Tidak ada data.</td></tr>
                @endforelse
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="3" class="text-end">Total:</th>
                  <th class="text-end fw-bold">
                    Rp{{ number_format($sudahBayar->sum('nominal'), 0, ',', '.') }}
                  </th>
                  <th></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>

        <!-- Tab BELUM DIBAYAR -->
        <div class="tab-pane fade" id="belum" role="tabpanel">
          <div class="table-responsive">
            <table class="table table-bordered table-striped" id="tabelBelum">
              <thead class="table-warning text-center">
                <tr>
                  <th>No</th>
                  <th>Nama SPJ</th>
                  <th>Item</th>
                  <th>Nominal</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                @forelse($belumBayar as $item)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->spj->nama_spj }}</td>
                    <td>{{ $item->item }}</td>
                    <td class="text-end">Rp{{ number_format($item->nominal, 0, ',', '.') }}</td>
                    <td>{{ $item->keterangan }}</td>
                  </tr>
                @empty
                  <tr><td colspan="5" class="text-center text-muted">Tidak ada data.</td></tr>
                @endforelse
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="3" class="text-end">Total:</th>
                  <th class="text-end fw-bold">
                    Rp{{ number_format($belumBayar->sum('nominal'), 0, ',', '.') }}
                  </th>
                  <th></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<!-- Bootstrap CSS (penting untuk tab aktif) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush

@push('scripts')
<!-- jQuery dan Bootstrap Bundle (untuk tab dan komponen js Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
  $(function () {
    $('#tabelSemua').DataTable();
    $('#tabelSudah').DataTable();
    $('#tabelBelum').DataTable();
  });
</script>
@endpush
