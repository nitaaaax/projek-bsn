@extends('layout.app')

@section('content')
<div class="container mt-4">
  <div class="card border-0 shadow rounded-4">
    <div class="card-body">
      <h3 class="mb-4 text-primary fw-bold">
        <i class="fa fa-eye me-2"></i> Detail UMKM (User View)
      </h3>

      <div class="row mb-4">
        {{-- === Tahap 1 === --}}
        <div class="col-md-6">
          <h5 class="text-success">Data Tahap 1</h5>
          <table class="table table-bordered">
            <tr><th>Nama Pelaku</th><td>{{ $tahap1->nama_pelaku ?? '-' }}</td></tr>
            <tr><th>Produk</th><td>{{ $tahap1->produk ?? '-' }}</td></tr>
            <tr><th>Klasifikasi</th><td>{{ $tahap1->klasifikasi ?? '-' }}</td></tr>
            <tr><th>Status</th><td>{{ $tahap1->status ?? '-' }}</td></tr>
            <tr><th>Pembina 1</th><td>{{ $tahap1->pembina_1 ?? '-' }}</td></tr>
            <tr><th>Pembina 2</th><td>{{ $tahap1->pembina_2 ?? '-' }}</td></tr>
            <tr><th>Nama Kontak Person</th><td>{{ $tahap1->nama_kontak_person ?? '-' }}</td></tr>
            <tr><th>No HP</th><td>{{ $tahap1->no_hp ?? '-' }}</td></tr>
            <tr><th>Email</th><td>{{ $tahap1->email ?? '-' }}</td></tr>
            <tr><th>Media Sosial</th><td>
              @if($tahap1->media_sosial)
                <a href="{{ $tahap1->media_sosial }}" target="_blank">{{ $tahap1->media_sosial }}</a>
              @else
                -
              @endif
            </td></tr>
            <tr><th>Nama Merek</th><td>{{ $tahap1->nama_merek ?? '-' }}</td></tr>
            <tr><th>Tahun Dibina</th><td>{{ $tahap1->tahun_dibina ?? '-' }}</td></tr>
            <tr><th>Bulan Pertama Pembinaan</th><td>{{ $tahap1->bulan_pertama_pembinaan ?? '-' }}</td></tr>
            <tr><th>Status Pembinaan</th><td>{{ $tahap1->status_pembinaan ?? '-' }}</td></tr>
            <tr><th>Jenis Usaha</th><td>{{ $tahap1->jenis_usaha ?? '-' }}</td></tr>
            <tr><th>Tanda Daftar Merek</th><td>{{ $tahap1->tanda_daftar_merk ?? '-' }}</td></tr>
            <tr>
              <th>Riwayat Pembinaan</th>
              <td>
                @if($tahap1->riwayat_pembinaan)
                  <div class="editor-content">
                    {!! $tahap1->riwayat_pembinaan !!}
                  </div>
                @else
                  -
                @endif
              </td>
            </tr>
          </table>
        </div>

        {{-- === Tahap 2 === --}}
        <div class="col-md-6">
          <h5 class="text-info">Data Tahap 2</h5>
          @if($tahap2)
          <table class="table table-bordered">
            <tr><th>Omzet</th><td>Rp {{ number_format($tahap2->omzet ?? 0, 0, ',', '.') }}</td></tr>
            <tr><th>Volume per Tahun</th><td>{{ $tahap2->volume_per_tahun ?? '-' }} unit</td></tr>
            <tr><th>Jumlah Tenaga Kerja</th><td>{{ $tahap2->jumlah_tenaga_kerja ?? '-' }} orang</td></tr>
            <tr><th>Gruping</th><td>{{ $tahap2->gruping ?? '-' }}</td></tr>
            <tr>
              <th>Jangkauan Pemasaran</th>
              <td>
                @php
                  $jangkauan = [];
                  if (!empty($tahap2->jangkauan_pemasaran)) {
                    $jangkauan = is_array($tahap2->jangkauan_pemasaran)
                        ? $tahap2->jangkauan_pemasaran
                        : json_decode($tahap2->jangkauan_pemasaran, true);
                  }
                @endphp
                @if(count($jangkauan) > 0)
                  <ul class="mb-0">
                    @foreach($jangkauan as $key => $value)
                      <li>{{ $key }}: {{ $value }}</li>
                    @endforeach
                  </ul>
                @else
                  -
                @endif
              </td>
            </tr>
            <tr>
              <th>Link Dokumen</th>
              <td>
                @if($tahap2->link_dokumen)
                  <a href="{{ $tahap2->link_dokumen }}" target="_blank">{{ $tahap2->link_dokumen }}</a>
                @else
                  -
                @endif
              </td>
            </tr>
            <tr><th>Alamat Kantor</th><td>{{ $tahap2->alamat_kantor ?? '-' }}</td></tr>
            <tr><th>Provinsi Kantor</th><td>{{ $tahap2->provinsi_kantor ?? '-' }}</td></tr>
            <tr><th>Kota Kantor</th><td>{{ $tahap2->kota_kantor ?? '-' }}</td></tr>
            <tr><th>Alamat Pabrik</th><td>{{ $tahap2->alamat_pabrik ?? '-' }}</td></tr>
            <tr><th>Provinsi Pabrik</th><td>{{ $tahap2->provinsi_pabrik ?? '-' }}</td></tr>
            <tr><th>Kota Pabrik</th><td>{{ $tahap2->kota_pabrik ?? '-' }}</td></tr>
            <tr><th>Tahun Pendirian</th><td>{{ $tahap2->tahun_pendirian ?? '-' }}</td></tr>
            <tr><th>SNI yang Diterapkan</th><td>{{ $tahap2->sni_yang_diterapkan ?? '-' }}</td></tr>
            <tr>
              <th>Legalitas Usaha</th>
              <td>
                @php
                  $legalitas = [];
                  if (!empty($tahap2->legalitas_usaha)) {
                    $legalitas = is_array($tahap2->legalitas_usaha)
                        ? $tahap2->legalitas_usaha
                        : json_decode($tahap2->legalitas_usaha, true);
                  }
                @endphp
                @if(count($legalitas) > 0)
                  <ul class="mb-0">
                    @foreach($legalitas as $item)
                      <li>{{ $item }}</li>
                    @endforeach
                  </ul>
                @else
                  -
                @endif
              </td>
            </tr>
            <tr>
              <th>Sertifikat</th>
              <td>
                @php
                  $sertifikat = [];
                  if (!empty($tahap2->sertifikat)) {
                    $sertifikat = is_array($tahap2->sertifikat)
                        ? $tahap2->sertifikat
                        : json_decode($tahap2->sertifikat, true);
                  }
                @endphp
                @if(count($sertifikat) > 0)
                  <ul class="mb-0">
                    @foreach($sertifikat as $item)
                      <li>{{ $item }}</li>
                    @endforeach
                  </ul>
                @else
                  -
                @endif
              </td>
            </tr>
            <tr>
              <th>Instansi Pembina</th>
              <td>
                @php
                  $instansi = [];
                  if (!empty($tahap2->instansi)) {
                    $instansi = is_array($tahap2->instansi)
                        ? $tahap2->instansi
                        : json_decode($tahap2->instansi, true);
                  }
                @endphp
                @if(count($instansi) > 0)
                  <ul class="mb-0">
                    @foreach($instansi as $key => $value)
                      <li>{{ $key }}: {{ $value }}</li>
                    @endforeach
                  </ul>
                @else
                  -
                @endif
              </td>
            </tr>
            {{-- Foto Produk --}}
            <tr>
              <th>Foto Produk</th>
              <td>
                @php
                  $foto_produk = [];
                  if (!empty($tahap2->foto_produk)) {
                    $foto_produk = is_array($tahap2->foto_produk)
                        ? $tahap2->foto_produk
                        : json_decode($tahap2->foto_produk, true);
                  }
                @endphp

                @if(count($foto_produk) > 0)
                  <div class="d-flex flex-wrap">
                    @foreach($foto_produk as $foto)
                      <img src="{{ asset('storage/' . $foto) }}" 
                          class="img-thumbnail m-1" 
                          width="120" 
                          alt="Foto Produk"
                          onerror="this.onerror=null;this.src='{{ asset('asset/dist/img/no-image.jpg') }}';">
                    @endforeach
                  </div>
                @else
                  <span class="text-muted">-</span>
                @endif
              </td>
            </tr>

            {{-- Foto Tempat Produksi --}}
            <tr>
              <th>Foto Tempat Produksi</th>
              <td>
                @php
                  $foto_tempat = [];
                  if (!empty($tahap2->foto_tempat_produksi)) {
                    $foto_tempat = is_array($tahap2->foto_tempat_produksi)
                        ? $tahap2->foto_tempat_produksi
                        : json_decode($tahap2->foto_tempat_produksi, true);
                  }
                @endphp

                @if(count($foto_tempat) > 0)
                  <div class="d-flex flex-wrap">
                    @foreach($foto_tempat as $foto)
                      <img src="{{ asset('storage/' . $foto) }}" 
                          class="img-thumbnail m-1" 
                          width="120" 
                          alt="Foto Tempat Produksi"
                          onerror="this.onerror=null;this.src='{{ asset('asset/dist/img/no-image.jpg') }}';">
                    @endforeach
                  </div>
                @else
                  <span class="text-muted">-</span>
                @endif
              </td>
            </tr>
          </table>
          @else
            <div class="alert alert-warning">Belum ada data Tahap 2</div>
          @endif
        </div>
      </div>

      <a href="{{ route('user.umkm.index') }}" class="btn btn-secondary mt-3">
        <i class="fa fa-arrow-left me-1"></i> Kembali
      </a>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
  .editor-content {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    color: #333;
  }
  .editor-content p {
    margin-bottom: 1em;
  }
  .editor-content ul, 
  .editor-content ol {
    margin-bottom: 1em;
    padding-left: 2em;
  }
  .editor-content h1, 
  .editor-content h2, 
  .editor-content h3, 
  .editor-content h4, 
  .editor-content h5, 
  .editor-content h6 {
    margin-top: 1.5em;
    margin-bottom: 0.5em;
    font-weight: bold;
  }
  .editor-content strong {
    font-weight: bold;
  }
  .editor-content em {
    font-style: italic;
  }
  .editor-content u {
    text-decoration: underline;
  }
</style>
@endpush