<div class="row">

<input type="hidden" name="pelaku_usaha_id" value="{{ $pelaku_usaha_id ?? $id }}">


    <div class="row">
        <div class="mb-3 col-md-4">
            <label class="form-label">Alamat Kantor</label>
            <input type="text" name="alamat_kantor" class="form-control"
                value="{{ old('alamat_kantor', $data->alamat_kantor ?? '') }}">
        </div>
        <div class="mb-3 col-md-4">
            <label class="form-label">Provinsi Kantor</label>
            <input type="text" name="provinsi_kantor" class="form-control"
                value="{{ old('provinsi_kantor', $data->provinsi_kantor ?? '') }}">
        </div>
        <div class="mb-3 col-md-4">
            <label class="form-label">Kota/Kabupaten Kantor</label>
            <input type="text" name="kota_kantor" class="form-control"
                value="{{ old('kota_kab_kantor', $data->kota_kab_kantor ?? '') }}">
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-4">
            <label class="form-label">Alamat Pabrik</label>
            <input type="text" name="alamat_pabrik" class="form-control"
                value="{{ old('alamat_pabrik', $data->alamat_pabrik ?? '') }}">
        </div>
        <div class="mb-3 col-md-4">
            <label class="form-label">Provinsi Pabrik</label>
            <input type="text" name="provinsi_pabrik" class="form-control"
                value="{{ old('provinsi_pabrik', $data->provinsi_pabrik ?? '') }}">
        </div>
        <div class="mb-3 col-md-4">
            <label class="form-label">Kota/Kabupaten Pabrik</label>
            <input type="text" name="kota_pabrik" class="form-control"
                value="{{ old('kota_kab_pabrik', $data->kota_kab_pabrik ?? '') }}">
        </div>
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
