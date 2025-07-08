{{-- tahap/tahap6.blade.php --}}

<div class="mb-3">
    <label for="lspro" class="form-label fw-bold">LSPro/LS</label>
    <input type="text" name="lspro" id="lspro" class="form-control"
        value="{{ old('lspro', $data->lspro ?? '') }}">
</div>

<div class="mb-3">
    <label for="omzet" class="form-label fw-bold">Jumlah Omzet per Tahun</label>
    <input type="text" name="omzet" id="omzet" class="form-control"
        value="{{ old('omzet', $data->omzet ?? '') }}">
</div>

<div class="mb-3">
    <label for="volume" class="form-label fw-bold">Volume Produksi per Tahun</label>
    <input type="text" name="volume" id="volume" class="form-control"
        value="{{ old('volume', $data->volume ?? '') }}">
</div>

<div class="mb-3">
    <label for="tenaga_kerja" class="form-label fw-bold">Jumlah Tenaga Kerja</label>
    <input type="number" name="tenaga_kerja" id="tenaga_kerja" class="form-control"
        value="{{ old('tenaga_kerja', $data->tenaga_kerja ?? '') }}">
</div>

<div class="mb-3">
    <label for="jangkauan" class="form-label fw-bold">Jangkauan Pemasaran</label>
    <input type="text" name="jangkauan" id="jangkauan" class="form-control"
        value="{{ old('jangkauan', $data->jangkauan ?? '') }}">
</div>

<div class="mb-3">
    <label for="dokumen_mutu" class="form-label fw-bold">Link Dokumen Mutu</label>
    <input type="url" name="dokumen_mutu" id="dokumen_mutu" class="form-control"
        value="{{ old('dokumen_mutu', $data->dokumen_mutu ?? '') }}">
</div>
