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
    <label for="foto_produk" class="form-label">Foto Produk</label>
    <input type="file" name="foto_produk" class="form-control">
    @if ($data->foto_produk)
        <img src="{{ asset('storage/' . $data->foto_produk) }}" alt="Foto Produk" width="150">
    @else
        <img src="{{ asset('storage/uploads/foto_produk/default.jpg') }}" alt="Default Foto" width="150">
    @endif
    </div>

    <div class="mb-3">
        <label for="foto_tempat_produksi" class="form-label">Foto Tempat Produksi</label>
        <input type="file" name="foto_tempat_produksi" class="form-control">
       @if ($data->foto_tempat_produksi)
            <img src="{{ asset('storage/' . $data->foto_tempat_produksi) }}" alt="Foto Tempat Produksi" width="150">
        @else
            <img src="{{ asset('storage/uploads/foto_tempat_produksi/default.jpg') }}" alt="Default Tempat" width="150">
        @endif
    </div>


