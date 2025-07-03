@extends('layout.app')

@section('content')
<div class="container mt-4">
  <div class="card">
    <div class="card-body">
      <h2 class="font-weight-bold mb-4">Detail SPJ</h2>

      <div class="mb-4">
        <table class="table table-borderless">
          <tr>
            <th style="width: 150px;">Nama SPJ</th>
            <td>: {{ $spj->nama_spj }}</td>
          </tr>
         
        </table>
      </div>

      <div class="table-responsive">
        <table id="tabelSPJDetail" class="table table-bordered table-hover table-striped">
         <thead class="bg-secondary text-white text-center">
          <tr>
              <th style="width: 20%">Item</th>
              <th style="width: 15%">Nominal</th>
              <th style="width: 20%">Status Pembayaran</th>
              <th style="width: 35%">Keterangan</th>
              <th style="width: 10%">Aksi</th>
          </tr>
        </thead>

          <tbody>
            @foreach ($spj->details as $index => $detail)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $detail->item }}</td>
                <td>Rp {{ number_format($detail->nominal, 0, ',', '.') }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $detail->status_pembayaran)) }}</td>
                <td>{{ $detail->keterangan ?? '-' }}</td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th colspan="2" class="text-right">Total</th>
              <th colspan="3">Rp {{ number_format($spj->details->sum('nominal'), 0, ',', '.') }}</th>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="d-flex gap-2 mt-4">
        <a href="{{ route('spj.index') }}" class="btn btn-secondary">
          <i class="fas fa-arrow-left"></i> Kembali ke daftar SPJ
        </a>
        <a href="{{ route('spj.edit', $spj->id) }}" class="btn btn-warning">
          <i class="fa fa-edit"></i> Edit SPJ
        </a>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(function () {
    $('#tabelSPJDetail').DataTable({
      lengthChange: false,
      paging: false,
      searching: false,
      ordering: false,
      info: false,
      language: {
        emptyTable: "Belum ada item dalam SPJ ini."
      }
    });
  });
</script>
@endpush
    