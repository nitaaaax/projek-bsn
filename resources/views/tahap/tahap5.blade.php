
<div class="row">

<input type="hidden" name="pelaku_usaha_id" value="{{ $pelaku_usaha_id ?? $id }}">


    {{-- Jenis Usaha --}}
    <div class="mb-3 col-md-6">
    <label for="jenis_usaha" class="form-label fw-bold">Jenis Usaha</label>
    <select name="jenis_usaha" id="jenis_usaha" class="form-select">
        <option value="1" {{ old('jenis_usaha', $data->jenis_usaha ?? '') === true ? 'selected' : '' }}>Pangan</option>
        <option value="0" {{ old('jenis_usaha', $data->jenis_usaha ?? '') === false ? 'selected' : '' }}>Non Pangan</option>
    </select>
    </div>


    {{-- Nama Merek --}}
    <div class="mb-3 col-md-6">
        <label for="nama_merek" class="form-label fw-bold">Nama Merek</label>
        <input type="text" name="nama_merek" id="nama_merek" class="form-control"
            value="{{ old('nama_merek', $data->nama_merek ?? '') }}">
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
                {{ old('sni', $data->sni ?? '') == 0 ? 'checked' : '' }}>
            <label class="form-check-label" for="sni_no">Tidak</label>
        </div>
    </div>

    {{-- Lembaga Sertifikasi (LSPro) --}}
    <div class="mb-3 col-md-6">
        <label for="lspro" class="form-label fw-bold">Lembaga Sertifikasi (LSPro)</label>
        <input type="text" name="lspro" id="lspro" class="form-control"
            value="{{ old('lspro', $data->lspro ?? '') }}">
    </div>
</div>
    {{-- Tanda Daftar Merk --}}

<div class="mb-3">
    <label class="form-label d-block">Tanda Daftar Merek</label>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="tanda_daftar_merk" id="terdaftar" value="1"
            {{ old('tanda_daftar_merk', $data->tanda_daftar_merk ?? 0) == 1 ? 'checked' : '' }}>
        <label class="form-check-label" for="terdaftar">Terdaftar di Kemenkumham</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="tanda_daftar_merk" id="belum_terdaftar" value="0"
            {{ old('tanda_daftar_merk', $data->tanda_daftar_merk ?? 0) == 0 ? 'checked' : '' }}>
        <label class="form-check-label" for="belum_terdaftar">Belum Terdaftar</label>
    </div>
</div>

