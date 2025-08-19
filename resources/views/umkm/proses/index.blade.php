@extends('layout.app')

@section('content')
<div class="container mt-4">
    <div class="card border-0 shadow rounded-4">
        <div class="card-body">

            {{-- Judul --}}
            <h3 class="mb-4 text-primary fw-bold">
                <i class="fa fa-database me-2"></i> Data UMKM Proses
            </h3>

            {{-- Tombol Aksi --}}
            <div class="d-flex flex-wrap mb-4 gap-2">
                @if(optional(Auth::user()->role)->name === 'admin')
                <a href="{{ route('admin.umkm.create', ['tahap' => 1, 'id' => $id ?? null]) }}" class="btn btn-primary mb-2">
                    <i class="fa fa-plus me-1"></i> Tambah UMKM
                </a>
                @endif

                @if(optional(Auth::user()->role)->name === 'admin')
                <button type="button" class="btn btn-warning text-dark mb-2" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="fa fa-file-import me-1"></i> Import Excel
                </button>
                @endif
            </div>

            {{-- Tabel --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center" id="tabelUMKM" style="width:100%">
                    <thead class="table-primary">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Pelaku</th>
                            <th>Produk</th>
                            <th width="15%">Status</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tahap1 ?? [] as $t)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-start">{{ $t->nama_pelaku }}</td>
                                <td>{{ trim($t->produk ?? '') !== '' ? $t->produk : '-' }}</td>
                                <td><span class="badge bg-secondary">{{ trim($t->status ?? '') !== '' ? $t->status : '-' }}</span></td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        @php $role = optional(Auth::user()->role)->name; @endphp
                                        @if($role === 'admin')
                                        <a href="{{ route('admin.umkm.show', $t->id) }}#top" class="btn btn-warning btn-sm px-3" title="Detail">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @elseif($role === 'user')
                                        <a href="{{ route('user.umkm.showuser', $t->id) }}#top" class="btn btn-info btn-sm px-3" title="Detail">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        @endif

                                        <a href="{{ route('umkm.export.word.single', $t->id) }}" class="btn btn-success btn-sm px-3" title="Download">
                                            <i class="fa fa-download"></i>
                                        </a>

                                        @if($role === 'admin')
                                        <form action="{{ route('admin.umkm.destroy', $t->id) }}" method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm px-3" title="Hapus">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-muted">Tidak ada data UMKM yang tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Modal Import --}}
            <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('admin.umkm.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="importModalLabel">Import Data UMKM</h5>
                                <button type="button" class="btn btn-sm btn-danger rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 32px; height: 32px;"
                                    data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <i class="fa fa-times text-white"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="file" class="form-label">Pilih file Excel (.xlsx / .xls / .csv)</label>
                                    <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Import Sekarang</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
{{-- DataTables CSS --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    /* Custom CSS untuk perbaikan tampilan */
    #tabelUMKM {
        font-size: 14px;
    }
    
    #tabelUMKM th, #tabelUMKM td {
        padding: 8px 12px;
        vertical-align: middle;
    }
    
    #tabelUMKM .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        transition: all 0.2s;
    }
    
    #tabelUMKM .btn-sm:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    /* Untuk tombol aksi */
    .d-flex.gap-2 > * {
        margin: 0 2px;
    }
    
    /* Responsive table */
    @media (max-width: 768px) {
        #tabelUMKM {
            font-size: 13px;
        }
        
        #tabelUMKM .btn-sm {
            padding: 0.2rem 0.4rem;
            font-size: 0.7rem;
        }
    }
</style>
@endpush

@push('scripts')
{{-- JQuery (DataTables membutuhkan ini) --}}
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- Toastr --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
{{-- DataTables Core JS --}}
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
{{-- DataTables Bootstrap 5 JS --}}
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
{{-- DataTables Responsive --}}
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>


<script>
$(document).ready(function () {
    // Matikan warning default DataTables
    $.fn.dataTable.ext.errMode = 'none';

    // Inisialisasi DataTables
    $('#tabelUMKM').DataTable({
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            paginate: {
                previous: '<i class="fa fa-chevron-left"></i>',
                next: '<i class="fa fa-chevron-right"></i>'
            },
            zeroRecords: "Tidak ada data ditemukan",
            infoEmpty: "Menampilkan 0 data",
            infoFiltered: "(disaring dari _MAX_ total data)",
        },
        responsive: true,
        autoWidth: false,
        columnDefs: [
            { orderable: false, targets: [4] }, 
            { width: "10%", targets: [0, 3] }, 
            { width: "20%", targets: [4] }
        ],
        dom: '<"top"lf>rt<"bottom"ip>',
        initComplete: function() {
            $('.dataTables_filter input').addClass('form-control');
            $('.dataTables_length select').addClass('form-select');
        }
    });

    // SweetAlert konfirmasi hapus
    $(document).on('submit', '.delete-form', function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });

    // === Toastr Notifikasi ===
    @if(session('success'))
        toastr.success("{{ session('success') }}", "Berhasil!", {
            closeButton: true,
            progressBar: true,
            timeOut: 4000
        });
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}", "Gagal!", {
            closeButton: true,
            progressBar: true,
            timeOut: 5000
        });
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            toastr.warning("{{ $error }}", "Validasi!", {
                closeButton: true,
                progressBar: true,
                timeOut: 6000
            });
        @endforeach
    @endif
});
</script>
@endpush
