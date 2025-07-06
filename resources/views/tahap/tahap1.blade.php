{{-- Form Tahap 1 --}}

<div class="mb-3">
    <label for="nama_pelaku" class="form-label fw-bold">Nama Pelaku</label>
    <input type="text" name="nama_pelaku" id="nama_pelaku" class="form-control"
        value="{{ old('nama_pelaku', $data->nama_pelaku ?? '') }}">
</div>

<div class="mb-3">
    <label for="produk" class="form-label fw-bold">Produk</label>
    <input type="text" name="produk" id="produk" class="form-control"
        value="{{ old('produk', $data->produk ?? '') }}">
</div>

<div class="mb-3">
    <label for="klasifikasi" class="form-label fw-bold">Klasifikasi</label>
    <input type="text" name="klasifikasi" id="klasifikasi" class="form-control"
        value="{{ old('klasifikasi', $data->klasifikasi ?? '') }}">
</div>

<div class="mb-3">
    <label for="status" class="form-label fw-bold">Status</label>
    <select name="status" id="status" class="form-control">
        <option value="">-- Pilih Status --</option>
        <option value="aktif" {{ old('status', $data->status ?? '') == 'aktif' ? 'selected' : '' }}>Aktif</option>
        <option value="tidak_aktif" {{ old('status', $data->status ?? '') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
    </select>
</div>

<div class="mb-3">
    <label for="provinsi" class="form-label fw-bold">Provinsi</label>
    <input type="text" name="provinsi" id="provinsi" class="form-control"
        value="{{ old('provinsi', $data->provinsi ?? '') }}">
</div>


<!--toastr-->
@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            toastr.error("{{ $error }}");
        </script>
    @endforeach
@endif
