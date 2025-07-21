<form action="{{ route('tahap.store', 6) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="pelaku_usaha_id" value="{{ $pelaku_usaha_id }}">

    <div class="mb-3">
        <label for="omzet" class="form-label fw-bold">Jumlah Omzet per Tahun</label>
        <input type="number" name="omzet" id="omzet" class="form-control"
            value="{{ old('omzet', $data->omzet ?? '') }}">
    </div>

    <div class="mb-3">
        <label for="volume_per_tahun" class="form-label fw-bold">Volume Produksi per Tahun</label>
        <input type="number" name="volume_per_tahun" id="volume_per_tahun" class="form-control"
            value="{{ old('volume_per_tahun', $data->volume_per_tahun ?? '') }}">
    </div>

    <div class="mb-3">
        <label for="jumlah_tenaga_kerja" class="form-label fw-bold">Jumlah Tenaga Kerja</label>
        <input type="number" name="jumlah_tenaga_kerja" id="jumlah_tenaga_kerja" class="form-control"
            value="{{ old('jumlah_tenaga_kerja', $data->jumlah_tenaga_kerja ?? '') }}">
    </div>

    <div class="mb-3">
        <label for="jangkauan_pemasaran" class="form-label fw-bold">Jangkauan Pemasaran</label>
        <input type="text" name="jangkauan_pemasaran" id="jangkauan_pemasaran" class="form-control"
            value="{{ old('jangkauan_pemasaran', $data->jangkauan_pemasaran ?? '') }}">
    </div>

    <div class="mb-3">
        <label for="link_dokumen" class="form-label fw-bold">Link Dokumen Mutu</label>
        <input type="url" name="link_dokumen" id="link_dokumen" class="form-control"
            value="{{ old('link_dokumen', $data->link_dokumen ?? '') }}">
    </div>

   <div class="mb-3">
    <label class="form-label">Foto Produk</label>
    <input type="file" name="gambar_produk[]" class="form-control mb-2" accept="image/*" multiple onchange="previewMultipleImages(this, 'preview_produk_container')">
    <div id="preview_produk_container" class="d-flex flex-wrap gap-2 mt-2"></div>
    </div>

    <div class="mb-3">
        <label class="form-label">Foto Tempat Produksi</label>
        <input type="file" name="gambar_tempat_produksi[]" class="form-control mb-2" accept="image/*" multiple onchange="previewMultipleImages(this, 'preview_tempat_container')">
        <div id="preview_tempat_container" class="d-flex flex-wrap gap-2 mt-2"></div>
    </div>


@push('scripts')
<script>
function previewMultipleImages(input, containerId) {
    const container = document.getElementById(containerId);
    const files = input.files;

    // Reset dulu preview-nya
    container.innerHTML = '';

    for (let i = 0; i < files.length; i++) {
        const fileReader = new FileReader();

        fileReader.onload = function(e) {
            // Buat wrapper per gambar + tombol hapus
            const wrapper = document.createElement('div');
            wrapper.className = 'position-relative d-inline-block';
            wrapper.style.width = '150px';

            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'img-thumbnail';
            img.style.width = '100%';

            const btnRemove = document.createElement('button');
            btnRemove.type = 'button';
            btnRemove.innerText = '❌';
            btnRemove.className = 'btn btn-sm btn-danger position-absolute top-0 end-0';
            btnRemove.style.zIndex = '5';

            btnRemove.onclick = () => wrapper.remove();

            wrapper.appendChild(img);
            wrapper.appendChild(btnRemove);
            container.appendChild(wrapper);
        };

        fileReader.readAsDataURL(files[i]);
    }
}
</script>
@endpush



