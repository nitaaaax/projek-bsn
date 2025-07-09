
<div class="row">

<input type="hidden" name="pelaku_usaha_id" value="{{ $pelaku_usaha_id ?? $id }}">

    {{-- Pembina II --}}
    <div class="mb-3 col-md-6">
        <label for="pembina_2" class="form-label fw-bold">Pembina II</label>
        <input type="text" name="pembina_2" id="pembina_2" class="form-control"
            value="{{ old('pembina_2', $data->pembina_2 ?? '') }}">
    </div>

    {{-- Sinergi --}}
    <div class="mb-3 col-md-6">
        <label for="sinergi" class="form-label fw-bold">Sinergi</label>
        <input type="text" name="sinergi" id="sinergi" class="form-control"
            value="{{ old('sinergi', $data->sinergi ?? '') }}">
    </div>

    {{-- Nama Kontak Person --}}
    <div class="mb-3 col-md-6">
        <label for="nama_kontak_person" class="form-label fw-bold">Nama Kontak Person</label>
        <input type="text" name="nama_kontak_person" id="nama_kontak_person" class="form-control"
            value="{{ old('nama_kontak_person', $data->nama_kontak_person ?? '') }}">
    </div>

    {{-- No HP --}}
    <div class="mb-3 col-md-6">
        <label for="No_Hp" class="form-label fw-bold">No HP/Telp</label>
        <input type="text" name="No_Hp" id="No_Hp" class="form-control"
            value="{{ old('No_Hp', $data->No_Hp ?? '') }}">
    </div>

    {{-- Bulan Pertama Pembinaan --}}
       <div class="mb-3 col-md-6">
        <label for="bulan_pembinaan" class="form-label fw-bold">Bulan Pembinaan</label>
        <select name="bulan_pertama_pembinaan" id="bulan_pembinaan" class="form-control" required>
            <option value="">-- Pilih Bulan --</option>
            @foreach(
                [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                ] 
                as $num => $nama)
                <option value="{{ $num }}" {{ old('bulan__pertama_pembinaan', $data->bulan__pertama_pembinaan ?? '') == $num ? 'selected' : '' }}>
                    {{ $nama }}
                </option>
            @endforeach
        </select>
    </div>
</div>
