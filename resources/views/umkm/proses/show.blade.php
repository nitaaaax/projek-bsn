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
                $instansi = [];
                if (!empty($tahap2->instansi)) {
                    $instansi = is_string($tahap2->instansi)
                        ? json_decode($tahap2->instansi, true)
                        : (array) $tahap2->instansi;
                }
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
                        <select name="status_pembinaan" class="form-control"
                            {{ ($tahap1->status ?? '') == 'Tersertifikasi' ? 'disabled' : '' }}>
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

                        {{-- supaya tetap terkirim walau select disabled --}}
                        @if(($tahap1->status ?? '') == 'Tersertifikasi')
                            <input type="hidden" name="status_pembinaan" value="{{ $tahap1->status_pembinaan }}">
                        @endif
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
                        <textarea id="editor" name="riwayat_pembinaan" class="form-control">
                            {!! old('riwayat_pembinaan', $tahap1->riwayat_pembinaan ?? '') !!}
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

                    <div class="col-md-6">
                        <label class="form-label">Gruping</label>
                        <input type="text" name="gruping" class="form-control"
                            value="{{ old('gruping', $tahap2->gruping ?? '') }}">
                    </div>

                    {{-- Link Dokumen --}}
                    <div class="col-12">
                        <label class="form-label">Link Dokumen</label>
                        <textarea name="link_dokumen" class="form-control" rows="2">{{ old('link_dokumen', $tahap2->link_dokumen ?? '') }}</textarea>
                    </div>

                    {{-- Alamat Kantor --}}
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">Alamat Kantor</label>
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

                    {{-- Alamat Pabrik --}}
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">Alamat Pabrik</label>
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

                    <div class="col-md-6">
                        <label class="form-label">SNI yang Akan Diterapkan</label>
                        <input type="text" name="sni_yang_diterapkan" class="form-control"
                            value="{{ old('sni_yang_diterapkan', $tahap2->sni_yang_diterapkan ?? '') }}">
                    </div>

                    {{-- legalitas usaha--}}
                    @php
                        $legalitasOptions = [
                            'NIB', 'SIUP', 'NPWP Pemilik', 'Akta Pendirian Usaha',
                            'IUMK', 'TDP', 'NPWP Badan usaha'
                        ];

                        $legalitasData = $tahap2->legalitas_usaha ?? '[]';
                        $selectedLegalitas = is_array($legalitasData) 
                            ? $legalitasData 
                            : (str_starts_with($legalitasData, '[') 
                                ? json_decode($legalitasData, true) 
                                : explode(',', $legalitasData));

                        $customLegalitas = '';
                        foreach ($selectedLegalitas as $item) {
                            if (!in_array($item, $legalitasOptions) && !empty(trim($item))) {
                                $customLegalitas = $item;
                                break;
                            }
                        }
                    @endphp

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Legalitas Usaha</label>
                        <div class="row">
                            @foreach(array_chunk($legalitasOptions, 4) as $chunk)
                                <div class="col-md-6">
                                    @foreach($chunk as $option)
                                        <div class="form-check">
                                            <input class="form-check-input" 
                                                type="checkbox" 
                                                name="legalitas_usaha[]" 
                                                value="{{ $option }}"
                                                {{ in_array($option, $selectedLegalitas) ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ $option }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>

                        <div class="form-check mt-3">
                            <input class="form-check-input" 
                                type="checkbox" 
                                name="legalitas_usaha[]" 
                                value="lainnya"
                                id="legalitas_lainnya_toggle"
                                {{ !empty($customLegalitas) ? 'checked' : '' }}>
                            <label class="form-check-label">Lainnya</label>
                        </div>
                        
                        <div id="legalitas_lainnya_container" style="{{ !empty($customLegalitas) ? '' : 'display:none' }}" class="mt-2">
                            <input type="text" 
                                name="legalitas_usaha_lainnya" 
                                class="form-control" 
                                value="{{ trim($customLegalitas) }}"
                                placeholder="Masukkan legalitas lainnya">
                        </div>
                    </div>

                    {{-- Sertifikat yang Dimiliki --}}
                    @php
                        $sertifikatOptions = ['PIRT', 'MD', 'Halal'];
                        $sertifikatData = $tahap2->sertifikat ?? '[]';
                        $selectedSertifikat = is_array($sertifikatData) 
                            ? $sertifikatData 
                            : (str_starts_with($sertifikatData, '[') 
                                ? json_decode($sertifikatData, true) 
                                : explode(',', $sertifikatData));

                        $customSertifikat = '';
                        foreach($selectedSertifikat as $item) {
                            if(!in_array($item, $sertifikatOptions) && !empty(trim($item))) {
                                $customSertifikat = $item;
                                break;
                            }
                        }
                    @endphp

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Sertifikat yang Dimiliki</label>
                        <div class="row">
                            @foreach(array_chunk($sertifikatOptions, 3) as $chunk)
                                <div class="col-md-6">
                                    @foreach($chunk as $option)
                                        <div class="form-check">
                                            <input class="form-check-input" 
                                                type="checkbox" 
                                                name="sertifikat[]" 
                                                value="{{ $option }}"
                                                {{ in_array($option, $selectedSertifikat) ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ $option }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>

                        <div class="form-check mt-3">
                            <input class="form-check-input" 
                                type="checkbox" 
                                name="sertifikat[]" 
                                value="lainnya"
                                id="sertifikat_lainnya_toggle"
                                {{ !empty($customSertifikat) ? 'checked' : '' }}>
                            <label class="form-check-label">Lainnya</label>
                        </div>
                        
                        <div id="sertifikat_lainnya_container" style="{{ !empty($customSertifikat) ? '' : 'display:none' }}" class="mt-2">
                            <input type="text" 
                                name="sertifikat_lainnya" 
                                class="form-control" 
                                value="{{ $customSertifikat }}"
                                placeholder="Masukkan sertifikat lainnya">
                        </div>
                    </div>

                    {{-- Instansi Pembina --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Instansi Pembina</label>
                        @php
                            $instansiData = is_array($tahap2->instansi)
                                ? $tahap2->instansi
                                : (json_decode($tahap2->instansi, true) ?? []);

                            $standardInstansi = ['Dinas', 'Kementerian', 'Perguruan Tinggi', 'Komunitas'];
                            $customInstansi = array_diff_key($instansiData, array_flip($standardInstansi));
                            $instansiLainnya = !empty($customInstansi) ? implode(', ', $customInstansi) : '';
                        @endphp

                        @foreach($standardInstansi as $option)
                            <div class="form-check mb-2">
                                <input class="form-check-input"
                                    type="checkbox"
                                    name="instansi_check[]"
                                    value="{{ $option }}"
                                    id="instansi_{{ $option }}"
                                    {{ array_key_exists($option, $instansiData) ? 'checked' : '' }}>
                                <label class="form-check-label" for="instansi_{{ $option }}">{{ $option }}</label>
                                <input type="text"
                                    class="form-control mt-1"
                                    name="instansi_detail[{{ $option }}]"
                                    value="{{ $instansiData[$option] ?? '' }}"
                                    placeholder="Detail {{ $option }}">
                            </div>
                        @endforeach

                        <div class="form-check mb-2">
                            <input class="form-check-input"
                                type="checkbox"
                                name="instansi_check[]"
                                value="Lainnya"
                                id="instansi_lainnya"
                                {{ !empty($instansiLainnya) ? 'checked' : '' }}>
                            <label class="form-check-label" for="instansi_lainnya">Lainnya</label>
                            <input type="text"
                                class="form-control mt-1"
                                name="instansi_detail[Lainnya]"
                                value="{{ $instansiLainnya }}"
                                placeholder="Instansi lainnya (pisahkan dengan koma)">
                        </div>
                    </div>

                    {{-- Jangkauan Pemasaran --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Jangkauan Pemasaran</label>
                        @php
                            $jangkauanData = [];
                            if (!empty($tahap2->jangkauan_pemasaran)) {
                                $jangkauanData = is_array($tahap2->jangkauan_pemasaran)
                                    ? $tahap2->jangkauan_pemasaran
                                    : json_decode($tahap2->jangkauan_pemasaran, true);
                            }

                            $jangkauanData = is_array($jangkauanData) ? $jangkauanData : [];
                            $standardJangkauan = ['Local', 'Nasional', 'Internasional'];
                            $customJangkauan = array_diff_key($jangkauanData, array_flip($standardJangkauan));
                            $hasCustomJangkauan = !empty($customJangkauan);
                            $jangkauanLainnya = $hasCustomJangkauan ? implode(', ', array_values($customJangkauan)) : '';
                        @endphp

                        @foreach($standardJangkauan as $option)
                            <div class="form-check mb-2">
                                <input class="form-check-input"
                                    type="checkbox"
                                    name="jangkauan_pemasaran[]"
                                    value="{{ $option }}"
                                    id="jangkauan_{{ $option }}"
                                    {{ array_key_exists($option, $jangkauanData) ? 'checked' : '' }}>
                                <label class="form-check-label" for="jangkauan_{{ $option }}">{{ $option }}</label>
                                <input type="text"
                                    class="form-control mt-1"
                                    name="jangkauan_detail[{{ $option }}]"
                                    value="{{ $jangkauanData[$option] ?? '' }}"
                                    placeholder="Detail {{ $option }}">
                            </div>
                        @endforeach

                        <div class="form-check mb-2">
                            <input class="form-check-input"
                                type="checkbox"
                                name="jangkauan_pemasaran[]"
                                value="Lainnya"
                                id="jangkauan_lainnya"
                                {{ $hasCustomJangkauan ? 'checked' : '' }}>
                            <label class="form-check-label" for="jangkauan_lainnya">Lainnya</label>
                            <input type="text"
                                class="form-control mt-1"
                                name="jangkauan_pemasaran_lainnya"
                                value="{{ $jangkauanLainnya }}"
                                placeholder="Jangkauan lainnya (pisahkan dengan koma)">
                        </div>
                    </div>

                    {{-- Foto Produk --}}
                    @php
                        $foto_produk = is_array($tahap2->foto_produk ?? null) ? $tahap2->foto_produk : json_decode($tahap2->foto_produk ?? '[]', true);
                        $foto_tempat_produksi = is_array($tahap2->foto_tempat_produksi ?? null) ? $tahap2->foto_tempat_produksi : json_decode($tahap2->foto_tempat_produksi ?? '[]', true);
                    @endphp

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

                    {{-- Tombol Submit dan Kembali --}}
                    <div class="col-12 d-flex justify-content-start gap-2">
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
                    </div>
                </div>
            </div>
        </div>
    </div>


    @endsection

    @push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        let editorInstance;

        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                editorInstance = editor;

                // Ini WAJIB: sinkronkan data editor ke textarea saat form disubmit
                document.querySelector('form').addEventListener('submit', function () {
                    document.querySelector('#editor').value = editorInstance.getData();
                });
            })
            .catch(error => {
                console.error(error);
            });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle instansi detail inputs
        document.querySelectorAll('[name^="instansi_check"]').forEach(checkbox => {
            const target = document.getElementById(instansi_input_${checkbox.value.toLowerCase()});
            checkbox.addEventListener('change', function() {
                target.style.display = this.checked ? 'block' : 'none';
            });
        });

        // Toggle jangkauan detail inputs
        document.querySelectorAll('[name^="jangkauan_pemasaran"]').forEach(checkbox => {
            const targetId = checkbox.dataset.target;
            const target = document.getElementById(targetId);
            checkbox.addEventListener('change', function() {
                target.style.display = this.checked ? 'block' : 'none';
            });
        });

        // Toggle lainnya inputs
        ['instansi', 'jangkauan'].forEach(section => {
            const toggle = document.getElementById(${section}_lainnya_toggle);
            const input = document.getElementById(${section}_lainnya_input);
            
            toggle.addEventListener('change', function() {
                input.style.display = this.checked ? 'block' : 'none';
                if (!this.checked) input.value = '';
            });
        });
    });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
    // Toggle instansi detail inputs
    document.querySelectorAll('[name^="instansi_check"]').forEach(checkbox => {
        const target = document.getElementById(instansi_input_${checkbox.value.toLowerCase()});
        checkbox.addEventListener('change', function() {
            target.style.display = this.checked ? 'block' : 'none';
        });
    });

    // Toggle jangkauan detail inputs
    document.querySelectorAll('[name^="jangkauan_pemasaran"]').forEach(checkbox => {
        const targetId = checkbox.dataset.target;
        const target = document.getElementById(targetId);
        checkbox.addEventListener('change', function() {
            target.style.display = this.checked ? 'block' : 'none';
        });
    });

    // Toggle lainnya inputs
    ['instansi', 'jangkauan'].forEach(type => {
        const toggle = document.getElementById(${type}_lainnya_toggle);
        const input = document.getElementById(${type}_lainnya_input);
        toggle.addEventListener('change', function() {
            input.style.display = this.checked ? 'block' : 'none';
            if (!this.checked) input.value = '';
        });
    });
});
</script>

    <script>
        $(document).ready(function () {
        const selectedProvKantor = "{{ old('provinsi_kantor', $tahap2->provinsi_kantor ?? '') }}";
        const selectedKotaKantor = "{{ old('kota_kantor', $tahap2->kota_kantor ?? '') }}";

        const selectedProvPabrik = "{{ old('provinsi_pabrik', $tahap2->provinsi_pabrik ?? '') }}";
        const selectedKotaPabrik = "{{ old('kota_pabrik', $tahap2->kota_pabrik ?? '') }}";

        // Load semua provinsi
        $.get("{{ url('admin/umkm-proses/get-provinsi') }}", function (provinsiList) {
            $.each(provinsiList, function (index, provinsi) {
                $('#provinsi_kantor').append(
                    `<option value="${provinsi.id}" ${provinsi.id == selectedProvKantor ? 'selected' : ''}>${provinsi.nama}</option>`
                );

                $('#provinsi_pabrik').append(
                    `<option value="${provinsi.id}" ${provinsi.id == selectedProvPabrik ? 'selected' : ''}>${provinsi.nama}</option>`
                );
            });

            if (selectedProvKantor) {
                $('#provinsi_kantor').trigger('change');
            }

            if (selectedProvPabrik) {
                $('#provinsi_pabrik').trigger('change');
            }
        });

        // Provinsi kantor berubah
        $('#provinsi_kantor').on('change', function () {
            const provId = $(this).val();
            $('#kota_kantor').empty().append('<option value="">-- Pilih Kota --</option>');
            if (provId) {
                $.get(`{{ url('admin/umkm-proses/get-kota') }}/${provId}`, function (kotaList) {
                    $.each(kotaList, function (index, kota) {
                        const selected = kota.id == selectedKotaKantor ? 'selected' : '';
                        $('#kota_kantor').append(`<option value="${kota.id}" ${selected}>${kota.nama}</option>`);
                    });
                });
            }
        });

        // Provinsi pabrik berubah
        $('#provinsi_pabrik').on('change', function () {
            const provId = $(this).val();
            $('#kota_pabrik').empty().append('<option value="">-- Pilih Kota --</option>');
            if (provId) {
                $.get(`{{ url('admin/umkm-proses/get-kota') }}/${provId}`, function (kotaList) {
                    $.each(kotaList, function (index, kota) {
                        const selected = kota.id == selectedKotaPabrik ? 'selected' : '';
                        $('#kota_pabrik').append(`<option value="${kota.id}" ${selected}>${kota.nama}</option>`);
                    });
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

            if (files.length === 0) {
                container.innerHTML = '<p class="text-muted">Tidak ada gambar.</p>';
                return;
            }

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

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize toggle functionality
            initToggleSection('legalitas');
            initToggleSection('sertifikat');
            
            function initToggleSection(type) {
                const toggle = document.getElementById(${type}_lainnya_toggle);
                const container = document.getElementById(custom_${type}_container);
                const addBtn = document.getElementById(add_custom_${type});
                
                if (toggle && container) {
                    // Toggle visibility
                    toggle.addEventListener('change', function() {
                        container.style.display = this.checked ? 'block' : 'none';
                    });
                    
                    // Add new field
                    addBtn?.addEventListener('click', function() {
                        const newField = document.createElement('div');
                        newField.className = 'input-group mb-2';
                        newField.innerHTML = 
                            <input type="text" name="${type}_custom[]" 
                                class="form-control form-control-sm" 
                                placeholder="Masukkan ${type} lainnya">
                            <button type="button" class="btn btn-sm btn-outline-danger remove-custom-item">
                                &times;
                            </button>
                        ;
                        container.insertBefore(newField, this);
                    });
                }
            }
            
            // Remove fields
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-custom-item') || 
                    e.target.classList.contains('remove-custom-legalitas') ||
                    e.target.classList.contains('remove-custom-sertifikat')) {
                    e.target.closest('.input-group').remove();
                }
            });
        });
        </script>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle Sertifikat lainnya toggle
            const sertifikatToggle = document.getElementById('sertifikat_lainnya_toggle');
            const sertifikatContainer = document.getElementById('sertifikat_lainnya_container');
            const sertifikatInput = sertifikatContainer.querySelector('input');
            
            sertifikatToggle.addEventListener('change', function() {
                sertifikatContainer.style.display = this.checked ? 'block' : 'none';
                if (!this.checked) {
                    sertifikatInput.value = '';
                }
            });
            
            sertifikatInput.addEventListener('blur', function() {
                if (this.value.trim() === '') {
                    sertifikatToggle.checked = false;
                    sertifikatContainer.style.display = 'none';
                }
            });
        });
        </script>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('legalitas_lainnya_toggle');
            const container = document.getElementById('legalitas_lainnya_container');
            const inputField = container.querySelector('input');
            
            // Toggle visibility
            toggle.addEventListener('change', function() {
                container.style.display = this.checked ? 'block' : 'none';
                if (!this.checked) {
                    inputField.value = '';
                }
            });
            
            // Hide container if input is empty
            inputField.addEventListener('blur', function() {
                if (this.value.trim() === '') {
                    toggle.checked = false;
                    container.style.display = 'none';
                }
            });
        });
        </script>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to handle checkbox toggles
            function setupToggle(checkboxSelector, inputSelector) {
                document.querySelectorAll(checkboxSelector).forEach(checkbox => {
                    const input = checkbox.closest('.form-check').querySelector(inputSelector);
                    
                    // Set initial state
                    input.disabled = !checkbox.checked;
                    
                    // Add change event
                    checkbox.addEventListener('change', function() {
                        input.disabled = !this.checked;
                        if (!this.checked) {
                            input.value = '';
                        }
                    });
                });
            }
        });
        </script>

        <script>
    document.addEventListener('DOMContentLoaded', function () {
        function toggleTextbox(checkbox, textbox) {
            if (checkbox.checked) {
                textbox.style.display = 'block';
            } else {
                textbox.style.display = 'none';
                textbox.value = ''; // Kosongkan saat tidak dicentang
            }
        }

        // Loop semua checkbox & input di Instansi Pembina
        document.querySelectorAll('input[name="instansi_check[]"]').forEach(function (cb) {
            let textbox = cb.closest('.form-check').querySelector('input[type="text"]');
            toggleTextbox(cb, textbox); // Set awal

            cb.addEventListener('change', function () {
                toggleTextbox(cb, textbox);
            });
        });

        // Loop semua checkbox & input di Jangkauan Pemasaran
        document.querySelectorAll('input[name="jangkauan_pemasaran[]"]').forEach(function (cb) {
            let textbox = cb.closest('.form-check').querySelector('input[type="text"]');
            toggleTextbox(cb, textbox); // Set awal

            cb.addEventListener('change', function () {
                toggleTextbox(cb, textbox);
            });
        });
    });
    </script>
    
    @endpush