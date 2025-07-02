@extends('layout.app')

@section('content')
<div class="container">
    <h2>Data SPJ</h2>
    <a href="{{ route('spj.create') }}" class="btn btn-primary mb-3">+ Tambah SPJ</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama SPJ</th>
                <th>Item</th>
                <th>Nominal</th>
                <th>Status Pembayaran</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($spjs as $spj)
                @foreach ($spj->details as $detail)
                    <tr>
                        <td>{{ $spj->nama_spj }}</td>
                        <td>{{ $detail->item }}</td>
                        <td>Rp {{ number_format($detail->nominal) }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $detail->status_pembayaran)) }}</td>
                        <td>{{ $detail->keterangan }}</td>
                        <td>
                            <div class="d-grid gap-2">
                                <!-- Tombol SPJ Detail -->
                                <a href="{{ route('spj.show', $spj->id) }}" class="btn btn-info btn-sm">SPJ Detail</a>

                                <!-- Tombol Edit -->
                                <a href="{{ route('spj.edit', $spj->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('spj.destroy', $spj->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: 'Data tidak bisa dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endsection
