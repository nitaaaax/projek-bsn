    @extends('layout.app')

    @section('content')
    <div class="container mt-4">
<form action="{{ route('admin.umkm.tahap.update', $tahap1->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

            @php
                // Tanda Daftar Merek
                $tanda_daftar_merk = [];
                if (!empty($tahap2->tanda_daftar_merk)) {
                    $tanda_daftar_merk = is_string($tahap2->tanda_daftar_merk)
                        ? json_decode($tahap2->tanda_daftar_merk, true)
                        : (array) $tahap2->tanda_daftar_merk;
                }

                // Status Pembinaan
                $status_pembinaan = [];
                if (!empty($tahap2->status_pembinaan)) {
                    $status_pembinaan = is_string($tahap2->status_pembinaan)
                        ? json_decode($tahap2->status_pembinaan, true)
                        : (array) $tahap2->status_pembinaan;
                }

                // Jangkauan Pemasaran
                $jangkauan_pemasaran = [];
                if (!empty($tahap2->jangkauan_pemasaran)) {
                    $jangkauan_pemasaran = is_string($tahap2->jangkauan_pemasaran)
                        ? json_decode($tahap2->jangkauan_pemasaran, true)
                        : (array) $tahap2->jangkauan_pemasaran;
                }

                 // Instansi
