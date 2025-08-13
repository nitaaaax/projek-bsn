@extends('layout.app')

@section('content')
<style>
.btn.border:hover {
  background-color: rgba(0,0,0,0.03);
}
/* Anda dapat menjaga thead styling jika diinginkan */
thead {
  background-color: #d4edda;
  color: #155724;
}

/* Gaya untuk dropdown profil agar lebih responsif (dari Canvas sebelumnya) */
.profile-box {
  cursor: pointer;
  display: flex;
  align-items: center;
  padding: 8px 12px;
  border-radius: 8px;
  transition: background 0.3s;
  position: relative; /* Pastikan ini ada untuk positioning menu popout */
}

.profile-box:hover {
  background-color: rgba(255, 255, 255, 0.1);
}

.profile-name {
  color: white;
  margin-left: 10px;
  font-weight: 500;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: calc(100% - 40px); /* Sesuaikan dengan lebar gambar profil */
}

.popout-menu {
  position: absolute;
  top: 110%; /* Sedikit di bawah profile-box */
  left: 0;   /* Ganti dari right:0 agar menu mengikuti sisi kiri parent */
  width: 100%; /* Agar menu memenuhi lebar parent-nya (profile-box) */
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.2);
  min-width: 150px; /* Lebar minimum untuk tampilan desktop */
  max-width: 250px; /* Lebar maksimum agar tidak terlalu lebar di tablet/desktop */
  display: none;
  z-index: 1000;
  padding: 5px 0; /* Tambahkan padding vertikal di dalam menu */
}

.popout-menu.active {
  display: block;
}

.popout-menu button {
  width: 100%;
  border: none;
  background: none;
  padding: 10px 15px; /* Sesuaikan padding untuk tombol */
  text-align: left;
  color: red; /* Warna teks logout */
  font-weight: 500;
}

.popout-menu button.popout-item.text-dark {
    color: #212529; /* Warna teks untuk "Profil Anda" */
}

.popout-menu button:hover {
  background-color: #f2f2f2;
}
</style>

<!-- NAVBAR -->

<!-- SIDEBAR -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('home') }}" class="brand-link d-flex align-items-center">
    <img src="{{ asset('asset/dist/img/logo-umkm.png') }}"
         alt="Logo SI-UMKM RIAU"
         class="brand-image"
         style="height: 50px; width: auto; object-fit: contain;">
    <span class="brand-text fw-bold text-white ms-2">SI-UMKM <span style="color:#15AABF">RIAU</span></span>
  </a>

  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <!-- PROFILE DROPDOWN -->
    <div class="nav-item" style="position: relative;">
      <div class="profile-box" onclick="togglePopout()">
        <img src="{{ asset('asset/dist/img/profile-pic.jpg') }}" alt="User Image" class="rounded-circle" width="30" height="30">
        <span class="profile-name"> Halo, {{ Auth::user()->username ?? 'Tamu' }}!</span>
      </div>

      <div class="popout-menu" id="popoutMenu">
        {{-- Tombol Profil Anda --}}
        <form method="GET" action="{{ route('profile.view') }}">
          <button type="submit" class="popout-item text-dark">
            <i class="fas fa-user mr-2"></i> Profil Anda
          </button>
        </form>

        {{-- Tombol Logout --}}
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="popout-item text-danger">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
          </button>
        </form>
      </div>
    </div>

    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <a href="{{ route('home') }}" class="nav-link">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>Beranda</p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('spj.index') }}" class="nav-link">
          <i class="fas fa-receipt nav-icon"></i>
          <p>Data SPJ</p>
        </a>
      </li>

      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-store"></i>
          <p>
            Data UMKM
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('umkm.proses.index') }}" class="nav-link">
              <i class="fas fa-database nav-icon"></i>
              <p>Data UMKM Proses</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('umkm.sertifikasi.index') }}" class="nav-link">
              <i class="fas fa-certificate nav-icon"></i>
              <p>Data UMKM Sertifikasi</p>
            </a>
          </li>
        </ul>
      </li>

      {{-- HANYA UNTUK ADMIN --}}
      @if (Auth::check() && Auth::user()->role?->name === 'admin')
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user-shield"></i>
            <p>
              Admin Managements
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.users.index') }}" class="nav-link">
                <i class="fas fa-user-cog nav-icon"></i>
                <p>Role</p>
              </a>
            </li>
           <li class="nav-item">
            <a href="{{ route('wilayah.index') }}" class="nav-link {{ request()->routeIs('wilayah.index') ? 'active' : '' }}">
              <i class="fas fa-building nav-icon"></i>
              <p>Provinsi & Kota</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.templates.index') }}"
              class="nav-link {{ request()->routeIs('admin.admin.templates.*') ? 'active' : '' }}">
                <i class="fas fa-file nav-icon"></i>
                <p>Template</p>
            </a>
          </li>
          </ul>
        </li>
      @endif
    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</aside>


