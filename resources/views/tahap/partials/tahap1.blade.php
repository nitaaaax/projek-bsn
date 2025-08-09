      <div class="row">

        {{-- Nama Pelaku --}}
        <div class="mb-3 col-md-6">
            <label for="nama_pelaku" class="form-label fw-bold">Nama Pelaku</label>
            <input type="text" name="nama_pelaku" id="nama_pelaku" class="form-control" 
                value="{{ old('nama_pelaku', $data->nama_pelaku ?? '') }}" required>
        </div>

        {{-- Produk --}}
        <div class="mb-3 col-md-6">
            <label for="produk" class="form-label fw-bold">Produk</label>
            <input type="text" name="produk" id="produk" class="form-control" 
                value="{{ old('produk', $data->produk ?? '') }}" required>
        </div>

        {{-- Klasifikasi --}}
        <div class="mb-3 col-md-6">
            <label for="klasifikasi" class="form-label fw-bold">Klasifikasi</label>
            <input type="text" name="klasifikasi" id="klasifikasi" class="form-control" 
                value="{{ old('klasifikasi', $data->klasifikasi ?? '') }}">
        </div>

        {{-- Status --}}
        <div class="mb-3 col-md-6">
            <label for="status" class="form-label fw-bold">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="">-- Pilih Status --</option>
                <option value="drop/tidak dilanjutkan" {{ old('status', $data->status ?? '') == 'drop/tidak dilanjutkan' ? 'selected' : '' }}>
                    Drop / Tidak Dilanjutkan
                </option>
                <option value="masih dibina" {{ old('status', $data->status ?? '') == 'masih dibina' ? 'selected' : '' }}>
                    Masih di Bina
                </option>
            </select>
        </div>
        
        {{-- Pembina 1 --}}
        <div class="mb-3 col-md-6">
            <label for="pembina_1" class="form-label fw-bold">Pembina I</label>
            <input type="text" name="pembina_1" id="pembina_1" class="form-control" 
                value="{{ old('pembina_1', $data->pembina_1 ?? '') }}">
        </div>

        {{-- Pembina 2 --}}
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
            <label for="no_hp" class="form-label fw-bold">No HP/Telp</label>
            <input type="text" name="no_hp" id="no_hp" class="form-control" 
                value="{{ old('no_hp', $data->no_hp ?? '') }}">
        </div>

        {{-- Bulan Pertama Pembinaan --}}
        <div class="mb-3 col-md-6">
            <label for="bulan_pertama_pembinaan" class="form-label fw-bold">Bulan Pertama Pembinaan</label>
            <select name="bulan_pertama_pembinaan" id="bulan_pertama_pembinaan" class="form-control">
                <option value="">-- Pilih Bulan --</option>
                @foreach([
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                ] as $num => $nama)
                    <option value="{{ $nama }}" {{ old('bulan_pertama_pembinaan', $data->bulan_pertama_pembinaan ?? '') == $nama ? 'selected' : '' }}>
                        {{ $nama }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Tahun Dibina --}}
        <div class="mb-3 col-md-6">
            <label for="tahun_dibina" class="form-label fw-bold">Tahun Dibina</label>
            <input type="number" name="tahun_dibina" id="tahun_dibina" class="form-control" 
                value="{{ old('tahun_dibina', $data->tahun_dibina ?? '') }}">
        </div>

        {{-- Status Pembinaan --}}
        <div class="mb-3 col-md-6">
            <label for="status_pembinaan" class="form-label fw-bold">Status Pembinaan</label>
            <select name="status_pembinaan" id="status_pembinaan" class="form-control">
                <option value="">-- Pilih Status --</option>
                <option value="Identifikasi awal dan Gap" {{ old('status_pembinaan', $data->status_pembinaan ?? '') == 'Identifikasi awal dan Gap' ? 'selected' : '' }}> Identifikasi awal dan Gap</option>
                <option value="Set up Sistem" {{ old('status_pembinaan', $data->status_pembinaan ?? '') == 'Set up Sistem' ? 'selected' : '' }}> Set up Sistem</option>
                <option value="Implementasi" {{ old('status_pembinaan', $data->status_pembinaan ?? '') == 'Implementasi' ? 'selected' : '' }}> Implementasi</option>
                <option value="Review Sistem & Audit Internal" {{ old('status_pembinaan', $data->status_pembinaan ?? '') == 'Review Sistem & Audit Internal' ? 'selected' : '' }}> Review Sistem & Audit Internal</option>
                <option value="Pengajuan Sertifikasi" {{ old('status_pembinaan', $data->status_pembinaan ?? '') == 'Pengajuan Sertifikasi' ? 'selected' : '' }}> Pengajuan Sertifikasi</option>
                <option value="Perbaikan Temuan Audit" {{ old('status_pembinaan', $data->status_pembinaan ?? '') == 'Perbaikan Temuan Audit' ? 'selected' : '' }}> Perbaikan Temuan Audit</option>
                <option value="Perbaikan Lokasi" {{ old('status_pembinaan', $data->status_pembinaan ?? '') == 'Perbaikan Lokasi' ? 'selected' : '' }}> Perbaikan Lokasi</option>
                <option value="SPPT SNI (TERSERTIFIKASI)" style="font-weight:bold; color:green;" {{ old('status_pembinaan', $data->status_pembinaan ?? '') == 'SPPT SNI' ? 'selected' : '' }}>SPPT SNI (Tersertifikasi)</option>
            </select>
        </div>

        {{-- Email --}}
        <div class="mb-3 col-md-6">
            <label for="email" class="form-label fw-bold">Email</label>
            <input type="email" name="email" id="email" class="form-control" 
                value="{{ old('email', $data->email ?? '') }}">
        </div>

        {{-- Media Sosial --}}
        <div class="mb-3 col-md-12">
            <label class="form-label fw-bold">Media Sosial</label>
            <input type="url" name="media_sosial" class="form-control" value="{{ old('media_sosial', $data->media_sosial ?? '') }}">
        </div>

        {{-- Lembaga Sertifikasi Produk (LSPro) --}}
        <div class="mb-3 col-md-6">
            <label for="lspro" class="form-label fw-bold">Lembaga Sertifikasi Produk (LSPro)</label>
            <input type="text" name="lspro" id="lspro" class="form-control"
                value="{{ old('lspro', $data->lspro ?? '') }}">
        </div>

        {{-- Nama Merek --}}
        <div class="mb-3 col-md-6">
            <label for="nama_merek" class="form-label fw-bold">Nama Merek</label>
            <input type="text" name="nama_merek" id="nama_merek" class="form-control" 
                value="{{ old('nama_merek', $data->nama_merek ?? '') }}">
        </div>

        {{-- Tanda Daftar Merek --}}
        <div class="col-md-6">
            <label class="form-label fw-bold d-block mb-1">Tanda Daftar Merek</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="tanda_daftar_merk" id="terdaftar"
                    value="Terdaftar di Kemenkumham"
                    {{ old('tanda_daftar_merk', $data->tanda_daftar_merk ?? '') == 'Terdaftar di Kemenkumham' ? 'checked' : '' }}>
                <label class="form-check-label" for="terdaftar">Terdaftar di Kemenkumham</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="tanda_daftar_merk" id="belum_terdaftar"
                    value="Belum Terdaftar"
                    {{ old('tanda_daftar_merk', $data->tanda_daftar_merk ?? '') == 'Belum Terdaftar' ? 'checked' : '' }}>
                <label class="form-check-label" for="belum_terdaftar">Belum Terdaftar</label>
            </div>
        </div>

        {{-- Jenis Usaha --}}
        <div class="col-md-6">
            <label class="form-label fw-bold d-block mb-1">Jenis Usaha</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="jenis_usaha" id="pangan" value="Pangan"
                    {{ old('jenis_usaha', $data->jenis_usaha ?? '') == 'Pangan' ? 'checked' : '' }}>
                <label class="form-check-label" for="pangan">Pangan</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="jenis_usaha" id="nonpangan" value="Nonpangan"
                    {{ old('jenis_usaha', $data->jenis_usaha ?? '') == 'Nonpangan' ? 'checked' : '' }}>
                <label class="form-check-label" for="nonpangan">Nonpangan</label>
            </div>
        </div>
        
           {{-- Riwayat Pembinaan --}}
        <div class="mb-3 col-md-12">
        <label class="form-label fw-bold">Riwayat Pembinaan</label>
        <textarea id="editor_riwayat" name="riwayat_pembinaan" class="form-control">
            {{ old('riwayat_pembinaan', $data->riwayat_pembinaan ?? '') }}
        </textarea>
        </div>
        </div>

 
   @push('scripts')
  {{-- CKEditor 5 CDN --}}
  <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

  <script>
    ClassicEditor
      .create(document.querySelector('#editor_riwayat'))
      .catch(error => {
        console.error(error);
      });
  </script>
@endpush
