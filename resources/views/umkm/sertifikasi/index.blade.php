@extends('layout.app')

@section('content')
<div class="container mt-4">
  <div class="card shadow-sm border-0">
    <div class="card-body">
      <h3 class="mb-4 text-primary">
        <i class="fa fa-certificate"></i> Data UMKM Tersertifikasi
      </h3>

      {{-- Tabel --}}
      <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle text-center">
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
            @forelse($data as $item)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nama_pelaku }}</td>
                <td>{{ $item->produk }}</td>
                <td>
                  @if(strtolower($item->status) === 'tersertifikasi')
                    <span class="badge bg-success">Tersertifikasi</span>
                  @else
                    <span class="badge bg-secondary">{{ $item->status }}</span>
                  @endif
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
                      <i class="fa fa-edit"></i> Edit
                  </a>
                @endif
                @if(optional(Auth::user()->role)->name === 'admin')
                  <form action="{{ route('admin.sertifikasi.destroy', $item->id) }}" method="POST" class="d-inline" id="delete-form-{{ $item->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmDelete({{ $item->id }})">
                      <i class="fa fa-trash"></i> Hapus
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
<script>
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

