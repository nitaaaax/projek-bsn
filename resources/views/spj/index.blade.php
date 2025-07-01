@extends('layout.app')
@section('content')
<form action="{{ route('spj.store') }}" method="POST">
    @csrf
    <label>Nama SPJ</label>
    <input type="text" name="nama_spj" required>

    <label>Pembayaran</label>
    <select name="pembayaran">
        <option value="Sudah">Sudah</option>
        <option value="Belum">Belum</option>
    </select>

    <label>Keterangan</label>
    <textarea name="keterangan"></textarea>

    <div id="items">
        <div class="item-row">
            <select name="item[]">
                <option value="Biaya Uji">Biaya Uji</option>
                <option value="Biaya Sampling">Biaya Sampling</option>
                <option value="Biaya Sertifikasi">Biaya Sertifikasi</option>
            </select>
            <input type="number" name="nominal[]" placeholder="Nominal">
        </div>
    </div>

    <button type="button" onclick="addItem()">Tambah Item</button>
    <button type="submit">Simpan</button>
</form>
<script>
function addItem() {
    const html = `
        <div class="item-row">
            <select name="item[]">
                <option value="Biaya Uji">Biaya Uji</option>
                <option value="Biaya Sampling">Biaya Sampling</option>
                <option value="Biaya Sertifikasi">Biaya Sertifikasi</option>
            </select>
            <input type="number" name="nominal[]" placeholder="Nominal">
        </div>`;
    document.getElementById('items').insertAdjacentHTML('beforeend', html);
}
</script>
@endsection


// resources/views/spj/show.blade.php
@extends('layout.app')
@section('content')
<h3>Detail SPJ: {{ $spj->nama_spj }}</h3>
<p>Pembayaran: {{ $spj->pembayaran }}</p>
<p>Keterangan: {{ $spj->keterangan }}</p>

<table class="table">
    <thead>
        <tr>
            <th>Item</th>
            <th>Nominal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($spj->details as $item)
        <tr>
            <td>{{ $item->item }}</td>
            <td>Rp{{ number_format($item->nominal, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection