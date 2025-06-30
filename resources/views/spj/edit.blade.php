@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Data SPJ</h2>
    <form action="{{ route('spj.update', $spj->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama SPJ</label>
            <input type="text" name="nama_spj" class="form-control" value="{{ $spj->nama_spj }}" required>
        </div>
        <div class="mb-3">
            <label>Item</label>
            <input type="text" name="item" class="form-control" value="{{ $spj->item }}" required>
        </div>
        <div class="mb-3">
            <label>Nominal</label>
            <input type="number" name="nominal" class="form-control" value="{{ $spj->nominal }}" required>
        </div>
        <div class="mb-3">
            <label>Pembayaran</label>
            <select name="pembayaran" class="form-control">
                <option value="Sudah" {{ $spj->pembayaran == 'Sudah' ? 'selected' : '' }}>Sudah</option>
                <option value="Belum" {{ $spj->pembayaran == 'Belum' ? 'selected' : '' }}>Belum</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control">{{ $spj->keterangan }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