$instansiArray = $tahap2->instansi ?? [];
            @endphp


            {{-- CARD 1: Data Tahap 1 --}}
            <div class="card shadow-sm mb-4 border-0 rounded-3">
                <div class="card-header bg-light text-dark border-bottom fw-bold">
                    <i class="fas fa-user me-2 text-secondary"></i> Informasi Pelaku UMKM
                </div>

                <div class="card-body row g-3">
                    @foreach ([
                        'nama_pelaku' => 'Nama Pelaku',
                        'produk' => 'Produk',
                        'klasifikasi' => 'Klasifikasi',
                        'pembina_1' => 'Pembina 1',
                        'pembina_2' => 'Pembina 2',
                        'sinergi' => 'Sinergi',
                        'nama_kontak_person' => 'Kontak Person',
                        'no_hp' => 'No HP',
                        'tahun_dibina' => 'Tahun Dibina',
                        'email' => 'Email',
                        'media_sosial' => 'Media Sosial',
                        'nama_merek' => 'Nama Merek',
                        'lspro' => 'LSPRO',

                    ] as $field => $label)
                        <div class="col-md-6">
                            <label class="form-label">{{ $label }}</label>
                            <input type="text" name="{{ $field }}" class="form-control"
                                value="{{ old($field, $tahap1->$field ?? '') }}">
                        </div>
                    @endforeach

                    {{-- Status --}}
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="">-- Pilih Status --</option>
                            <option value="drop/tidak dilanjutkan" {{ old('status', $tahap1->status ?? '') == 'drop/tidak dilanjutkan' ? 'selected' : '' }}>Drop / Tidak Dilanjutkan</option>
                            <option value="masih dibina" {{ old('status', $tahap1->status ?? '') == 'masih dibina' ? 'selected' : '' }}>Masih di Bina</option>
                        </select>
                    </div>

                    {{-- Bulan Pertama Pembinaan --}}
                    <div class="col-md-6">
                        <label class="form-label">Bulan Pembinaan Pertama</label>
                        <select name="bulan_pertama_pembinaan" class="form-control">
                            @foreach ([
                                'Januari', 'Februari', 'Maret', 'April',
                                'Mei', 'Juni', 'Juli', 'Agustus',
                                'September', 'Oktober', 'November', 'Desember'
                            ] as $bulan)
                                <option value="{{ $bulan }}"
                                    {{ old('bulan_pertama_pembinaan', $tahap1->bulan_pertama_pembinaan ?? '') == $bulan ? 'selected' : '' }}>
                                    {{ $bulan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status Pembinaan --}}
                    <div class="col-md-6">
                        <label class="form-label">Status Pembinaan</label>
                        <select name="status_pembinaan" class="form-control">
                            <option value="">-- Pilih Status Pembinaan --</option>
                            <option value="Identifikasi awal dan Gap" {{ old('status_pembinaan', $tahap1->status_pembinaan ?? '') == 'Identifikasi awal dan Gap' ? 'selected' : '' }}>1. Identifikasi awal dan Gap</option>
                            <option value="Set up Sistem" {{ old('status_pembinaan', $tahap1->status_pembinaan ?? '') == 'Set up Sistem' ? 'selected' : '' }}>2. Set up Sistem</option>
                            <option value="Implementasi" {{ old('status_pembinaan', $tahap1->status_pembinaan ?? '') == 'Implementasi' ? 'selected' : '' }}>3. Implementasi</option>
                            <option value="Review Sistem & Audit Internal" {{ old('status_pembinaan', $tahap1->status_pembinaan ?? '') == 'Review Sistem & Audit Internal' ? 'selected' : '' }}>4. Review Sistem & Audit Internal</option>
                            <option value="Pengajuan Sertifikasi" {{ old('status_pembinaan', $tahap1->status_pembinaan ?? '') == 'Pengajuan Sertifikasi' ? 'selected' : '' }}>5. Pengajuan Sertifikasi</option>
                            <option value="Perbaikan Temuan Audit" {{ old('status_pembinaan', $tahap1->status_pembinaan ?? '') == 'Perbaikan Temuan Audit' ? 'selected' : '' }}>6. Perbaikan Temuan Audit</option>
                            <option value="Perbaikan Lokasi" {{ old('status_pembinaan', $tahap1->status_pembinaan ?? '') == 'Perbaikan Lokasi' ? 'selected' : '' }}>7. Perbaikan Lokasi</option>
                            <option value="Monitoring Pasca Sertifikasi" {{ old('status_pembinaan', $tahap1->status_pembinaan ?? '') == 'Monitoring Pasca Sertifikasi' ? 'selected' : '' }}>8. Monitoring Pasca Sertifikasi</option>
                            <option value="SPPT SNI" {{ old('status_pembinaan', $tahap1->status_pembinaan ?? '') == 'SPPT SNI' ? 'selected' : '' }} style="color: green; font-weight: bold;">9. SPPT SNI</option>
                        </select>
                    </div>


                    {{-- Jenis Usaha --}}
                    <div class="col-md-6">
                        <label class="form-label">Jenis Usaha</label>
                        <select name="jenis_usaha" class="form-control">
                            <option value="">-- Pilih Jenis Usaha --</option>
                            <option value="Pangan" {{ old('jenis_usaha', $tahap1->jenis_usaha ?? '') == 'Pangan' ? 'selected' : '' }}>Pangan</option>
                            <option value="Nonpangan" {{ old('jenis_usaha', $tahap1->jenis_usaha ?? '') == 'Nonpangan' ? 'selected' : '' }}>Nonpangan</option>
                        </select>
                    </div>

                    {{-- Tanda Daftar Merek --}}
                    <div class="col-md-6">
                        <label class="form-label">Tanda Daftar Merek</label>
                        <select name="tanda_daftar_merk" class="form-control">
                            <option value="">-- Pilih Tanda Daftar Merek --</option>
                            <option value="Terdaftar di Kemenkumham"
                                {{ old('tanda_daftar_merk', $tahap1->tanda_daftar_merk ?? '') == 'Terdaftar di Kemenkumham' ? 'selected' : '' }}>
                                Terdaftar di Kemenkumham
                            </option>
                            <option value="Belum Terdaftar"
                                {{ old('tanda_daftar_merk', $tahap1->tanda_daftar_merk ?? '') == 'Belum Terdaftar' ? 'selected' : '' }}>
                                Belum Terdaftar
                            </option>
                        </select>
                    </div>

                    {{-- Riwayat Pembinaan --}}
                    <div class="col-md-12">
                        <label class="form-label">Riwayat Pembinaan</label>
                        <textarea name="riwayat_pembinaan" class="form-control" rows="4">
                            {{ old('riwayat_pembinaan', is_array($tahap1->riwayat_pembinaan ?? null) ? implode(', ', $tahap1->riwayat_pembinaan) : ($tahap1->riwayat_pembinaan ?? '') ) }}
                        </textarea>

                    </div>

                </div>
            </div>
            
                @php
                $tahap2 = $tahap2 ?? (object)[];
                $foto_produk = $foto_produk ?? [];
                $foto_tempat_produksi = $foto_tempat_produksi ?? [];
                @endphp

            {{-- CARD 2: Data Tahap 2 --}}
            <div class="card shadow-sm mb-4 border-0 rounded-3">
                <div class="card-header bg-light text-dark border-bottom fw-bold">
                    <i class="fas fa-industry me-2 text-secondary"></i> Detail Usaha & Produksi
                </div>
                <div class="card-body row g-3">

                    {{-- Omzet --}}
                    <div class="col-md-6">
                        <label class="form-label">Omzet</label>
                        <input type="text" name="omzet" class="form-control"
                            value="{{ old('omzet', $tahap2->omzet ?? '') }}">
                    </div>

                    {{-- Volume & Tenaga Kerja --}}
                    <div class="col-md-6">
                        <label class="form-label">Volume per Tahun</label>
                        <input type="text" name="volume_per_tahun" class="form-control"
                            value="{{ old('volume_per_tahun', $tahap2->volume_per_tahun ?? '') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jumlah Tenaga Kerja</label>
                        <input type="text" name="jumlah_tenaga_kerja" class="form-control"
                            value="{{ old('jumlah_tenaga_kerja', $tahap2->jumlah_tenaga_kerja ?? '') }}">
                    </div>

                    {{-- Link Dokumen --}}
                    <div class="col-12">
                        <label class="form-label">Link Dokumen</label>
                        <textarea name="link_dokumen" class="form-control" rows="2">{{ old('link_dokumen', $tahap2->link_dokumen ?? '') }}</textarea>
                    </div>

                    {{-- Alamat Kantor & Pabrik --}}
                    <div class="col-12">
                        <label class="form-label">Alamat Kantor</label>
                        <textarea name="alamat_kantor" class="form-control" rows="2">{{ old('alamat_kantor', $tahap2->alamat_kantor ?? '') }}</textarea>
                    </div>
                    {{-- Provinsi & Kota Kantor --}}
                    <div class="mb-3 col-md-6">
                        <label class="form-label fw-bold">Provinsi Kantor</label>
                        <select name="provinsi_kantor" id="provinsi_kantor" class="form-control">
                            <option value="">-- Pilih Provinsi --</option>
                        </select>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label fw-bold">Kota Kantor</label>
                        <select name="kota_kantor" id="kota_kantor" class="form-control">
                            <option value="">-- Pilih Kota --</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Alamat Pabrik</label>
                        <textarea name="alamat_pabrik" class="form-control" rows="2">{{ old('alamat_pabrik', $tahap2->alamat_pabrik ?? '') }}</textarea>
                    </div>

                    {{-- Provinsi & Kota Pabrik --}}
                    <div class="mb-3 col-md-6">
                        <label class="form-label fw-bold">Provinsi Pabrik</label>
                        <select name="provinsi_pabrik" id="provinsi_pabrik" class="form-control">
                            <option value="">-- Pilih Provinsi --</option>
                        </select>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label fw-bold">Kota Pabrik</label>
                        <select name="kota_pabrik" id="kota_pabrik" class="form-control">
                            <option value="">-- Pilih Kota --</option>
                        </select>
                    </div>

                    {{-- Tahun Pendirian --}}
                    <div class="col-md-6">
                        <label class="form-label">Tahun Pendirian</label>
                        <input type="number" name="tahun_pendirian" class="form-control"
                            value="{{ old('tahun_pendirian', $tahap2->tahun_pendirian ?? '') }}">
                    </div>

                    {{-- Legalitas & Sertifikat --}}
                    <div class="col-md-6">
                        <label class="form-label">Legalitas Usaha</label>
                        <input type="text" name="legalitas_usaha" class="form-control"
                            value="{{ old('legalitas_usaha', $tahap2->legalitas_usaha ?? '') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">SNI yang Akan Diterapkan</label>
                        <input type="text" name="sni_yang_diterapkan" class="form-control"
                            value="{{ old('sni_yang_diterapkan', $tahap2->sni_yang_diterapkan ?? '') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Sertifikat yang Dimiliki</label>
                        <input type="text" name="sertifikat" class="form-control"
                            value="{{ old('sertifikat', $tahap2->sertifikat ?? '') }}">
                    </div>

                        {{-- Jangkauan Pemasaran --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Jangkauan Pemasaran</label>
                            @foreach (["Local", "Nasional", "Internasional"] as $option)
                                <div class="form-check">
                                    <input type="checkbox" name="jangkauan_pemasaran[]" class="form-check-input"
                                        value="{{ $option }}" id="jangkauan_{{ $option }}"
                                        {{ in_array($option, $jangkauan_pemasaran ?? []) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="jangkauan_{{ $option }}">{{ $option }}</label>
                                </div>
                            @endforeach
                        </div>


                        {{-- Instansi --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Instansi yang Pernah/Sedang Membina</label>
                            @foreach (['Dinas', 'Kementerian', 'Perguruan Tinggi', 'Komunitas'] as $item)
                                @php
                                    $isChecked = !empty($instansiArray[$item]);
                                    $rawValue = old("instansi_detail.$item", $instansiArray[$item] ?? '');
                                    $inputValue = is_array($rawValue) ? implode(', ', $rawValue) : $rawValue;
                                @endphp
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="check_{{ $item }}" name="instansi_check[]" value="{{ $item }}"
                                        {{ $isChecked ? 'checked' : '' }} onchange="toggleInput('{{ $item }}')">
                                    <label class="form-check-label" for="check_{{ $item }}">{{ $item }}</label>
                                    <input type="text" class="form-control mt-1"
                                        name="instansi_detail[{{ $item }}]"
                                        id="input_{{ $item }}"
                                        placeholder="Isi nama {{ strtolower($item) }}"
                                        value="{{ $inputValue }}"
                                        {{ $isChecked ? '' : 'style=display:none;' }}>
                                </div>
                            @endforeach
                        </div>
                    </div>
                     <div id="old-preview-tempat" class="mt-2 d-flex flex-wrap">
                            @if (is_array($foto_tempat_produksi) && count($foto_tempat_produksi) > 0)
                                @foreach ($foto_tempat_produksi as $foto)
                                    <div class="position-relative me-2 mb-2 old-foto-tempat">
                                    <img src="{{ asset('storage/uploads/foto_tempat_produksi/' . $foto) }}"
                                        class="me-2 mb-2"
                                        style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px;">
                                        <input type="hidden" name="old_foto_tempat_produksi[]" value="{{ $foto }}">
                                        <button type="button" class="btn btn-sm btn-danger p-1 btn-remove-old" style="position: absolute; top: 0; right: 0;">&times;</button>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted">Belum ada foto tempat produksi.</p>
                            @endif
                        </div>
                        <div id="preview-tempat" class="mt-2 d-flex flex-wrap"></div>
                    </div>
                    </div>

                    {{-- Tombol Submit dan Kembali --}}
                    @php
    $foto_produk = is_array($tahap2->foto_produk ?? null) ? $tahap2->foto_produk : json_decode($tahap2->foto_produk ?? '[]', true);
    $foto_tempat_produksi = is_array($tahap2->foto_tempat_produksi ?? null) ? $tahap2->foto_tempat_produksi : json_decode($tahap2->foto_tempat_produksi ?? '[]', true);
@endphp

{{-- Foto Produk --}}
<div class="col-md-6 mb-3">
    <label class="form-label">Foto Produk (bisa lebih dari satu)</label>
    <input type="file" name="foto_produk[]" class="form-control" multiple onchange="previewImages(this, 'preview-produk')">

    <div id="old-preview-produk" class="mt-2 d-flex flex-wrap">
        @if (is_array($foto_produk) && count($foto_produk) > 0)
            @foreach ($foto_produk as $foto)
                <div class="position-relative me-2 mb-2 old-foto-produk">
                    <img src="{{ asset('storage/' . $foto) }}"
                         style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px;"
                         class="img-thumbnail">

                    <input type="hidden" name="old_foto_produk[]" value="{{ $foto }}">

                    <button type="button"
                            class="btn btn-sm btn-danger p-1 btn-remove-old"
                            style="position: absolute; top: 0; right: 0;">
                        &times;
                    </button>
                </div>
            @endforeach
        @else
            <p class="text-muted">Belum ada foto produk.</p>
        @endif
    </div>
    <div id="preview-produk" class="mt-2 d-flex flex-wrap"></div>
</div>

{{-- Foto Tempat Produksi --}}
<div class="col-md-6 mb-3">
    <label class="form-label">Foto Tempat Produksi (bisa lebih dari satu)</label>
    <input type="file" name="foto_tempat_produksi[]" class="form-control" multiple onchange="previewImages(this, 'preview-tempat')">

    <div id="old-preview-tempat" class="mt-2 d-flex flex-wrap">
        @if (is_array($foto_tempat_produksi) && count($foto_tempat_produksi) > 0)
            @foreach ($foto_tempat_produksi as $foto)
                <div class="position-relative me-2 mb-2 old-foto-tempat">
                    <img src="{{ asset('storage/' . $foto) }}"
                         class="me-2 mb-2"
                         style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px;">
                    <input type="hidden" name="old_foto_tempat_produksi[]" value="{{ $foto }}">
                    <button type="button" class="btn btn-sm btn-danger p-1 btn-remove-old" style="position: absolute; top: 0; right: 0;">&times;</button>
                </div>
            @endforeach
        @else
            <p class="text-muted">Belum ada foto tempat produksi.</p>
        @endif
    </div>
    <div id="preview-tempat" class="mt-2 d-flex flex-wrap"></div>
</div>

                        {{-- Preview Foto Lama --}}
                      col-12 d-flex justify-content-end gap-3 mb-4">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm rounded-pill px-3" title="Kembali">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4" title="Simpan Perubahan">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @endsection

    @push('scripts')
     <!-- Jquery CDN (cukup satu kali saja) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
    // Ambil semua provinsi saat halaman siap
    $.get("{{ url('admin/umkm-proses/get-provinsi') }}", function (data) {
        console.log('Data provinsi:', data); // Debugging
        $.each(data, function (index, provinsi) {
            $('#provinsi_kantor, #provinsi_pabrik').append(`<option value="${provinsi.id}">${provinsi.nama}</option>`);
        });
    }).fail(function(xhr, status, error) {
        console.error('Gagal ambil provinsi:', xhr.responseText);
    });

    // Event saat provinsi kantor berubah
    $('#provinsi_kantor').on('change', function () {
        const id = $(this).val();
        $('#kota_kantor').empty().append('<option value="">-- Pilih Kota --</option>');
        if (id) {
            $.get(`{{ url('admin/umkm-proses/get-kota') }}/${id}`, function (data) {
                $.each(data, function (index, kota) {
                    $('#kota_kantor').append(`<option value="${kota.id}">${kota.nama}</option>`);
                });
            }).fail(function(xhr, status, error) {
                console.error('Gagal ambil kota kantor:', xhr.responseText);
            });
        }
    });

    // Event saat provinsi pabrik berubah
    $('#provinsi_pabrik').on('change', function () {
        const id = $(this).val();
        $('#kota_pabrik').empty().append('<option value="">-- Pilih Kota --</option>');
        if (id) {
            $.get(`{{ url('admin/umkm-proses/get-kota') }}/${id}`, function (data) {
                $.each(data, function (index, kota) {
                    $('#kota_pabrik').append(`<option value="${kota.id}">${kota.nama}</option>`);
                });
            }).fail(function(xhr, status, error) {
                console.error('Gagal ambil kota pabrik:', xhr.responseText);
            });
        }
    });
});
</script>
    <script>
    function previewImages(input, containerId) {
        const container = document.getElementById(containerId);
        container.innerHTML = "";

        const files = Array.from(input.files);
        const dt = new DataTransfer();

        files.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function (e) {
                const wrapper = document.createElement("div");
                wrapper.className = "position-relative me-2 mb-2";

                const img = document.createElement("img");
                img.src = e.target.result;
                img.style.width = "100px";
                img.className = "rounded";

                const btn = document.createElement("button");
                btn.className = "btn btn-sm btn-danger p-1";
                btn.style.position = "absolute";
                btn.style.top = "0";
                btn.style.right = "0";
                btn.innerHTML = "&times;";

                btn.addEventListener("click", function () {
                    files.splice(index, 1);
                    const newDt = new DataTransfer();
                    files.forEach(f => newDt.items.add(f));
                    input.files = newDt.files;
                    previewImages(input, containerId);
                });

                wrapper.appendChild(img);
                wrapper.appendChild(btn);
                container.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        });
    }
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Hapus gambar lama dari DOM dan form
        document.querySelectorAll('.btn-remove-old').forEach(button => {
            button.addEventListener('click', function () {
                const wrapper = this.closest('.old-foto-produk') || this.closest('.old-foto-tempat');
                wrapper.remove();
            });
        });

        // Toggle input instansi
        const checkboxes = document.querySelectorAll('.form-check-input[type="checkbox"][name="instansi_check[]"]');

        checkboxes.forEach(cb => {
            cb.addEventListener('change', function () {
                const inputId = 'input_' + this.value;
                const textInput = document.getElementById(inputId);
                if (this.checked) {
                    textInput.style.display = 'block';
                } else {
                    textInput.style.display = 'none';
                    textInput.value = '';
                }
            });
        });
    });
    </script>
    @endpush
