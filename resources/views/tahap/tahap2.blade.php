<div class="row">
<input type="hidden" name="pelaku_usaha_id" value="{{ $pelaku_usaha_id }}">
    
    {{-- Omzet --}}
    <div class="mb-3 col-md-6">
        <label for="omzet" class="form-label fw-bold">Jumlah Omzet per Tahun</label>
        <input type="number" name="omzet" id="omzet" class="form-control"
            value="{{ old('omzet', $data->omzet ?? '') }}">
    </div>

    {{-- Volume Produksi per Tahun --}}
    <div class="mb-3 col-md-6">
        <label for="volume_per_tahun" class="form-label fw-bold">Volume Produksi per Tahun</label>
        <input type="number" name="volume_per_tahun" id="volume_per_tahun" class="form-control"
            value="{{ old('volume_per_tahun', $data->volume_per_tahun ?? '') }}">
    </div>

    {{-- Jumlah Tenaga Kerja --}}
    <div class="mb-3 col-md-6">
        <label for="jumlah_tenaga_kerja" class="form-label fw-bold">Jumlah Tenaga Kerja</label>
        <input type="number" name="jumlah_tenaga_kerja" id="jumlah_tenaga_kerja" class="form-control"
            value="{{ old('jumlah_tenaga_kerja', $data->jumlah_tenaga_kerja ?? '') }}">
    </div>

        {{-- Jenis Usaha --}}
     <div class="mb-3 col-md-6">
        <label for="jenis_usaha" class="form-label fw-bold">Jenis Usaha</label>
        <select name="jenis_usaha" id="jenis_usaha" class="form-control">
            <option value="">-- Pilih Jenis Usaha --</option>
            <option value="Pangan" {{ old('jenis_usaha', $data->jenis_usaha ?? '') == 'Pangan' ? 'selected' : '' }}>Pangan</option>
            <option value="Nonpangan" {{ old('jenis_usaha', $data->jenis_usaha ?? '') == 'Nonpangan' ? 'selected' : '' }}>Nonpangan</option>
        </select>
    </div> 


    <div class="mb-3 col-md-12">
    <label class="form-label fw-bold">Jangkauan Pemasaran:</label>
    @php
        $pilihan = ['Local', 'Nasional', 'Internasional'];
        $terpilih = old('jangkauan_pemasaran', $data->jangkauan_pemasaran ?? []);
        if (is_string($terpilih)) {
            $terpilih = json_decode($terpilih, true) ?? [];
        }
    @endphp

    <div class="row ms-1"> {{-- tambah margin kiri agar sejajar --}}
        @foreach($pilihan as $item)
            <div class="col-auto">
                <div class="form-check">
                    <input class="form-check-input"
                           type="checkbox"
                           name="jangkauan_pemasaran[]"
                           value="{{ $item }}"
                           {{ in_array($item, $terpilih) ? 'checked' : '' }}>
                    <label class="form-check-label">{{ $item }}</label>
                </div>
            </div>
        @endforeach
    </div>
    <small class="text-muted ms-1">Pilih lebih dari satu jika perlu</small>
</div>


    {{-- Link Dokumen Mutu --}}
    <div class="mb-3 col-md-12">
        <label for="link_dokumen" class="form-label fw-bold">Link Dokumen Mutu</label>
        <input type="url" name="link_dokumen" id="link_dokumen" class="form-control"
            value="{{ old('link_dokumen', $data->link_dokumen ?? '') }}">
    </div>

    {{-- Provinsi & Kota Kantor --}}
        <div class="container-fluid px-12"> 
    <div class="row mb-3">
        <!-- Provinsi -->
        <div class="col-md-6">
        <label for="provinsi_kantor" class="form-label fw-bold">Provinsi Kantor</label>
        <select name="provinsi_kantor" id="provinsi_kantor" class="form-control w-100">
            <option value="">-- Pilih Provinsi --</option>
            <option value="Riau">Riau</option>
            <option value="Sumatera Barat">Sumatera Barat</option>
        </select>
        </div>

        <!-- Kota -->
        <div class="col-md-6">
        <label for="kota_kantor" class="form-label fw-bold">Kota/Kabupaten Kantor</label>
        <select name="kota_kantor" id="kota_kantor" class="form-control w-100">
            <option value="">-- Pilih Kota --</option>
        </select>
        </div>
    </div>
    </div>

{{-- Alamat Kantor --}}
<div class="mb-3 col-md-12">
    <label for="alamat_kantor" class="form-label fw-bold">Alamat Kantor</label>
    <textarea name="alamat_kantor" id="alamat_kantor" class="form-control" rows="1">{{ old('alamat_kantor', $data->alamat_kantor ?? '') }}</textarea>
