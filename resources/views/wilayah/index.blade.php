@extends('layout.app')

@section('content')
<div class="container mt-4">
  <h4 class="fw-bold mb-3">Daftar Provinsi</h4>

  {{-- Tombol Tambah --}}
  <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
    <i class="fas fa-plus me-1"></i> Tambah Provinsi
  </button>

 <div class="d-flex justify-content-end mb-3">
      <form action="{{ route('wilayah.index') }}" method="GET" class="d-flex" style="max-width: 300px;">
        <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Cari provinsi & kota" value="{{ request('search') }}">
        <button class="btn btn-sm btn-outline-primary" type="submit">Cari</button>
      </form>
    </div>
  {{-- Card Tabel --}}
  <div class="card shadow-sm rounded-4 border-0">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover table-striped align-middle mb-0">
          <thead class="table-primary">
            <tr>
              <th style="width: 5%;">No</th>
              <th>Nama Provinsi</th>
              <th style="width: 20%;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($provinsis as $provinsi)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $provinsi->nama }}</td>
              <td>
                

                {{-- Tombol Hapus --}}
               <button class="btn btn-danger btn-sm btn-delete" 
                data-id="{{ $provinsi->id }}" 
                data-nama="{{ $provinsi->nama }}">
                <i class="fas fa-trash-alt"></i>
                </button>
                <form id="form-delete-{{ $provinsi->id }}" 
                action="{{ route('wilayah.destroy', $provinsi->id) }}" 
                method="POST" style="display:none;">
                  @csrf
                  @method('DELETE')
                  <input type="hidden" name="type" value="provinsi">
                </form>
            @empty
            <tr>
              <td colspan="3" class="text-center text-muted">Belum ada data.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('wilayah.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="tambahLabel">Tambah Provinsi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="text" name="nama_provinsi" class="form-control" placeholder="Nama Provinsi" required>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- ========================== --}}
{{-- TABEL KOTA --}}
{{-- ========================== --}}
<div class="container mt-5">
  <h4 class="fw-bold mb-3">Daftar Kota</h4>

  {{-- Tombol Tambah --}}
  <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahKota">
    <i class="fas fa-plus me-1"></i> Tambah Kota
  </button>

  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-hover align-middle mb-0">
          <thead class="table-secondary">
            <tr>
              <th style="width: 5%;">No</th>
              <th>Nama Kota</th>
              <th>Provinsi</th>
              <th style="width: 20%;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($kotas as $kota)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $kota->nama }}</td>
              <td>{{ $kota->provinsi->nama ?? '-' }}</td>
              <td>
                

                {{-- Tombol Hapus --}}
                <button class="btn btn-danger btn-sm btn-delete-kota"
                        data-id="{{ $kota->id }}"
                        data-nama="{{ $kota->nama }}">
                  <i class="fas fa-trash-alt"></i>
                </button>
                <form id="form-delete-kota-{{ $kota->id }}" 
                action="{{ route('wilayah.destroy', $kota->id) }}" 
                method="POST" style="display:none;">
                  @csrf
                  @method('DELETE')
                  <input type="hidden" name="type" value="kota">
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="text-center text-muted">Belum ada kota.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

{{-- Modal Tambah Kota --}}
<div class="modal fade" id="modalTambahKota" tabindex="-1" aria-labelledby="tambahKotaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('wilayah.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="tambahKotaLabel">Tambah Kota</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          {{-- Input Nama Kota --}}
          <div class="mb-3">
            <label for="nama_kota" class="form-label">Nama Kota</label>
            <input type="text" id="nama_kota" name="nama_kota" class="form-control" placeholder="Nama Kota" value="{{ old('nama_kota') }}" required>
          </div>

          {{-- Select Provinsi --}}
         <div class="mb-3">
            <label for="provinsi_id" class="form-label">Provinsi</label>
            <select name="provinsi_id" id="provinsi_id" class="form-select" required>
              <option disabled selected value=""> Pilih Provinsi</option>
              @forelse($provinsis as $provinsi)
                <option value="{{ $provinsi->id }}">
                  {{ Str::title($provinsi->nama) }}
                </option>
              @empty
                <option disabled>Tidak ada provinsi tersedia</option>
              @endforelse
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>


@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Hapus Provinsi
document.querySelectorAll('.btn-delete').forEach(button => {
  button.addEventListener('click', function () {
    const id = this.dataset.id;
    const nama = this.dataset.nama;

    Swal.fire({
      title: 'Yakin ingin menghapus?',
      text: `Provinsi "${nama}" akan dihapus!`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#e3342f',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Ya, hapus!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById(`form-delete-${id}`).submit();
      }
    });
  });
});

// Hapus Kota
document.querySelectorAll('.btn-delete-kota').forEach(button => {
  button.addEventListener('click', function () {
    const id = this.dataset.id;
    const nama = this.dataset.nama;

    Swal.fire({
      title: 'Yakin ingin menghapus?',
      text: `Kota "${nama}" akan dihapus!`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#e3342f',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Ya, hapus!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById(`form-delete-kota-${id}`).submit();
      }
    });
  });
});
</script>
@endpush

