@extends('layout.app')

@section('content')
<div class="container mt-4">
  <div class="card border-0 shadow rounded-4">
    <div class="card-body">
      
      {{-- Judul --}}
      <h3 class="mb-4 text-primary fw-bold"><i class="fa fa-database me-2"></i>Data UMKM Proses</h3>

      {{-- Tombol Aksi --}}
      <div class="mb-4">
  <a href="{{ route('tahap.create.tahap', ['tahap' => 1]) }}" class="btn btn-primary mr-2">
    <i class="fa fa-plus mr-1"></i> Tambah UMKM
  </a>
  <a href="{{ route('umkm.proses.exportWord') }}" class="btn btn-success">
    <i class="fa fa-download mr-1"></i> Export
  </a>
</div>


      {{-- Tabel --}}
      <div class="table-responsive">
        <table class="table table-hover table-bordered text-center align-middle">
          <thead class="table-primary">
            <tr>
              <th>No</th>
              <th>Nama Pelaku</th>
              <th>Produk</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($data as $item)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="text-start">{{ $item->nama_pelaku }}</td>
                <td>{{ $item->produk }}</td>
                <td>
                  @if (strtolower($item->status) == 'sudah')
                    <span class="badge bg-success">Sudah</span>
                  @elseif(strtolower($item->status) == 'belum')
                    <span class="badge bg-danger">Belum</span>
                  @else
                    <span class="badge bg-secondary">{{ $item->status }}</span>
                  @endif
                </td>
                <td>
                  <a href="{{ route('umkm.show', $item->id) }}" class="btn btn-info btn-sm">
                    <i class="fa fa-eye"></i>
                  </a>

                  <form action="{{ route('umkm.destroy', $item->id) }}" method="POST" class="d-inline delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm btn-delete">
                      <i class="fa fa-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-muted">Belum ada data.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>
@endsection
