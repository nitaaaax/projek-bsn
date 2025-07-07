<div class="row">
    {{-- Omzet per Tahun --}}
    <div class="mb-3 col-md-6">
        <label for="omzet_per_tahun" class="form-label fw-bold">Omzet per Tahun</label>
        <input type="number" name="omzet_per_tahun" id="omzet_per_tahun" class="form-control"
            value="{{ old('omzet_per_tahun', $data->omzet_per_tahun ?? '') }}">
    </div>

    {{-- Volume Produksi --}}
    <div class="mb-3 col-md-6">
        <label for="volume_produksi" class="form-label fw-bold">Volume Produksi</label>
        <input type="number" name="volume_produksi" id="volume_produksi" class="form-control"
            value="{{ old('volume_produksi', $data->volume_produksi ?? '') }}">
    </div>

    {{-- Tenaga Kerja --}}
    <div class="mb-3 col-md-6">
        <label for="tenaga_kerja" class="form-label fw-bold">Jumlah Tenaga Kerja</label>
        <input type="number" name="tenaga_kerja" id="tenaga_kerja" class="form-control"
            value="{{ old('tenaga_kerja', $data->tenaga_kerja ?? '') }}">
    </div>

    {{-- Jangkauan Pasar --}}
    <div class="mb-3 col-md-6">
        <label for="jangkauan_pasar" class="form-label fw-bold">Jangkauan Pasar</label>
        <input type="text" name="jangkauan_pasar" id="jangkauan_pasar" class="form-control"
            value="{{ old('jangkauan_pasar', $data->jangkauan_pasar ?? '') }}">
    </div>
</div>
