<div class="row">

<input type="hidden" name="pelaku_usaha_id" value="{{ $pelaku_usaha_id ?? $id }}">


    {{-- Alamat --}}
    <div class="mb-3 col-md-6">
        <label for="alamat" class="form-label fw-bold">Alamat</label>
        <textarea name="alamat" id="alamat" class="form-control">{{ old('alamat', $data->alamat ?? '') }}</textarea>
    </div>

    {{-- Provinsi --}}
    <div class="mb-3 col-md-6">
        <label for="provinsi" class="form-label fw-bold">Provinsi</label>
        <input type="text" name="provinsi" id="provinsi" class="form-control"
            value="{{ old('provinsi', $data->provinsi ?? '') }}">
    </div>

    {{-- Kota --}}
    <div class="mb-3 col-md-6">
        <label for="kota" class="form-label fw-bold">Kota/Kabupaten</label>
        <input type="text" name="kota" id="kota" class="form-control"
            value="{{ old('kota', $data->kota ?? '') }}">
    </div>

    {{-- Legalitas Usaha --}}
    <div class="mb-3 col-md-6">
        <label for="legalitas_usaha" class="form-label fw-bold">Legalitas Usaha</label>
        <input type="text" name="legalitas_usaha" id="legalitas_usaha" class="form-control"
            value="{{ old('legalitas_usaha', $data->legalitas_usaha ?? '') }}">
    </div>

    {{-- Tahun Pendirian --}}
    <div class="mb-3 col-md-6">
        <label for="tahun_pendirian" class="form-label fw-bold">Tahun Pendirian</label>
        <input type="number" name="tahun_pendirian" id="tahun_pendirian" class="form-control"
            value="{{ old('tahun_pendirian', $data->tahun_pendirian ?? '') }}">
    </div>
</div>
