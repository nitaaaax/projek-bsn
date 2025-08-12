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

            {{-- Tabel daftar template with DataTables --}}
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
                                <button class="btn btn-warning btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editTemplateModal" 
                                        data-filename="{{ $file['name'] }}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.templates.destroy', $file['name']) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin hapus template ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
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

{{-- Modals remain unchanged --}}
<!-- ... rest of your modal code ... -->
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
<style>
    /* Custom styles matching your reference table */
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
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
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
            { orderable: false, targets: [2] } // Disable sorting for action column
        ],
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        initComplete: function() {
            // Add custom classes after initialization
            $('.dataTables_length select').addClass('form-select form-select-sm');
            $('.dataTables_filter input').addClass('form-control form-control-sm');
        }
    });
});

// Edit Modal
document.addEventListener('DOMContentLoaded', function() {
    var editModal = document.getElementById('editTemplateModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var filename = button.getAttribute('data-filename');
        var form = document.getElementById('editTemplateForm');
        var baseUrl = "{{ route('admin.templates.update', ['filename' => '--filename--']) }}".replace('--filename--', '');
        form.action = baseUrl + encodeURIComponent(filename);
    });
});
</script>
@endpush