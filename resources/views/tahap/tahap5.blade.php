<div class="mb-3">
    <label for="tahun_berdiri" class="form-label fw-bold">Tahun Pendirian Usaha</label>
    <input type="number" name="tahun_berdiri" id="tahun_berdiri" class="form-control"
        value="{{ old('tahun_berdiri', $data->tahun_berdiri ?? '') }}">
</div>

<div class="mb-3">
    <label for="jenis_usaha" class="form-label fw-bold">Jenis Usaha</label>
    <input type="text" name="jenis_usaha" id="jenis_usaha" class="form-control"
        value="{{ old('jenis_usaha', $data->jenis_usaha ?? '') }}">
</div>

<div class="mb-3">
    <label for="nama_merek" class="form-label fw-bold">Nama Merek</label>
    <input type="text" name="nama_merek" id="nama_merek" class="form-control"
        value="{{ old('nama_merek', $data->nama_merek ?? '') }}">
</div>

<div class="mb-3">
    <label for="sni" class="form-label fw-bold">SNI yang akan dibina</label>
    <input type="text" name="sni" id="sni" class="form-control"
        value="{{ old('sni', $data->sni ?? '') }}">
</div>