</div>


    {{-- Provinsi Pabrik --}}
    <!-- Provinsi & Kota Pabrik -->
    <div class="container-fluid px-12">
    <div class="row mb-3">
        {{-- Provinsi Pabrik --}}
        <div class="col-md-6">
        <label for="provinsi_pabrik" class="form-label fw-bold">Provinsi Pabrik</label>
        <select name="provinsi_pabrik" id="provinsi_pabrik" class="form-control w-100">
            <option value="">-- Pilih Provinsi --</option>
            <option value="Riau">Riau</option>
            <option value="Sumatera Barat">Sumatera Barat</option>
        </select>
        </div>

        {{-- Kota Pabrik --}}
        <div class="col-md-6">
        <label for="kota_pabrik" class="form-label fw-bold">Kota/Kabupaten Pabrik</label>
        <select name="kota_pabrik" id="kota_pabrik" class="form-control w-100">
            <option value="">-- Pilih Kota --</option>
        </select>
        </div>
    </div>
    </div>


{{-- Alamat Pabrik --}}
<div class="mb-3 col-md-12">
    <label for="alamat_pabrik" class="form-label fw-bold">Alamat Pabrik</label>
    <textarea name="alamat_pabrik" id="alamat_pabrik" class="form-control" rows="1">{{ old('alamat_pabrik', $data->alamat_pabrik ?? '') }}</textarea>
</div>


        {{-- Legalitas Usaha --}}
    <div class="mb-3 col-md-12">
        <label for="legalitas_usaha" class="form-label fw-bold">Legalitas Usaha</label>
        <input type="text" name="legalitas_usaha" id="legalitas_usaha" class="form-control"
            value="{{ old('legalitas_usaha', $data->legalitas_usaha ?? '') }}">
    </div>

    {{-- Instansi yang Pernah/Sedang Membina --}}
    <div class="mb-3 col-md-12">
        <label class="form-label fw-bold">Instansi yang Pernah/Sedang Membina</label>

        @php
            $instansi = old('instansi', $data->instansi ?? []);
        @endphp

        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="instansi_check[]" id="check_dinas" value="Dinas" {{ isset($instansi['Dinas']) ? 'checked' : '' }}>
            <label class="form-check-label" for="check_dinas">Dinas</label>
            <input type="text" name="instansi[Dinas]" id="input_dinas" class="form-control mt-1"
                placeholder="Nama Dinas"
                value="{{ $instansi['Dinas'] ?? '' }}"
                style="display: {{ isset($instansi['Dinas']) ? 'block' : 'none' }};">
        </div>

        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="instansi_check[]" id="check_kementerian" value="Kementerian" {{ isset($instansi['Kementerian']) ? 'checked' : '' }}>
            <label class="form-check-label" for="check_kementerian">Kementerian</label>
            <input type="text" name="instansi[Kementerian]" id="input_kementerian" class="form-control mt-1"
                placeholder="Nama Kementerian"
                value="{{ $instansi['Kementerian'] ?? '' }}"
                style="display: {{ isset($instansi['Kementerian']) ? 'block' : 'none' }};">
        </div>

        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="instansi_check[]" id="check_pt" value="Perguruan Tinggi" {{ isset($instansi['Perguruan Tinggi']) ? 'checked' : '' }}>
            <label class="form-check-label" for="check_pt">Perguruan Tinggi</label>
            <input type="text" name="instansi[Perguruan Tinggi]" id="input_pt" class="form-control mt-1"
                placeholder="Nama Perguruan Tinggi"
                value="{{ $instansi['Perguruan Tinggi'] ?? '' }}"
                style="display: {{ isset($instansi['Perguruan Tinggi']) ? 'block' : 'none' }};">
        </div>

        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="instansi_check[]" id="check_komunitas" value="Komunitas" {{ isset($instansi['Komunitas']) ? 'checked' : '' }}>
            <label class="form-check-label" for="check_komunitas">Komunitas</label>
            <input type="text" name="instansi[Komunitas]" id="input_komunitas" class="form-control mt-1"
                placeholder="Nama Komunitas"
                value="{{ $instansi['Komunitas'] ?? '' }}"
                style="display: {{ isset($instansi['Komunitas']) ? 'block' : 'none' }};">
        </div>
    </div>


    {{-- Sertifikat yang Dimiliki --}}
    <div class="mb-3 col-md-6">
        <label for="sertifikat" class="form-label fw-bold">Sertifikat yang Dimiliki</label>
        <input type="text" name="sertifikat" id="sertifikat" class="form-control"
            value="{{ old('sertifikat', $data->sertifikat ?? '') }}">
    </div>

