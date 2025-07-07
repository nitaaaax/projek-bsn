<div class="row">
    {{-- Bulan Pertama Dibina --}}
    <div class="mb-3 col-md-6">
        <label for="bulan_pertama" class="form-label fw-bold">Bulan Pertama Dibina</label>
        <input type="text" name="bulan_pertama" id="bulan_pertama" class="form-control"
            value="{{ old('bulan_pertama', $data->bulan_pertama ?? '') }}">
    </div>

    {{-- Tahun Dibina --}}
    <div class="mb-3 col-md-6">
        <label for="tahun_bina" class="form-label fw-bold">Tahun Dibina</label>
        <input type="number" name="tahun_bina" id="tahun_bina" class="form-control"
            value="{{ old('tahun_bina', $data->tahun_bina ?? '') }}">
    </div>

    {{-- Kegiatan --}}
    <div class="mb-3 col-md-6">
        <label for="kegiatan" class="form-label fw-bold">Kegiatan</label>
        <input type="text" name="kegiatan" id="kegiatan" class="form-control"
            value="{{ old('kegiatan', $data->kegiatan ?? '') }}">
    </div>

    {{-- Gruping --}}
    <div class="mb-3 col-md-6">
        <label for="gruping" class="form-label fw-bold">Gruping</label>
        <input type="text" name="gruping" id="gruping" class="form-control"
            value="{{ old('gruping', $data->gruping ?? '') }}">
    </div>
</div>
