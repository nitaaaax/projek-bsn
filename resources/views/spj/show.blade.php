@extends('layout.app')

@section('content')
<div class="container mt-4">
  <div class="card">
    <div class="card-body">
      <h2 class="font-weight-bold mb-4">Detail SPJ</h2>

      {{-- Informasi Umum --}}
<div class="row">
  <div class="col-md-4 mb-3">
    <strong>Nama SPJ</strong><br>
    {{ $spj->nama_spj }}
  </div>

  <div class="col-md-4 mb-3">
    <strong>No UKD</strong><br>
    {{ $spj->no_ukd }}
  </div>

  <div class="col-md-4 mb-3">
    <strong>Dokumen</strong><br>
    @if ($spj->dokumen)
      <a href="{{ $spj->dokumen }}" target="_blank" style="word-break: break-all;">
        {{ $spj->dokumen }}
      </a>
    @else
      -
    @endif
  </div>

 <div class="col-md-12 mt-3">
  <strong>Keterangan</strong>
  <div class="mt-0" style="white-space: pre-line;">
  @if($spj->keterangan)
        {!! nl2br($spj->keterangan) !!}
      @else
        -
      @endif
  </div>
</div>

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

      {{-- Aksi --}}
      <div class="d-flex mt-4">
        <a href="{{ route('spj.index') }}" class="btn btn-secondary" style="margin-right: 12px;">
          <i class="fas fa-arrow-left"></i> Kembali ke daftar SPJ
        </a>
        @if(optional(Auth::user()->role)->name === 'admin')
        <a href="{{ route('admin.spj.edit', $spj->id) }}" class="btn btn-warning">
          <i class="fa fa-edit"></i> Edit SPJ
        </a>
        @endif
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
