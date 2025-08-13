@extends('layout.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h4 class="mb-4 text-primary fw-bold">
                <i class="fa fa-file-word me-2"></i> Manajemen Template
            </h4>

            {{-- Tombol tambah --}}
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addTemplateModal">
                <i class="fa fa-plus"></i> Tambah Template
            </button>

            {{-- Tabel daftar template --}}
            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="templateTable">
                    <thead class="table-light">
                        <tr>
                            <th>Nama File</th>
                            <th>Path</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($files as $file)
                        <tr>
                            <td>{{ $file['name'] }}</td>
                            <td>{{ $file['path'] }}</td>
                            <td>
                                {{-- Edit --}}
                                <button class="btn btn-warning btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editTemplateModal" 
                                        data-filename="{{ $file['name'] }}">
                                    <i class="fa fa-edit"></i>
                                </button>

                                {{-- Hapus --}}
                                <form action="{{ route('admin.templates.destroy', $file['name']) }}" method="POST" class="delete-form d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm btn-delete" data-filename="{{ $file['name'] }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">Belum ada template</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="addTemplateModal" tabindex="-1" aria-labelledby="addTemplateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.templates.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addTemplateModalLabel">Tambah Template</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file" class="form-label">Upload File</label>
                        <input type="file" name="file" id="file" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal fade" id="editTemplateModal" tabindex="-1" aria-labelledby="editTemplateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editTemplateForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editTemplateModalLabel">Edit Template</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editFile" class="form-label">Ganti File</label>
                        <input type="file" name="file" id="editFile" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
<style>
    #templateTable_wrapper .dataTables_filter input {
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 4px 10px;
    }
    #templateTable_wrapper .dataTables_length select {
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 3px 5px;
    }
    #templateTable_paginate .paginate_button {
        padding: 5px 10px;
        border: 1px solid #dee2e6;
        margin-left: 2px;
        border-radius: 4px;
    }
    #templateTable_paginate .paginate_button.previous,
    #templateTable_paginate .paginate_button.next {
        font-size: 0;
    }
    #templateTable_paginate .paginate_button.previous:before {
        content: "←";
        font-size: initial;
    }
    #templateTable_paginate .paginate_button.next:before {
        content: "→";
        font-size: initial;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(function() {
    // DataTables init
    $('#templateTable').DataTable({
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
        },
        columnDefs: [
            { orderable: false, targets: [2] }
        ],
        initComplete: function() {
            $('.dataTables_length select').addClass('form-select form-select-sm');
            $('.dataTables_filter input').addClass('form-control form-control-sm');
        }
    });

    // SweetAlert hapus
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        let form = $(this).closest('form');
        let filename = $(this).data('filename');

        Swal.fire({
            title: 'Yakin hapus template ini?',
            text: filename,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // Edit modal
    let editModal = document.getElementById('editTemplateModal');
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function (event) {
            let button = event.relatedTarget;
            let filename = button.getAttribute('data-filename');
            let form = document.getElementById('editTemplateForm');
            if (form) {
                let baseUrl = "{{ route('admin.templates.update', ['filename' => '--filename--']) }}".replace('--filename--', '');
                form.action = baseUrl + encodeURIComponent(filename);
            }
        });
    }
});
</script>
@endpush
