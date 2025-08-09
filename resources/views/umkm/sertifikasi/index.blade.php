@extends('layout.app')

@section('content')
<style>
thead {
  background-color: #d4edda; /* Hijau ringan */
  color: #155724;
}

.table-responsive {
  overflow-x: unset !important;
}
</style>

<div class="container mt-4">
  <div class="card shadow-sm border-0">
    <div class="card-body">
      <h3 class="mb-4 text-primary">
        <i class="fa fa-certificate"></i> Data UMKM Tersertifikasi
      </h3>

      {{-- Tabel --}}
      <div class="table-responsive">
        <table id="sertifikasiTable" class="table table-hover table-bordered align-middle text-center">
          <thead class="table-success">
            <tr>
              <th>No</th>
              <th>Nama Pelaku</th>
              <th>Produk</th>
              <th>Status Pembinaan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($items as $item)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nama_pelaku }}</td>
                <td>{{ $item->produk }}</td>
                <td>
                  @php
                      $isSertif = in_array($item->status_pembinaan, ['SPPT SNI (TERSERTIFIKASI)']);
                  @endphp
                  <span class="badge {{ $isSertif ? 'bg-success' : 'bg-secondary' }}">
                      {{ $item->status_pembinaan }}
                  </span>
                </td>
                <td>
                @php
                  $role = optional(Auth::user()->role)->name;
                @endphp
                @php
                  $role = optional(Auth::user()->role)->name;
                @endphp

                @if($role === 'user')
                  <a href="{{ route('user.umkm.showuser', $item->id) }}#top" class="btn btn-info btn-sm" title="Detail">
                      <i class="fa fa-eye"></i>
                  </a>
                @endif
                @if(optional(Auth::user()->role)->name === 'admin')
                  <a href="{{ route('admin.sertifikasi.edit', $item->id) }}" class="btn btn-warning btn-sm">
                      <i class="fa fa-edit"></i> 
                  </a>
                @endif
                  <a href="{{ route('umkm.export.word.single', $item->id) }}" class="btn btn-success btn-sm" title="Download">
                    <i class="fa fa-download"></i>
                  </a>
                @if(optional(Auth::user()->role)->name === 'admin')
                  <form action="{{ route('admin.sertifikasi.destroy', $item->id) }}" method="POST" class="d-inline" id="delete-form-{{ $item->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $item->id }})">
                      <i class="fa fa-trash"></i>
                    </button>
                  </form>
                @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-muted">Belum ada UMKM tersertifikasi.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
  $(document).ready(function() {
    $('#sertifikasiTable').DataTable({
      language: {
        search: "Cari:",
        lengthMenu: "Tampilkan _MENU_ entri",
        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
        paginate: {
          first: "Pertama",
          last: "Terakhir",
          next: "→",
          previous: "←"
        },
        emptyTable: "Belum ada UMKM tersertifikasi.",
        zeroRecords: "Tidak ditemukan data yang cocok."
      },
      responsive: true
    });
  });

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
</script>
@endpush


