<div class="mb-3">
    <label for="pembina_2" class="form-label fw-bold">Pembina II</label>
    <input type="text" name="pembina_2" id="pembina_2" class="form-control"
        value="{{ old('pembina_2', $data->pembina_2 ?? '') }}">
</div>

<div class="mb-3">
    <label for="sinergi" class="form-label fw-bold">Sinergi</label>
    <input type="text" name="sinergi" id="sinergi" class="form-control"
        value="{{ old('sinergi', $data->sinergi ?? '') }}">
</div>

<div class="mb-3">
    <label for="nama_kontak" class="form-label fw-bold">Nama Kontak Person</label>
    <input type="text" name="nama_kontak" id="nama_kontak" class="form-control"
        value="{{ old('nama_kontak', $data->nama_kontak ?? '') }}">
</div>
<div class="mb-3">
    <label for="no_hp" class="form-label fw-bold">No HP/Telp</label>
    <input type="text" name="no_hp" id="no_hp" class="form-control"
        value="{{ old('no_hp', $data->no_hp ?? '') }}">
</div>