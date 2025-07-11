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

    {{-- Status Pmebinaan --}}
   <div class="mb-3 col-md-6">
    <label for="status_pembinaan" class="form-label fw-bold">Status Pembinaan</label>
    <select name="status_pembinaan" id="status_pembinaan" class="form-control">
        <option value="">-- Pilih Status --</option>
        <option value="1. Identifikasi awal dan Gap" {{ old('status_pembinaan', $data->status_pembinaan ?? '') == '1. Identifikasi awal dan Gap' ? 'selected' : '' }}>1. Identifikasi awal dan Gap</option>
        <option value="2. Set up Sistem" {{ old('status_pembinaan', $data->status_pembinaan ?? '') == '2. Set up Sistem' ? 'selected' : '' }}>2. Set up Sistem</option>
        <option value="3. Implementasi" {{ old('status_pembinaan', $data->status_pembinaan ?? '') == '3. Implementasi' ? 'selected' : '' }}>3. Implementasi</option>
        <option value="4. Review Sistem & Audit Internal" {{ old('status_pembinaan', $data->status_pembinaan ?? '') == '4. Review Sistem & Audit Internal' ? 'selected' : '' }}>4. Review Sistem & Audit Internal</option>
        <option value="5. Pengajuan Sertifikasi" {{ old('status_pembinaan', $data->status_pembinaan ?? '') == '5. Pengajuan Sertifikasi' ? 'selected' : '' }}>5. Pengajuan Sertifikasi</option>
        <option value="6. Perbaikan Temuan Audit" {{ old('status_pembinaan', $data->status_pembinaan ?? '') == '6. Perbaikan Temuan Audit' ? 'selected' : '' }}>6. Perbaikan Temuan Audit</option>
        <option value="7. Perbaikan Lokasi" {{ old('status_pembinaan', $data->status_pembinaan ?? '') == '7. Perbaikan Lokasi' ? 'selected' : '' }}>7. Perbaikan Lokasi</option>
<option value="8. SPPT SNI"
  style="font-weight:bold; color:green;"
  {{ old('status_pembinaan', $data->status_pembinaan ?? '') == '8. SPPT SNI' ? 'selected' : '' }}>
  8. SPPT SNI (Tersertifikasi)
</option>
    </select>
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