<div class="container mt-4">
  <div class="card">
    <div class="card-body">

      {{-- Judul dan Tombol Aksi --}}
      <div class="row mb-4 align-items-center">
        <div class="col-md-6">
          <h2 class="fw-bold">Data SPJ</h2>
          <div class="d-flex flex-wrap gap-3 mt-4"> {{-- Menggunakan flex-wrap untuk tombol --}}
          @if(optional(Auth::user()->role)->name === 'admin')
            <a href="{{ route('admin.spj.create') }}" class="btn btn-primary mb-2"> {{-- Tambah mb-2 untuk mobile --}}
              <i class="fa fa-plus"></i> Tambah SPJ
            </a>
          @endif
              <a href="{{ route('spj.export', Auth::id()) }}" class="btn btn-success mb-2"> {{-- Tambah mb-2 untuk mobile --}}
                <i class="fa fa-file-excel"></i> Download Data
              </a>
            @if(optional(Auth::user()->role)->name === 'admin')
            <a href="{{ route('admin.spj.import') }}" class="btn btn-warning mb-2" data-bs-toggle="modal" data-bs-target="#importModal"> {{-- Tambah mb-2 untuk mobile --}}
                <i class="fa fa-upload"></i> Upload Data
            </a>
            @endif
          </div>
        </div>
      </div>


      {{-- Tab Navigasi --}}
      <ul class="nav nav-tabs mb-3" id="spjTabs" role="tablist">
        <li class="nav-item">
          <button class="nav-link active" id="semua-tab" data-bs-toggle="tab" data-bs-target="#semua" type="button" role="tab">Semua SPJ</button>
        </li>
        <li class="nav-item">
          <button class="nav-link" id="sudah-tab" data-bs-toggle="tab" data-bs-target="#sudah" type="button" role="tab">Sudah Dibayar</button>
        </li>
        <li class="nav-item">
          <button class="nav-link" id="belum-tab" data-bs-toggle="tab" data-bs-target="#belum" type="button" role="tab">Belum Dibayar</button>
        </li>
      </ul>

      {{-- Isi Tab --}}
      <div class="tab-content" id="spjTabContent">
        {{-- TAB SEMUA --}}
        <div class="tab-pane fade show active" id="semua" role="tabpanel">
          <div class="table-responsive">
            <table class="table table-bordered table-striped" id="tabelSemua">
              <thead class="table-secondary text-center">
                <tr>
                  <th>No</th>
                  <th>Nama SPJ</th>
                  <th>Total</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($spj ?? [] as $item) {{-- Pastikan $spj tidak null --}}
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->nama_spj ?? '-' }}</td>
                  <td class="text-end fw-bold">
                    Rp{{ number_format($item->details->sum('nominal'), 0, ',', '.') }}
                  </td>
                  <td>
                  {{-- Tombol Detail, tampilkan berdasarkan role --}}
                  @if(optional(Auth::user()->role)->name === 'admin')
                      <a href="{{ route('admin.spj.show', $item->id) }}" class="btn btn-primary btn-sm" title="Detail">
                          <i class="fa fa-eye"></i>
                      </a>
                  @elseif(optional(Auth::user()->role)->name === 'user')
                      <a href="{{ route('spj.show', $item->id) }}" class="btn btn-outline-secondary btn-sm" title="Detail">
                          <i class="fa fa-eye"></i>
                      </a>
                  @endif
                  {{-- Tombol Hapus (khusus admin) --}}
                  @if(optional(Auth::user()->role)->name === 'admin')
                      <a class="btn btn-sm btn-danger" title="Hapus" onclick="confirmDelete({{ $item->id }})">
                          <i class="fa fa-trash"></i>
                      </a>
                  @endif

                  {{-- Form Hapus --}}
                  <form id="delete-form-{{ $item->id }}" action="{{ route('admin.spj.destroy', $item->id) }}" method="POST" style="display: none;">
                      @csrf
                      @method('DELETE')
                  </form>
                  </td>

                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted">Belum ada data.</td></tr>
                @endforelse
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="2" class="text-end">Total Keseluruhan:</th>
                  <th class="text-end fw-bold">
                    Rp{{ number_format(($spj ? $spj->sum(fn($s) => $s->details->sum('nominal')) : 0), 0, ',', '.') }}
                  </th>
                  <th></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>

        {{-- TAB SUDAH --}}
        <div class="tab-pane fade" id="sudah" role="tabpanel">
          <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle" id="tabelSudah">
              <thead class="table-success text-center">
                <tr>
                  <th style="width: 60px;">No</th>
                  <th>Nama SPJ</th>
                  <th>Status</th>
                  <th style="width: 100px;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($sudahBayar->unique('spj_id') ?? [] as $i => $item) {{-- Pastikan $sudahBayar tidak null --}}
                <tr>
                  <td class="text-center">{{ $i + 1 }}</td>
                  <td>{{ $item->spj->nama_spj ?? '-' }}</td>
                  <td class="text-center">
                    <span class="badge bg-success px-3 py-2">Sudah Dibayar</span>
                  </td>
                  <td class="text-center">
                    @if(optional(Auth::user()->role)->name === 'admin')
                      <a href="{{ route('admin.spj.show', $item->id) }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-eye"></i> Detail
                      </a>
                    @elseif(optional(Auth::user()->role)->name === 'user')
                      <a href="{{ route('spj.show', $item->id) }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fa fa-eye"></i> Detail
                      </a>
                    @endif
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="4" class="text-center text-muted">Tidak ada data.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

        {{-- TAB BELUM --}}
        <div class="tab-pane fade" id="belum" role="tabpanel">
          <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle" id="tabelBelum">
              <thead class="table-warning text-center">
                <tr>
                  <th style="width: 60px;">No</th>
                  <th>Nama SPJ</th>
                  <th>Status</th>
                  <th style="width: 100px;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($belumBayar->unique('spj_id') ?? [] as $i => $item) {{-- Pastikan $belumBayar tidak null --}}
                <tr>
                  <td class="text-center">{{ $i + 1 }}</td>
                  <td>{{ $item->spj->nama_spj ?? '-' }}</td>
                  <td class="text-center">
                    <span class="badge bg-warning text-dark px-3 py-2">Belum Dibayar</span>
                  </td>
                  <td class="text-center">
                      @if(optional(Auth::user()->role)->name === 'admin')
                      <a href="{{ route('admin.spj.show', $item->spj_id) }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-eye"></i> Detail
                      </a>
                    @elseif(optional(Auth::user()->role)->name === 'user')
                      <a href="{{ route('spj.show', $item->spj_id) }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fa fa-eye"></i> Detail
                       </a>
                    @endif
                  </td>
                </tr>
                @empty
               <tr>
                  <td colspan="4" class="text-muted">Belum Ada Data</td> {{-- Perbaikan colspan --}}
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- Modal Import -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('admin.spj.import') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Import SPJ</h5>
           <button type="button" class="btn btn-sm btn-danger rounded-circle d-flex align-items-center justify-content-center"
                style="width: 32px; height: 32px;"
                data-bs-dismiss="modal"
                aria-label="Close">
            <i class="fa fa-times text-white"></i>
            </button>
          </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="file" class="form-label">Pilih File Excel</label>
            <input type="file" name="file" class="form-control" required>
          </div>

        <div class="alert alert-warning mt-2 d-flex align-items-start" style="font-size: 14px;">
          <i class="bi bi-exclamation-triangle-fill me-2 mt-1 text-warning fs-5"></i>
          <div>
            <strong>Penting!</strong><br>
            Gunakan template berikut untuk mengisi data SPJ agar formatnya sesuai.<br>
            <a href="{{ asset('template/template_spj.xlsx') }}" class="text-decoration-underline text-primary" download>
              Klik di sini untuk download template.
            </a>
          </div>
        </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Import</button>
        </div>
      </div>
    </form>
  </div>
