@extends('layout.app')

@section('content')
<div class="container">
    <h2>Detail SPJ</h2>

    <div class="mb-3">
        <p><strong>Nama SPJ:</strong> {{ $spj->nama_spj }}</p>
        <p><strong>Keterangan Umum:</strong> {{ $spj->keterangan ?? '-' }}</p>
    </div>

    <h4>Item Biaya</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Item</th>
                <th>Nominal</th>
                <th>Status Pembayaran</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($spj->details as $index => $detail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $detail->item }}</td>
                    <td>Rp{{ number_format($detail->nominal, 0, ',', '.') }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $detail->status_pembayaran)) }}</td>
                    <td>{{ $detail->keterangan ?? '-' }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2"><strong>Total</strong></td>
                <td colspan="3"><strong>Rp{{ number_format($spj->details->sum('nominal'), 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>

    <a href="{{ route('spj.index') }}" class="btn btn-secondary mt-3">← Kembali</a>
</div>
@endsection
