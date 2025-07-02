@extends('layout.app')

@section('content')
<div class="container">
    <h4>Form Input SPJ</h4>

    <form action="{{ route('spj.store') }}" method="POST">
        @csrf

        {{-- Nama SPJ di atas --}}
        <div class="mb-3">
            <label for="nama_spj" class="form-label">Nama SPJ</label>
            <input type="text" name="nama_spj" class="form-control" placeholder="Masukkan Nama SPJ" required>
        </div>

        {{-- Daftar Item --}}
        <h5>Detail Item SPJ</h5>
        <div id="spj-rows">
            <div class="row mb-2">
                <div class="col-md-3">
                    <input type="text" name="item[]" class="form-control" placeholder="Item" required>
                </div>
                <div class="col-md-2">
                    <input type="number" name="nominal[]" class="form-control" placeholder="Nominal" required>
                </div>
                <div class="col-md-2">
                    <select name="status_pembayaran[]" class="form-control" required>
                        <option value="belum_dibayar">Belum Dibayar</option>
                        <option value="sudah_dibayar">Sudah Dibayar</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <textarea name="keterangan[]" class="form-control" placeholder="Keterangan" rows="1"></textarea>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger remove">X</button>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-success mb-3" id="addRow">+ Tambah Baris</button>

        <br>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<script>
    document.getElementById('addRow').addEventListener('click', function () {
        const container = document.getElementById('spj-rows');
        const html = `
        <div class="row mb-2">
            <div class="col-md-3">
                <input type="text" name="item[]" class="form-control" placeholder="Item" required>
            </div>
            <div class="col-md-2">
                <input type="number" name="nominal[]" class="form-control" placeholder="Nominal" required>
            </div>
            <div class="col-md-2">
                <select name="status_pembayaran[]" class="form-control" required>
                    <option value="belum_dibayar">Belum Dibayar</option>
                    <option value="sudah_dibayar">Sudah Dibayar</option>
                </select>
            </div>
            <div class="col-md-4">
                <textarea name="keterangan[]" class="form-control" placeholder="Keterangan" rows="1"></textarea>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger remove">X</button>
            </div>
        </div>`;
        container.insertAdjacentHTML('beforeend', html);
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove')) {
            e.target.closest('.row').remove();
        }
    });
</script>
@endsection
