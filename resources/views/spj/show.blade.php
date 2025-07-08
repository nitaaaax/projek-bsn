@extends('layout.app')

@section('content')
<div class="container mt-4">
  <div class="card">
    <div class="card-body">
      <h2 class="font-weight-bold mb-4">Detail SPJ</h2>

      {{-- Informasi Umum --}}
      <div class="mb-4">
        <table class="table table-borderless">
          <tr>
            <th style="width: 150px;">Nama SPJ</th>
            <td>: {{ $spj->nama_spj }}</td>
          </tr>
          <tr>
            <th>No UKD</th>
            <td>: {{ $spj->no_ukd }}</td>
          </tr>
          <tr>
            <th>Keterangan</th>
          <td>: {!! $spj->keterangan ?? '-' !!}</td>
          </tr>
          <tr>
            <th>Dokumen</th>
            <td>: 
              @if ($spj->dokumen)
                <a href="{{ $spj->dokumen }}" target="_blank">{{ $spj->dokumen }}</a>
              @else
                -
              @endif
            </td>
          </tr>
        </table>
      </div>

      {{-- Tabel Detail Item --}}
      <div class="table-responsive">
        <table id="tabelSPJDetail" class="table table-bordered table-hover table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Item</th>
              <th>Nominal</th>
              <th>Status Pembayaran</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($spj->details as $index => $detail)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $detail->item }}</td>
                <td>Rp {{ number_format($detail->nominal, 0, ',', '.') }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $detail->status_pembayaran)) }}</td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th colspan="2" class="text-end">Total</th>
              <th colspan="2">Rp {{ number_format($spj->details->sum('nominal'), 0, ',', '.') }}</th>
            </tr>
          </tfoot>
        </table>
      </div>

        <div class="d-flex mt-4">
      <a href="{{ route('spj.index') }}" class="btn btn-secondary mr-2">
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