</div>


@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
{{-- DataTables Bootstrap 5 CSS (untuk styling DataTables agar cocok dengan Bootstrap) --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
{{-- DataTables Responsive CSS (penting untuk responsivitas di layar kecil) --}}
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
{{-- Font Awesome untuk ikon --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" xintegrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0x0zNyXfUaJ/gL7vX7+P/xM/uJ+fR/M+xT1pQ8/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw/BwFw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"> {{-- Untuk ikon bi-exclamation-triangle-fill --}}
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script> {{-- Update ke versi 3.7.0 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
{{-- DataTables Bootstrap 5 JS (untuk integrasi dengan Bootstrap 5) --}}
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
{{-- DataTables Responsive Core JS (penting untuk fungsionalitas responsif) --}}
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
{{-- DataTables Responsive Bootstrap 5 JS (untuk styling responsif agar cocok dengan Bootstrap) --}}
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>


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

$(document).ready(function () {
  $.fn.dataTable.ext.errMode = 'none'; // Nonaktifkan pesan error DataTables

  // Konfigurasi umum DataTables
  const defaultConfig = {
    language: {
      search: "Cari:",
      lengthMenu: "Tampilkan _MENU_ entri",
      info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
      paginate: {
        previous: '<i class="fa fa-chevron-left"></i>',
        next: '<i class="fa fa-chevron-right"></i>'
      },
      emptyTable: "Belum ada data.",
      zeroRecords: "Tidak ditemukan data yang cocok."
    },
    responsive: true,
    columnDefs: [
      { orderable: false, targets: [3] }
    ],
    order: [[0, 'asc']]
  };

  // Inisialisasi tabel
  $('#tabelSemua').DataTable(defaultConfig);

  $('#tabelSudah').DataTable({
    ...defaultConfig,
    language: {
      ...defaultConfig.language,
      emptyTable: "Tidak ada data."
    }
  });

  $('#tabelBelum').DataTable({
    ...defaultConfig,
    language: {
      ...defaultConfig.language,
      emptyTable: "Belum Ada Data"
    }
  });
});

@endpush
