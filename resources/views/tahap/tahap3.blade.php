<div class="row">
    {{-- Jenis Usaha --}}
    <div class="mb-3 col-md-6">
        <label for="jenis_usaha" class="form-label fw-bold">Jenis Usaha</label>
        <input type="text" name="jenis_usaha" id="jenis_usaha" class="form-control"
            value="{{ old('jenis_usaha', $data->jenis_usaha ?? '') }}">
    </div>

    {{-- Nama Merek --}}
    <div class="mb-3 col-md-6">
        <label for="nama_merek" class="form-label fw-bold">Nama Merek</label>
        <input type="text" name="nama_merek" id="nama_merek" class="form-control"
            value="{{ old('nama_merek', $data->nama_merek ?? '') }}">
    </div>

    {{-- Legalitas --}}
    <div class="mb-3 col-md-6">
        <label for="legalitas" class="form-label fw-bold">Legalitas</label>
        <input type="text" name="legalitas" id="legalitas" class="form-control"
            value="{{ old('legalitas', $data->legalitas ?? '') }}">
    </div>

    {{-- Tahun Pendirian --}}
    <div class="mb-3 col-md-6">
        <label for="tahun_pendirian" class="form-label fw-bold">Tahun Pendirian</label>
        <input type="number" name="tahun_pendirian" id="tahun_pendirian" class="form-control"
            value="{{ old('tahun_pendirian', $data->tahun_pendirian ?? '') }}">
    </div>

    {{-- SNI --}}
    <div class="mb-3 col-md-6">
        <label class="form-label fw-bold d-block">Apakah sudah SNI?</label>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="sni" id="sni_yes" value="1"
                {{ old('sni', $data->sni ?? '') == 1 ? 'checked' : '' }}>
            <label class="form-check-label" for="sni_yes">Ya</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="sni" id="sni_no" value="0"
                {{ old('sni', $data->sni ?? '') === 0 ? 'checked' : '' }}>
            <label class="form-check-label" for="sni_no">Tidak</label>
        </div>
    </div>
</div>
