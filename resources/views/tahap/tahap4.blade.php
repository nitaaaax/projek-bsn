<div class="mb-3">
    <label for="alamat" class="form-label fw-bold">Alamat Pemilik/Usaha</label>
    <textarea name="alamat" id="alamat" class="form-control" rows="3">{{ old('alamat', $data->alamat ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="provinsi" class="form-label fw-bold">Provinsi</label>
    <input type="text" name="provinsi" id="provinsi" class="form-control"
        value="{{ old('provinsi', $data->provinsi ?? '') }}">
</div>

<div class="mb-3">
    <label for="kota" class="form-label fw-bold">Kota/Kabupaten</label>
    <input type="text" name="kota" id="kota" class="form-control"
        value="{{ old('kota', $data->kota ?? '') }}">
</div>

<div class="mb-3">
    <label for="legalitas" class="form-label fw-bold">Legalitas Usaha</label>
    <input type="text" name="legalitas" id="legalitas" class="form-control"
        value="{{ old('legalitas', $data->legalitas ?? '') }}">
</div>