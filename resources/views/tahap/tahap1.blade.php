<input type="hidden" name="id" value="{{ $id }}">


{{-- Form Tahap 1 --}}

<div class="mb-3">
    <label for="nama_pelaku" class="form-label fw-bold">Nama Pelaku Usaha</label>
    <input type="text" name="nama_pelaku" id="nama_pelaku" class="form-control"
        value="{{ old('nama_pelaku', $data->nama_pelaku ?? '') }}">
</div>

<div class="mb-3">
    <label for="produk" class="form-label fw-bold">Produk</label>
    <input type="text" name="produk" id="produk" class="form-control"
        value="{{ old('produk', $data->produk ?? '') }}">
</div>

<div class="mb-3">
    <label for="klasifikasi" class="form-label fw-bold">Klasifikasi Pelaku Usaha</label>
    <input type="text" name="klasifikasi" id="klasifikasi" class="form-control"
        value="{{ old('klasifikasi', $data->klasifikasi ?? '') }}">
</div>

<div class="mb-3">
    <label for="status" class="form-label fw-bold">Status</label>
    <select name="status" id="status" class="form-control">
        <option value="">-- Pilih Status --</option>
        <option value="Masih Dibina" {{ old('status', $data->status ?? '') == 'Masih Dibina' ? 'selected' : '' }}>Masih Dibina</option>
        <option value="Drop/Tidak Dilanjutkan" {{ old('status', $data->status ?? '') == 'Drop/Tidak Dilanjutkan' ? 'selected' : '' }}>Drop/Tidak Dilanjutkan</option>
    </select>
</div>

<div class="mb-3">
    <label for="pembina_1" class="form-label fw-bold">Pembina I</label>
    <input type="text" name="pembina_1" id="pembina_1" class="form-control"
        value="{{ old('pembina_1', $data->pembina_1 ?? '') }}">
</div>

{{-- Toastr error message --}}
@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            toastr.error("{{ $error }}");
        </script>
    @endforeach
@endif
