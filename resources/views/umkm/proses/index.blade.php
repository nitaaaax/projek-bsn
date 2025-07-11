@extends('layout.app')

@section('content')
<div class="container mt-4">
  <div class="card shadow-sm">
    <div class="card-body">
      <h3 class="mb-4">Data UMKM Proses</h3>

      {{-- Tombol Tambah --}}
      <a href="{{ route('tahap.create.tahap', ['tahap' => 1]) }}" class="btn btn-primary mb-3">
        <i class="fa fa-plus"></i> Tambah UMKM
      </a>

      {{-- Tabel Data --}}
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
                  <form action="{{ route('umkm.sertifikasi', $t->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-success btn-sm" onclick="return confirm('Pindahkan ke sertifikasi?')">Sertifikasi</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>
@endsection
