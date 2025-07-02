@extends('layout.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Form Input SPJ</h4>

    <form action="{{ route('spj.store') }}" method="POST">
        @csrf

        {{-- Nama SPJ --}}
        <div class="mb-4">
            <label for="nama_spj" class="form-label"><strong>Nama SPJ</strong></label>
            <input type="text" name="nama_spj" class="form-control" placeholder="Masukkan Nama SPJ" required>
        </div>

        {{-- Tabel Item --}}
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr>
                        <th style="width: 20%">Item</th>
                        <th style="width: 15%">Nominal</th>
                        <th style="width: 20%">Status Pembayaran</th>
                        <th style="width: 35%">Keterangan</th>
                        <th style="width: 10%">Aksi</th>
                    </tr>
                </thead>
                <tbody id="spj-rows">
                    <tr>
                        <td><input type="text" name="item[]" class="form-control" required></td>
                        <td><input type="number" name="nominal[]" class="form-control nominal" required></td>
                        <td>
                            <select name="status_pembayaran[]" class="form-control" required>
                                <option value="belum_dibayar">Belum Dibayar</option>
                                <option value="sudah_dibayar">Sudah Dibayar</option>
                            </select>
                        </td>
                        <td><textarea name="keterangan[]" class="form-control" rows="1"></textarea></td>
                        <td><button type="button" class="btn btn-danger btn-sm remove">Hapus</button></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mb-3 text-end">
            <button type="button" class="btn btn-success" id="addRow">+ Tambah Baris</button>
        </div>

        <div class="mb-3">
            <h5>Total: <span id="total-rp">Rp 0</span></h5>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

{{-- SCRIPT --}}
<script>
    function updateTotal() {
        let total = 0;
        document.querySelectorAll('.nominal').forEach(input => {
            total += parseInt(input.value) || 0;
        });
        document.getElementById('total-rp').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    document.getElementById('addRow').addEventListener('click', function () {
        const newRow = `
            <tr>
                <td><input type="text" name="item[]" class="form-control" required></td>
                <td><input type="number" name="nominal[]" class="form-control nominal" required></td>
                <td>
                    <select name="status_pembayaran[]" class="form-control" required>
                        <option value="belum_dibayar">Belum Dibayar</option>
                        <option value="sudah_dibayar">Sudah Dibayar</option>
                    </select>
                </td>
                <td><textarea name="keterangan[]" class="form-control" rows="1"></textarea></td>
                <td><button type="button" class="btn btn-danger btn-sm remove">Hapus</button></td>
            </tr>
        `;
        document.getElementById('spj-rows').insertAdjacentHTML('beforeend', newRow);
        updateTotal();
    });

    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('nominal')) {
            updateTotal();
        }
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove')) {
            e.target.closest('tr').remove();
            updateTotal();
        }
    });

    updateTotal();
</script>
@endsection
