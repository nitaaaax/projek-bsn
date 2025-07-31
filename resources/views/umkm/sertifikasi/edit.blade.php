@extends('layout.app')

@section('content')
<div class="container mt-4">
    <form action="{{ route('umkm.sertifikasi.edit', $tahap1->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- CARD 1: Data Tahap 1 --}}
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-user fa-fw me-2"></i> Informasi Pelaku UMKM
            </div>
            <div class="card-body row g-3">
                @foreach ([
                    'nama_pelaku' => 'Nama Pelaku',
                    'produk' => 'Produk',
                    'klasifikasi' => 'Klasifikasi',
                    'status' => 'Status',
                    'pembina_1' => 'Pembina 1',
                    'pembina_2' => 'Pembina 2',
                    'sinergi' => 'Sinergi',
                    'nama_kontak_person' => 'Kontak Person',
                    'no_hp' => 'No HP',
                    'bulan_pertama_pembinaan' => 'Bulan Pembinaan Pertama',
                    'tahun_dibina' => 'Tahun Dibina',
                    'riwayat_pembinaan' => 'Riwayat Pembinaan',
                    'status_pembinaan' => 'Status Pembinaan',
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
            </div>
        </div>

        {{-- CARD 2: Data Tahap 2 --}}
        <div class="card shadow mb-4">
            <div class="card-header bg-success text-white">
                <i class="fas fa-industry fa-fw me-2"></i> Detail Usaha & Produksi
            </div>
            <div class="card-body row g-3">
               @php
                    $t2 = $tahap2 ?? (object)[];

                    $foto_produk = is_string($t2->foto_produk ?? null)
                        ? json_decode($t2->foto_produk, true)
                        : ($t2->foto_produk ?? []);

                    $foto_tempat_produksi = is_string($t2->foto_tempat_produksi ?? null)
                        ? json_decode($t2->foto_tempat_produksi, true)
                        : ($t2->foto_tempat_produksi ?? []);

                    $jangkauan = is_string($t2->jangkauan_pemasaran ?? null)
                        ? json_decode($t2->jangkauan_pemasaran, true)
                        : ($t2->jangkauan_pemasaran ?? []);
                @endphp


                @php
                $fields_tahap2 = [
                    'pelaku_usaha_id' => 'ID Pelaku Usaha',
                    'omzet' => 'Omzet',
                    'volume_per_tahun' => 'Volume per Tahun',
                    'jumlah_tenaga_kerja' => 'Jumlah Tenaga Kerja',
                    'link_dokumen' => 'Link Dokumen',
                    'alamat_kantor' => 'Alamat Kantor',
                    'provinsi_kantor' => 'Provinsi Kantor',
                    'kota_kantor' => 'Kota Kantor',
                    'alamat_pabrik' => 'Alamat Pabrik',
                    'provinsi_pabrik' => 'Provinsi Pabrik',
                    'kota_pabrik' => 'Kota Pabrik',
                    'legalitas_usaha' => 'Legalitas Usaha',
                    'tahun_pendirian' => 'Tahun Pendirian',
                    'jenis_usaha' => 'Jenis Usaha',
                    'sni' => 'SNI',
                    'lspro' => 'LSPRO',
                    'tanda_daftar_merek' => 'Tanda Daftar Merek',
                ];
                @endphp

               @foreach ($fields_tahap2 as $field => $label)
                    <div class="col-md-6">
                        <label class="form-label">{{ $label }}</label>

                        @if ($field === 'jenis_usaha')
                            <select name="{{ $field }}" class="form-control">
                                <option value="">-- Pilih Jenis Usaha --</option>
                                <option value="Pangan" {{ old($field, $t2->$field ?? '') == 'Pangan' ? 'selected' : '' }}>Pangan</option>
                                <option value="Nonpangan" {{ old($field, $t2->$field ?? '') == 'Nonpangan' ? 'selected' : '' }}>Nonpangan</option>
                            </select>
                        @else
                            <input type="text" name="{{ $field }}" class="form-control"
                                value="{{ old($field, $t2->$field ?? '') }}">
                        @endif
                    </div>
                @endforeach


                {{-- Jangkauan Pemasaran --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jangkauan Pemasaran</label>
                    <div class="ms-2">
                        @foreach (['Local', 'Nasional', 'Internasional'] as $option)
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
                <div class="col-md-6">
                    <label class="form-label">Foto Produk (bisa lebih dari satu)</label>
                    <input type="file" name="foto_produk[]" class="form-control" multiple>
                    @if (!empty($foto_produk))
                        <div class="mt-2 d-flex flex-wrap">
                            @foreach ($foto_produk as $foto)
                                <img src="{{ asset('storage/' . $foto) }}" width="100" class="me-2 mb-2 rounded">
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Foto Tempat Produksi --}}
                <div class="col-md-6">
                    <label class="form-label">Foto Tempat Produksi (bisa lebih dari satu)</label>
                    <input type="file" name="foto_tempat_produksi[]" class="form-control" multiple>
                    @if (!empty($foto_tempat_produksi))
                        <div class="mt-2 d-flex flex-wrap">
                            @foreach ($foto_tempat_produksi as $foto)
                                <img src="{{ asset('storage/' . $foto) }}" width="100" class="me-2 mb-2 rounded">
                            @endforeach
                        </div>
                    @endif
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
