<div class="row">

    <input type="hidden" name="pelaku_usaha_id" value="{{ $pelaku_usaha_id ?? $id }}">

    {{-- Tahun Dibina --}}
    <div class="mb-3 col-md-6">
        <label for="tahun_dibina" class="form-label fw-bold">Tahun Dibina</label>
        <input type="number" name="tahun_dibina" id="tahun_dibina" class="form-control"
            value="{{ old('tahun_dibina', $data->tahun_dibina ?? '') }}">
    </div>

    {{-- Riwayat Pembinaan --}}
    <div class="mb-3 col-md-6">
        <label for="riwayat_pembinaan" class="form-label fw-bold">Riwayat Pembinaan</label>
        <input type="text" name="riwayat_pembinaan" id="riwayat_pembinaan" class="form-control"
            value="{{ old('riwayat_pembinaan', $data->riwayat_pembinaan ?? '') }}">
    </div>

    {{-- Gruping --}}
    <div class="mb-3 col-md-6">
        <label for="gruping" class="form-label fw-bold">Gruping</label>
        <input type="text" name="gruping" id="gruping" class="form-control"
            value="{{ old('gruping', $data->gruping ?? '') }}">
    </div>

    {{-- Email --}}
    <div class="mb-3 col-md-6">
        <label for="email" class="form-label fw-bold">Email</label>
        <input type="email" name="email" id="email" class="form-control"
            value="{{ old('email', $data->email ?? '') }}">
    </div>

    {{-- Media Sosial --}}
    <div class="mb-3 col-md-6">
        <label for="media_sosial" class="form-label fw-bold">Media Sosial</label>
        <input type="text" name="media_sosial" id="media_sosial" class="form-control"
            value="{{ old('media_sosial', $data->media_sosial ?? '') }}">
    </div>
</div>