{{-- SNI yang Akan Diterapkan --}}
<div class="mb-3 col-md-6">
    <label for="sni_yang_akan_diterapkan" class="form-label fw-bold">SNI yang Akan Diterapkan</label>
    <input type="text" name="sni_yang_akan_diterapkan" id="sni_yang_akan_diterapkan" class="form-control"
        value="{{ old('sni_yang_akan_diterapkan', $data->sni_yang_akan_diterapkan ?? '') }}">
</div>
{{-- Lembaga Sertifikasi Produk (LSPro) --}}
<div class="mb-3 col-md-6">
    <label for="lspro" class="form-label fw-bold">Lembaga Sertifikasi Produk (LSPro)</label>
    <input type="text" name="lspro" id="lspro" class="form-control"
        value="{{ old('lspro', $data->lspro ?? '') }}">
</div>


    {{-- Tahun Pendirian --}}
    <div class="mb-3 col-md-6">
        <label for="tahun_pendirian" class="form-label fw-bold">Tahun Pendirian</label>
        <input type="number" name="tahun_pendirian" id="tahun_pendirian" class="form-control"
            value="{{ old('tahun_pendirian', $data->tahun_pendirian ?? '') }}">
    </div>

    {{-- Foto Produk --}}
    <div class="mb-3 col-md-12">
        <label class="form-label fw-bold">Foto Produk</label>
        <input type="file" name="foto_produk[]" class="form-control" accept="image/*" multiple
            onchange="previewMultipleImages(this, 'preview_produk_container')">
        <div id="preview_produk_container" class="d-flex flex-wrap gap-2 mt-2">
            @if(!empty($data->foto_produk))
                @foreach(json_decode($data->foto_produk) as $foto)
                    <img src="{{ asset('storage/' . $foto) }}" alt="Foto Produk" class="img-thumbnail" style="width: 150px;">
                @endforeach
            @endif
        </div>
    </div>

    {{-- Foto Tempat Produksi --}}
    <div class="mb-3 col-md-12">
        <label class="form-label fw-bold">Foto Tempat Produksi</label>
        <input type="file" name="foto_tempat_produksi[]" class="form-control" accept="image/*" multiple
            onchange="previewMultipleImages(this, 'preview_tempat_container')">
        <div id="preview_tempat_container" class="d-flex flex-wrap gap-2 mt-2">
            @if(!empty($data->foto_tempat_produksi))
                @foreach(json_decode($data->foto_tempat_produksi) as $foto)
                    <img src="{{ asset('storage/' . $foto) }}" alt="Foto Tempat Produksi" class="img-thumbnail" style="width: 150px;">
                @endforeach
            @endif
        </div>
    </div>
</div>

@push('scripts')
<!-- Jquery CDN (cukup satu kali saja) -->
<script>
$(document).ready(function () {
    function getBaseUrl() {
        return "{{ url('') }}";
    }

    // === Provinsi Kantor ===
    $('#provinsi_kantor').on('change', function () {
        const provinsi = $(this).val();
        if (provinsi) {
            $.ajax({
                url: getBaseUrl() + '/get-kota/' + encodeURIComponent(provinsi),
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('#kota_kantor').empty().append('<option value="">-- Pilih Kota --</option>');
                    $.each(data, function (index, item) {
                        $('#kota_kantor').append('<option value="' + item.id + '">' + item.nama_kota + '</option>');
                    });
                },
                error: function (xhr, status, error) {
                    console.error("Gagal ambil kota kantor:", error);
                }
            });
        } else {
            $('#kota_kantor').empty().append('<option value="">-- Pilih Kota --</option>');
        }
    });

    // === Provinsi Pabrik ===
    $('#provinsi_pabrik').on('change', function () {
        const provinsi = $(this).val();
        if (provinsi) {
            $.ajax({
                url: getBaseUrl() + '/get-kota/' + encodeURIComponent(provinsi),
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('#kota_pabrik').empty().append('<option value="">-- Pilih Kota --</option>');
                    $.each(data, function (index, item) {
                        $('#kota_pabrik').append('<option value="' + item.id + '">' + item.nama_kota + '</option>');
                    });
                },
                error: function (xhr, status, error) {
                    console.error("Gagal ambil kota pabrik:", error);
                }
            });
        } else {
            $('#kota_pabrik').empty().append('<option value="">-- Pilih Kota --</option>');
        }
    });

    // === Provinsi Umum ===
    $('#provinsi').on('change', function () {
        const provinsiID = $(this).val();
        if (provinsiID) {
            $.ajax({
                url: getBaseUrl() + '/get-kota/' + encodeURIComponent(provinsiID),
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#kota').empty().append('<option value="">-- Pilih Kota --</option>');
                    $.each(data, function (index, item) {
                        $('#kota').append('<option value="' + item.id + '">' + item.nama_kota + '</option>');
                    });
                },
                error: function (xhr, status, error) {
                    console.error("Gagal mengambil data kota:", error);
                }
            });
        } else {
            $('#kota').empty().append('<option value="">-- Pilih Kota --</option>');
        }
    });
});
</script>

