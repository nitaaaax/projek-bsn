<div class="row">
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

    {{-- Tanggal --}}
    <div class="mb-3 col-md-6">
        <label for="tanggal" class="form-label fw-bold">Tanggal</label>
        <input type="date" name="tanggal" id="tanggal" class="form-control"
            value="{{ old('tanggal', $data->tanggal ?? '') }}">
    </div>

    {{-- Catatan --}}
    <div class="mb-3 col-md-6">
        <label for="catatan" class="form-label fw-bold">Catatan</label>
        <textarea name="catatan" id="catatan" class="form-control" rows="3">{{ old('catatan', $data->catatan ?? '') }}</textarea>
    </div>
</div>
