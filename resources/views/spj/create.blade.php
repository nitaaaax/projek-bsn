@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h2>Tambah SPJ</h2>
    <form action="{{ route('spj.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama SPJ</label>
            <input type="text" name="nama_spj" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Item</label>
            <input type="text" name="item" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nominal</label>
            <input type="number" name="nominal" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Pembayaran</label>
            <select name="pembayaran" class="form-control" required>
                <option value="Sudah">Sudah</option>
                <option value="Belum">Belum</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
