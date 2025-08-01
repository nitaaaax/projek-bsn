@extends('layout.app')

@section('content')
<div class="container mt-4">
    <form action="{{ route('umkm.update', $tahap1->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- CARD 1: Data Tahap 1 --}}
        <div class="card shadow-sm mb-4 border-0 rounded-3">
            <div class="card-header bg-light text-dark border-bottom fw-bold">
                <i class="fas fa-user me-2 text-secondary"></i> Informasi Pelaku UMKM
            </div>

            <div class="card-body row g-3">
                {{-- Nama Pelaku sampai Nama Merek --}}
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
                ] as $field => $label)
                    <div class="col-md-6">
                        <label class="form-label">{{ $label }}</label>
                        <input type="text" name="{{ $field }}" class="form-control"
                            value="{{ old($field, $tahap1->$field ?? '') }}">
                    </div>
                @endforeach

                {{-- Select Status --}}
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="">-- Pilih Status --</option>
                        <option value="aktif" {{ old('status', $tahap1->status ?? '') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="drop/tidak dilanjutkan" {{ old('status', $tahap1->status ?? '') == 'drop/tidak dilanjutkan' ? 'selected' : '' }}>Drop / Tidak Dilanjutkan</option>
                        <option value="masih di bina" {{ old('status', $tahap1->status ?? '') == 'masih di bina' ? 'selected' : '' }}>Masih di Bina</option>
                    </select>
                </div>

                {{-- Select Bulan Pertama Pembinaan --}}
                <div class="col-md-6">
                    <label class="form-label">Bulan Pembinaan Pertama</label>
                    <select name="bulan_pertama_pembinaan" class="form-control">
                        @foreach ([
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ] as $key => $label)
                            <option value="{{ $key }}"
                                {{ old('bulan_pertama_pembinaan', $tahap1->bulan_pertama_pembinaan ?? '') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Select Status Pembinaan --}}
                <div class="col-md-6">
                    <label class="form-label">Status Pembinaan</label>
                    <select name="status_pembinaan" class="form-control">
                        <option value="">-- Pilih Status Pembinaan --</option>
                        @foreach ([
                            '1. Identifikasi awal dan Gap',
                            '2. Set up Sistem',
                            '3. Implementasi',
                            '4. Review Sistem & Audit Internal',
                            '5. Pengajuan Sertifikasi',
                            '6. Perbaikan Temuan Audit',
                            '7. Perbaikan Lokasi',
                            '8. Monitoring Pasca Sertifikasi',
                            '9. SPPT SNI'
                        ] as $item)
                            <option
                                value="{{ $item }}"
                                {{ old('status_pembinaan', $tahap1->status_pembinaan ?? '') == $item ? 'selected' : '' }}
                                @if($item == '9. SPPT SNI') style="color: green; font-weight: bold;" @endif>
                                {{ $item }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Riwayat Pembinaan --}}
                <div class="col-md-12">
                    <label class="form-label">Riwayat Pembinaan</label>
                    <textarea name="riwayat_pembinaan" id="riwayat_pembinaan" class="form-control" rows="4">
                        {!! old('riwayat_pembinaan', $tahap1->riwayat_pembinaan ?? '') !!}
                    </textarea>

                </div>
            </div>
        </div>

        @php
            $tahap2 = $tahap2 ?? (object)[];
            $foto_produk = $foto_produk ?? [];
            $foto_tempat_produksi = $foto_tempat_produksi ?? [];

            // Decode Tanda merek
            $merek = [];
            if (!empty($tahap2->merek)) {
                $decoded = json_decode($tahap2->merek, true);
                $merek = is_array($decoded) ? $decoded : [$tahap2->merek];
            }
        @endphp


        {{-- CARD 2: Data Tahap 2 --}}
        <div class="card shadow-sm mb-4 border-0 rounded-3">
            <div class="card-header bg-light text-dark border-bottom fw-bold">
                <i class="fas fa-industry me-2 text-secondary"></i> Detail Usaha & Produksi
            </div>
            <div class="card-body row g-3">

                {{-- ID Pelaku Usaha --}}
                <div class="col-md-6">
                    <label class="form-label">ID Pelaku Usaha</label>
                    <input type="text" name="pelaku_usaha_id" class="form-control"
                        value="{{ old('pelaku_usaha_id', $tahap2->pelaku_usaha_id ?? '') }}">
                </div>

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
                <div class="col-md-6">
                    <label class="form-label">Provinsi Kantor</label>
                    <input type="text" name="provinsi_kantor" class="form-control"
                        value="{{ old('provinsi_kantor', $tahap2->provinsi_kantor ?? '') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kota Kantor</label>
                    <input type="text" name="kota_kantor" class="form-control"
                        value="{{ old('kota_kantor', $tahap2->kota_kantor ?? '') }}">
                </div>

                <div class="col-12">
                    <label class="form-label">Alamat Pabrik</label>
                    <textarea name="alamat_pabrik" class="form-control" rows="2">{{ old('alamat_pabrik', $tahap2->alamat_pabrik ?? '') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Provinsi Pabrik</label>
                    <input type="text" name="provinsi_pabrik" class="form-control"
                        value="{{ old('provinsi_pabrik', $tahap2->provinsi_pabrik ?? '') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kota Pabrik</label>
                    <input type="text" name="kota_pabrik" class="form-control"
                        value="{{ old('kota_pabrik', $tahap2->kota_pabrik ?? '') }}">
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
                    <input type="text" name="sni_yang_akan_diterapkan" class="form-control"
                        value="{{ old('sni_yang_akan_diterapkan', $tahap2->sni_yang_akan_diterapkan ?? '') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">LSPRO</label>
                    <input type="text" name="lspro" class="form-control"
                        value="{{ old('lspro', $tahap2->lspro ?? '') }}">
                </div>
               <div class="col-md-6">

                    @php
                    $instansi = $tahap2->instansi ?? ''; // contoh: "Dinas: Dinas Perdagangan; Kementerian: Kemenperin"
                    $instansiArray = [];

                    foreach (['Dinas', 'Kementerian', 'Perguruan Tinggi', 'Komunitas'] as $item) {
                        if (preg_match("/$item:([^;]*)/", $instansi, $matches)) {
                            $instansiArray[$item] = trim($matches[1]);
                        } else {
                            $instansiArray[$item] = '';
                        }
                    }
                @endphp

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Instansi yang Pernah/Sedang Membina</label>

                    @foreach (['Dinas', 'Kementerian', 'Perguruan Tinggi', 'Komunitas'] as $item)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="check_{{ $item }}" name="instansi_check[]" value="{{ $item }}"
                                {{ $instansiArray[$item] ? 'checked' : '' }} onchange="toggleInput('{{ $item }}')">
                            <label class="form-check-label" for="check_{{ $item }}">{{ $item }}</label>

                            <input type="text" class="form-control mt-1"
                                name="instansi_detail[{{ $item }}]"
                                id="input_{{ $item }}"
                                placeholder="Isi nama {{ strtolower($item) }}"
                                value="{{ old("instansi_detail.$item", $instansiArray[$item]) }}"
                                {{ $instansiArray[$item] ? '' : 'style=display:none' }}>
                        </div>
                    @endforeach
                </div>

            </div>
                <div class="col-md-6">
                    <label class="form-label">Sertifikat yang Dimiliki</label>
                    <input type="text" name="sertifikat" class="form-control"
                        value="{{ old('sertifikat', $tahap2->sertifikat ?? '') }}">
                </div>

                {{-- Jenis Usaha --}}
                <div class="mb-3 col-md-6">
                    <label for="jenis_usaha" class="form-label fw-bold">Jenis Usaha</label>
                    <select name="jenis_usaha" id="jenis_usaha" class="form-control">
                        <option value="">-- Pilih Jenis Usaha --</option>
                        <option value="Pangan" {{ old('jenis_usaha', $tahap2->jenis_usaha ?? '') == 'Pangan' ? 'selected' : '' }}>Pangan</option>
                        <option value="Nonpangan" {{ old('jenis_usaha', $tahap2->jenis_usaha ?? '') == 'Nonpangan' ? 'selected' : '' }}>Nonpangan</option>
                    </select>
                </div>

                {{-- Tanda Daftar merek --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanda Daftar merek</label>
                    <div class="ms-2">
                        @foreach (["Terdaftar di Kemenkumham", "Belum Terdaftar"] as $option)
                            <div class="form-check">
                                <input type="checkbox" name="merek[]" class="form-check-input"
                                value="{{ $option }}" id="merek{{ Str::slug($option, '_') }}"
                                {{ in_array($option, old('merek', $merek)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="merek{{ Str::slug($option, '_') }}">{{ $option }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Jangkauan Pemasaran --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jangkauan Pemasaran</label>
                    <div class="ms-2">
                        @foreach (["Local", "Nasional", "Internasional"] as $option)
                            <div class="form-check">
                                <input type="checkbox" name="jangkauan_pemasaran[]" class="form-check-input"
                                    value="{{ $option }}" id="jangkauan_{{ $option }}"
                                    {{ in_array($option, $jangkauan) ? 'checked' : '' }}>
                                <label class="form-check-label" for="jangkauan_{{ $option }}">{{ $option }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

{{-- Foto Produk --}}
<div class="col-md-6 mb-3">
    <label class="form-label">Foto Produk (bisa lebih dari satu)</label>
    <input type="file" name="foto_produk[]" class="form-control" multiple onchange="previewImages(this, 'preview-produk')">

    {{-- Preview Foto Lama --}}
    <div id="old-preview-produk" class="mt-2 d-flex flex-wrap">
        @if (is_array($tahap1->foto_produk) && count($tahap1->foto_produk) > 0)
            @foreach ($tahap1->foto_produk as $foto)
                <div class="position-relative me-2 mb-2 old-foto-produk">
                    <img src="{{ asset('storage/foto_produk/' . $foto) }}" width="100" class="rounded">
                    <input type="hidden" name="old_foto_produk[]" value="{{ $foto }}">
                    <button type="button" class="btn btn-sm btn-danger p-1 btn-remove-old" style="position: absolute; top: 0; right: 0;">
                        &times;
                    </button>
                </div>
            @endforeach
        @else
            <p class="text-muted">Belum ada foto produk.</p>
        @endif
    </div>

    {{-- Preview Gambar Baru --}}
    <div id="preview-produk" class="mt-2 d-flex flex-wrap"></div>
</div>


                {{-- Foto Tempat Produksi --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Foto Tempat Produksi (bisa lebih dari satu)</label>
                    <input type="file" name="foto_tempat_produksi[]" class="form-control" multiple onchange="previewImages(this, 'preview-tempat')">
                    <div id="old-preview-tempat" class="mt-2 d-flex flex-wrap">
                        @foreach ($foto_tempat_produksi as $foto)
                            <div class="position-relative me-2 mb-2 old-foto-tempat">
                                <img src="{{ asset('storage/' . $foto) }}" width="100" class="rounded">
                                <input type="hidden" name="old_foto_tempat_produksi[]" value="{{ $foto }}">
                                <button type="button" class="btn btn-sm btn-danger p-1 btn-remove-old" style="position: absolute; top: 0; right: 0;">
                                    &times;
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <div id="preview-tempat" class="mt-2 d-flex flex-wrap"></div>
                </div>
            </div>
        </div>

        {{-- Submit dan Kembali --}}
        <div class="d-flex justify-content-end gap-3 mb-5 me-3">
            <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm rounded-pill px-3" title="Kembali">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4" title="Simpan Perubahan">
                <i class="fas fa-save"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function previewImages(input, targetId) {
    const target = document.getElementById(targetId);
    target.innerHTML = "";

    const files = Array.from(input.files);

    files.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const wrapper = document.createElement('div');
            wrapper.className = "position-relative me-2 mb-2";

            const img = document.createElement('img');
            img.src = e.target.result;
            img.width = 100;
            img.className = "rounded";

            const btn = document.createElement('button');
            btn.type = "button";
            btn.innerHTML = "&times;";
            btn.className = "btn btn-sm btn-danger p-1";
            btn.style.position = "absolute";
            btn.style.top = "0";
            btn.style.right = "0";

            btn.onclick = () => {
                files.splice(index, 1);
                const dt = new DataTransfer();
                files.forEach(f => dt.items.add(f));
                input.files = dt.files;
                previewImages(input, targetId);
            };

            wrapper.appendChild(img);
            wrapper.appendChild(btn);
            target.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
    });
}

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
