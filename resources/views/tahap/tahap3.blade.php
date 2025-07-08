<select name="bulan_pembinaan" id="bulan_pembinaan" class="form-control" required>
    <option value="">-- Pilih Bulan --</option>
    <option value="1" {{ old('bulan_pembinaan', $data->bulan_pembinaan ?? '') == 1 ? 'selected' : '' }}>Januari</option>
    <option value="2" {{ old('bulan_pembinaan', $data->bulan_pembinaan ?? '') == 2 ? 'selected' : '' }}>Februari</option>
    <option value="3" {{ old('bulan_pembinaan', $data->bulan_pembinaan ?? '') == 3 ? 'selected' : '' }}>Maret</option>
    <option value="4" {{ old('bulan_pembinaan', $data->bulan_pembinaan ?? '') == 3 ? 'selected' : '' }}>April</option>
    <option value="5" {{ old('bulan_pembinaan', $data->bulan_pembinaan ?? '') == 3 ? 'selected' : '' }}>Mei</option>
    <option value="5" {{ old('bulan_pembinaan', $data->bulan_pembinaan ?? '') == 3 ? 'selected' : '' }}>Juni</option>
    <option value="7" {{ old('bulan_pembinaan', $data->bulan_pembinaan ?? '') == 3 ? 'selected' : '' }}>Juli</option>
    <option value="8" {{ old('bulan_pembinaan', $data->bulan_pembinaan ?? '') == 3 ? 'selected' : '' }}>Agustus</option>
    <option value="9" {{ old('bulan_pembinaan', $data->bulan_pembinaan ?? '') == 3 ? 'selected' : '' }}>September</option>
    <option value="10" {{ old('bulan_pembinaan', $data->bulan_pembinaan ?? '') == 3 ? 'selected' : '' }}>Oktober</option>
    <option value="11" {{ old('bulan_pembinaan', $data->bulan_pembinaan ?? '') == 3 ? 'selected' : '' }}>November</option>
    <option value="12" {{ old('bulan_pembinaan', $data->bulan_pembinaan ?? '') == 3 ? 'selected' : '' }}>Desember</option>

</select>


<div class="mb-3">
    <label for="tahun_dibina" class="form-label fw-bold">Tahun dibina</label>
    <input type="number" name="tahun_dibina" id="tahun_dibina" class="form-control"
        value="{{ old('tahun_dibina', $data->tahun_dibina ?? '') }}">
</div>

<div class="mb-3">
    <label for="riwayat_pembinaan" class="form-label fw-bold">Riwayat Pembinaan</label>
    <input type="text" name="riwayat_pembinaan" id="riwayat_pembinaan" class="form-control"
        value="{{ old('riwayat_pembinaan', $data->riwayat_pembinaan ?? '') }}">
</div>

<div class="mb-3">
    <label for="gruping" class="form-label fw-bold">Gruping</label>
    <input type="text" name="gruping" id="gruping" class="form-control"
        value="{{ old('gruping', $data->gruping ?? '') }}">
</div>

<div class="mb-3">
    <label for="email" class="form-label fw-bold">Email</label>
    <input type="email" name="email" id="email" class="form-control"
        value="{{ old('email', $data->email ?? '') }}">
</div>

<div class="mb-3">
    <label for="media_sosial" class="form-label fw-bold">Media Sosial</label>
    <input type="text" name="media_sosial" id="media_sosial" class="form-control"
        value="{{ old('media_sosial', $data->media_sosial ?? '') }}">
</div>