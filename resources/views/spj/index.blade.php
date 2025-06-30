@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h2>Data SPJ</h2>

    <a href="{{ route('spj.create') }}" class="btn btn-primary mb-3">Tambah SPJ</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama SPJ</th>
                <th>Item</th>
                <th>Nominal</th>
                <th>Pembayaran</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($spjs as $index => $spj)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $spj->nama_spj }}</td>
                <td>{{ $spj->item }}</td>
                <td>Rp{{ number_format($spj->nominal, 0, ',', '.') }}</td>
                <td>{{ $spj->pembayaran }}</td>
                <td>{!! nl2br(e($spj->keterangan)) !!}</td>
                <td>
                    <a href="{{ route('spj.edit', $spj->id) }}" class="btn btn-warning btn-sm">Edit</a>
                   <form action="{{ route('spj.destroy', $spj->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button onclick="confirmDelete" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
