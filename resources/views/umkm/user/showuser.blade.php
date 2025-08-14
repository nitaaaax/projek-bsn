@extends('layout.app')

@section('content')
<div class="container mt-4">
  <div class="card border-0 shadow rounded-4">
    <div class="card-body">
      <h3 class="mb-4 text-primary fw-bold">
        <i class="fa fa-eye"></i> Detail UMKM (User View)
      </h3>

      {{-- ======================== 1. PROFIL PELAKU USAHA ======================== --}}
      <div class="card section-card mb-4">
        <div class="card-header section-header text-white">
          <i class="fa fa-id-card"></i>  1. Profil Pelaku Usaha
        </div>
        <div class="card-body p-0">
          <table class="table table-bordered m-0">
            <tr><th class="w-25">Nama Pelaku</th><td>{{ $tahap1->nama_pelaku ?? '-' }}</td></tr>
            <tr><th>No HP</th><td>{{ $tahap1->no_hp ?? '-' }}</td></tr>
            <tr><th>Email</th><td>{{ $tahap1->email ?? '-' }}</td></tr>
            <tr>
              <th>Media Sosial</th>
              <td>
                @if($tahap1->media_sosial)
                  <a href="{{ $tahap1->media_sosial }}" target="_blank">{{ $tahap1->media_sosial }}</a>
                @else
                  -
                @endif
              </td>
            </tr>
          </table>
        </div>
      </div>

      {{-- ======================== 2. INFORMASI UMKM ======================== --}}
      <div class="card section-card mb-4">
        <div class="card-header section-header text-white">
          <i class="fa fa-store"></i>  2. Informasi UMKM
        </div>
        <div class="card-body p-0">
          <table class="table table-bordered m-0">
            <tr><th class="w-25">Produk</th><td>{{ $tahap1->produk ?? '-' }}</td></tr>
            <tr><th>Klasifikasi</th><td>{{ $tahap1->klasifikasi ?? '-' }}</td></tr>
            <tr><th>Status</th><td>{{ $tahap1->status ?? '-' }}</td></tr>
            <tr><th>Pembina 1</th><td>{{ $tahap1->pembina_1 ?? '-' }}</td></tr>
            <tr><th>Pembina 2</th><td>{{ $tahap1->pembina_2 ?? '-' }}</td></tr>
            <tr><th>Nama Merek</th><td>{{ $tahap1->nama_merek ?? '-' }}</td></tr>
            <tr><th>Tahun Dibina</th><td>{{ $tahap1->tahun_dibina ?? '-' }}</td></tr>
            <tr><th>Bulan Pertama Pembinaan</th><td>{{ $tahap1->bulan_pertama_pembinaan ?? '-' }}</td></tr>
            <tr>
              <th>Status Pembinaan</th>
              <td>
                @php
                  $status = $tahap1->status_pembinaan ?? '-';
                  $isSertif = in_array($status, ['SPPT SNI', 'SPPT SNI (TERSERTIFIKASI)']);
                @endphp
                <span class="badge {{ $isSertif ? 'bg-success' : 'bg-secondary' }}">
                  {{ $status }}
                </span>
              </td>
            </tr>
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
      </div>

      {{-- ======================== 3. LOKASI & ALAMAT ======================== --}}
      <div class="card section-card mb-4">
        <div class="card-header section-header text-white">
          <i class="fa fa-map-marker-alt"></i>  3. Lokasi & Alamat
        </div>
        <div class="card-body p-0">
          @if($tahap2)
          <table class="table table-bordered m-0">
            <tr><th class="w-25">Provinsi Kantor</th><td>{{ $provinsiKantor }}</td></tr>
            <tr><th>Kota Kantor</th><td>{{ $kotaKantor }}</td></tr>
            <tr><th>Alamat Kantor</th><td>{{ $tahap2->alamat_kantor ?? '-' }}</td></tr>
            <tr><th>Provinsi Pabrik</th><td>{{ $provinsiPabrik }}</td></tr>
            <tr><th>Kota Pabrik</th><td>{{ $kotaPabrik }}</td></tr>
            <tr><th>Alamat Pabrik</th><td>{{ $tahap2->alamat_pabrik ?? '-' }}</td></tr>
          </table>
          @else
            <div class="alert alert-warning m-0">Belum ada data Tahap 2</div>
          @endif
        </div>
      </div>

      {{-- ======================== 4. LEGALITAS & SERTIFIKASI ======================== --}}
      <div class="card section-card mb-4">
        <div class="card-header section-header text-white">
          <i class="fa fa-certificate"></i>  4. Legalitas & Sertifikasi
        </div>
        <div class="card-body p-0">
          @if($tahap2)
          <table class="table table-bordered m-0">
            {{-- Legalitas Usaha --}}
            <tr>
              <th class="w-25">Legalitas Usaha</th>
              <td>
                @php
                  $legalitasData = !empty($tahap2->legalitas_usaha)
                      ? (is_array($tahap2->legalitas_usaha) ? $tahap2->legalitas_usaha : json_decode($tahap2->legalitas_usaha, true))
                      : [];
                  $legalitasFormatted = [];
                  for ($i = 0; $i < count($legalitasData); $i++) {
                      $val = trim($legalitasData[$i]);
                      if (strcasecmp($val, 'lainnya') === 0 && isset($legalitasData[$i+1])) {
                          $legalitasFormatted[] = 'Lainnya: ' . trim($legalitasData[++$i]);
                      } else {
                          $legalitasFormatted[] = $val;
                      }
                  }
                @endphp

                @if($legalitasFormatted)
                  <ul class="mb-0">
                    @foreach($legalitasFormatted as $item)
                      <li>{{ $item }}</li>
                    @endforeach
                  </ul>
                @else
                  -
                @endif
              </td>
            </tr>

            {{-- Sertifikat Lain yang Dimiliki --}}
          <tr>
                <th>Sertifikat Lain yang Dimiliki</th>
                <td>
                  @php
                      $sertifikatData = !empty($tahap2->sertifikat)
                          ? (is_array($tahap2->sertifikat) ? $tahap2->sertifikat : json_decode($tahap2->sertifikat, true))
                          : [];

                      $sertifikatFormatted = [];
                      foreach ($sertifikatData as $val) {
                          $val = trim($val);

                          // Deteksi kalau diawali "lainnya" (case-insensitive)
                          if (stripos($val, 'lainnya') === 0) {
                              // Ambil teks setelah kata "lainnya"
                              $after = trim(substr($val, strlen('lainnya')));
                              $sertifikatFormatted[] = 'Lainnya: ' . ($after ?: '-');
                          } else {
                              $sertifikatFormatted[] = $val;
                          }
                      }
                  @endphp

                  @if($sertifikatFormatted)
                      <ul class="mb-0">
                          @foreach($sertifikatFormatted as $item)
                              <li>{{ $item }}</li>
                          @endforeach
                      </ul>
                  @else
                      -
                  @endif
                </td>
            </tr>

            {{-- Tanda Daftar Merek (dari Tahap 1 agar sesuai lama) --}}
            <tr><th>Tanda Daftar Merek</th><td>{{ $tahap1->tanda_daftar_merk ?? '-' }}</td></tr>

            {{-- SNI yang Diterapkan --}}
            <tr><th>SNI yang Diterapkan</th><td>{{ $tahap2->sni_yang_diterapkan ?? '-' }}</td></tr>

            {{-- Instansi Pembina --}}
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
          </table>
          @else
            <div class="alert alert-warning m-0">Belum ada data Tahap 2</div>
          @endif
        </div>
      </div>

      {{-- ======================== 5. PRODUKSI & PEMASARAN ======================== --}}
      <div class="card section-card mb-4">
        <div class="card-header section-header text-white">
          <i class="fa fa-industry"></i>  5. Produksi & Pemasaran
        </div>
        <div class="card-body p-0">
          @if($tahap2)
          <table class="table table-bordered m-0">
            <tr><th class="w-25">Omzet</th><td>Rp {{ number_format($tahap2->omzet ?? 0, 0, ',', '.') }}</td></tr>
            <tr><th>Volume per Tahun</th><td>{{ $tahap2->volume_per_tahun ?? '-' }} unit</td></tr>
            <tr><th>Jumlah Tenaga Kerja</th><td>{{ $tahap2->jumlah_tenaga_kerja ?? '-' }} orang</td></tr>
            <tr><th>Gruping</th><td>{{ $tahap2->gruping ?? '-' }}</td></tr>
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
            <tr>
              <th>Jangkauan Pemasaran</th>
              <td>
                @php
                  $jangkauan = !empty($tahap2->jangkauan_pemasaran)
                      ? (is_array($tahap2->jangkauan_pemasaran) ? $tahap2->jangkauan_pemasaran : json_decode($tahap2->jangkauan_pemasaran, true))
                      : [];
                  $jangkauanFormatted = [];
                  foreach ($jangkauan as $key => $value) {
                      if (stripos($key, 'lainnya') === 0) {
                          $jangkauanFormatted[] = 'Lainnya: ' . $value;
                      } else {
                          $jangkauanFormatted[] = ucfirst($key) . ': ' . $value;
                      }
                  }
                @endphp

                @if($jangkauanFormatted)
                  <ul class="mb-0">
                    @foreach($jangkauanFormatted as $item)
                      <li>{{ $item }}</li>
                    @endforeach
                  </ul>
                @else
                  -
                @endif
              </td>
            </tr>
          </table>
          @else
            <div class="alert alert-warning m-0">Belum ada data Tahap 2</div>
          @endif
        </div>
      </div>

      {{-- ======================== 6. DOKUMENTASI ======================== --}}
      <div class="card section-card mb-4">
        <div class="card-header section-header text-white">
          <i class="fa fa-images"></i>  6. Dokumentasi
        </div>
        <div class="card-body p-0">
          @if($tahap2)
          <table class="table table-bordered m-0">
            {{-- Foto Produk --}}
            <tr>
              <th class="w-25">Foto Produk</th>
              <td>
                @php
                  $foto_produk = [];
                  $has_product_photo = false;
                  if (!empty($tahap2->foto_produk)) {
                    $foto_produk = is_array($tahap2->foto_produk)
                        ? $tahap2->foto_produk
                        : json_decode($tahap2->foto_produk, true);
                    $has_product_photo = count($foto_produk) > 0;
                  }
                @endphp

                @if($has_product_photo)
                  <div class="d-flex flex-wrap">
                    @foreach($foto_produk as $foto)
                      <img src="{{ asset('storage/' . $foto) }}"
                           class="img-thumbnail m-1"
                           width="120"
                           alt="Foto Produk"
                           onerror="this.onerror=null;this.src='{{ asset('public/asset/dist/img/no-image.jpg') }}';">
                    @endforeach
                  </div>
                @else
                  <img src="{{ asset('public/asset/dist/img/no-image.jpg') }}"
                       class="img-thumbnail"
                       width="120"
                       alt="No Product Image">
                @endif
              </td>
            </tr>

            {{-- Foto Tempat Produksi --}}
            <tr>
              <th>Foto Tempat Produksi</th>
              <td>
                @php
                  $foto_tempat = [];
                  $has_place_photo = false;
                  if (!empty($tahap2->foto_tempat_produksi)) {
                    $foto_tempat = is_array($tahap2->foto_tempat_produksi)
                        ? $tahap2->foto_tempat_produksi
                        : json_decode($tahap2->foto_tempat_produksi, true);
                    $has_place_photo = count($foto_tempat) > 0;
                  }
                @endphp

                @if($has_place_photo)
                  <div class="d-flex flex-wrap">
                    @foreach($foto_tempat as $foto)
                      <img src="{{ asset('storage/' . $foto) }}"
                           class="img-thumbnail m-1"
                           width="120"
                           alt="Foto Tempat Produksi"
                           onerror="this.onerror=null;this.src='{{ asset('public/asset/dist/img/no-image.jpg') }}';">
                    @endforeach
                  </div>
                @else
                  <img src="{{ asset('public/asset/dist/img/no-image.jpg') }}"
                       class="img-thumbnail"
                       width="120"
                       alt="No Production Place Image">
                @endif
              </td>
            </tr>
          </table>
          @else
            <div class="alert alert-warning m-0">Belum ada data Tahap 2</div>
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
  /* SECTION HEADERS - TEAL BLUE (#2EC6DF) */
  .section-header {
    background-color: #2EC6DF !important;
    color: white !important;
    border-top-left-radius: 0.5rem !important;
    border-top-right-radius: 0.5rem !important;
    font-weight: 700 !important;
    padding: 0.75rem 1.25rem !important;
    border-bottom: none !important;
  }

  /* Section cards */
  .section-card {
    border: 1px solid #e9ecef;
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 2px 6px rgba(0,0,0,.05);
    margin-bottom: 1.5rem;
  }

  /* Table styles */
  .table {
    width: 100%;
    margin-bottom: 0;
  }
  .table th {
    width: 25%;
    background-color: #f8f9fa;
  }
  .table td, .table th {
    padding: 0.75rem;
    vertical-align: top;
    border: 1px solid #dee2e6;
  }

  /* Editor content */
  .editor-content {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    color: #333;
  }
</style>
@endpush