<script>
function previewMultipleImages(input, containerId) {
    const container = document.getElementById(containerId);
    const files = input.files;
    container.innerHTML = '';
    for (let i = 0; i < files.length; i++) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const wrapper = document.createElement('div');
            wrapper.style.position = 'relative';
            wrapper.style.display = 'inline-block';
            wrapper.style.width = '150px';
            wrapper.style.marginRight = '10px';

            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'img-thumbnail';
            img.style.width = '100%';

            const btnRemove = document.createElement('button');
            btnRemove.type = 'button';
            btnRemove.innerText = '❌';
            btnRemove.className = 'btn btn-sm btn-danger position-absolute top-0 end-0';
            btnRemove.style.zIndex = '5';
            btnRemove.style.position = 'absolute';
            btnRemove.style.top = '2px';
            btnRemove.style.right = '2px';

            btnRemove.onclick = () => wrapper.remove();

            wrapper.appendChild(img);
            wrapper.appendChild(btnRemove);
            container.appendChild(wrapper);
        };
        reader.readAsDataURL(files[i]);
    }
}
</script>

<!--KOTA KANTOR DAN PABRIK -->
<script>
  const kotaByProvinsi = {
    'Riau': [
      'Pekanbaru', 'Dumai', 'Kampar', 'Rokan Hulu', 'Rokan Hilir',
      'Siak', 'Bengkalis', 'Pelalawan', 'Indragiri Hulu', 'Indragiri Hilir'
    ],
    'Sumatera Barat': [
      'Padang', 'Bukittinggi', 'Payakumbuh', 'Padang Panjang', 'Pariaman',
      'Sawahlunto', 'Solok', 'Pasaman', 'Agam', 'Lima Puluh Kota'
    ]
  };

  document.getElementById('provinsi_kantor').addEventListener('change', function () {
    const provinsi = this.value;
    const kotaSelect = document.getElementById('kota_kantor');

    // Reset kota
    kotaSelect.innerHTML = '<option value="">-- Pilih Kota --</option>';

    // Tambahkan opsi kota jika ada
    if (kotaByProvinsi[provinsi]) {
      kotaByProvinsi[provinsi].forEach(function (kota) {
        const option = document.createElement('option');
        option.value = kota;
        option.text = kota;
        kotaSelect.appendChild(option);
      });
    }
  });
</script>
<script>
  const kotaPabrikByProvinsi = {
    'Riau': [
      'Pekanbaru', 'Dumai', 'Kampar', 'Rokan Hulu', 'Rokan Hilir',
      'Siak', 'Bengkalis', 'Pelalawan', 'Indragiri Hulu', 'Indragiri Hilir'
    ],
    'Sumatera Barat': [
      'Padang', 'Bukittinggi', 'Payakumbuh', 'Padang Panjang', 'Pariaman',
      'Sawahlunto', 'Solok', 'Pasaman', 'Agam', 'Lima Puluh Kota'
    ]
  };

  document.getElementById('provinsi_pabrik').addEventListener('change', function () {
    const provinsi = this.value;
    const kotaSelect = document.getElementById('kota_pabrik');

    // Reset isi kota_pabrik
    kotaSelect.innerHTML = '<option value="">-- Pilih Kota --</option>';

    // Jika provinsi dipilih dan ada datanya
    if (kotaPabrikByProvinsi[provinsi]) {
      kotaPabrikByProvinsi[provinsi].forEach(function (kota) {
        const option = document.createElement('option');
        option.value = kota;
        option.text = kota;
        kotaSelect.appendChild(option);
      });
    }
  });
</script>

<!--INstansi yang pernah membina-->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const instansi = ['dinas', 'kementerian', 'pt', 'komunitas'];

        instansi.forEach(function (item) {
            const checkbox = document.getElementById('check_' + item);
            const inputBox = document.getElementById('input_' + item);

            checkbox.addEventListener('change', function () {
                if (checkbox.checked) {
                    inputBox.style.display = 'block';
                } else {
                    inputBox.style.display = 'none';
                    inputBox.value = '';
                }
            });
        });
    });
</script>


@endpush
