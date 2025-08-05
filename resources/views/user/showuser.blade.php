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
            <tr><th>Nama Pelaku</th><td>{{ $tahap1->nama_pelaku }}</td></tr>
            <tr><th>Produk</th><td>{{ $tahap1->produk }}</td></tr>
            <tr><th>Klasifikasi</th><td>{{ $tahap1->klasifikasi }}</td></tr>
            <tr><th>Status</th><td>{{ $tahap1->status }}</td></tr>
            <tr><th>Pembina 1</th><td>{{ $tahap1->pembina_1 }}</td></tr>
            <tr><th>Pembina 2</th><td>{{ $tahap1->pembina_2 }}</td></tr>
            <tr><th>Nama Kontak Person</th><td>{{ $tahap1->nama_kontak_person }}</td></tr>
            <tr><th>No HP</th><td>{{ $tahap1->no_hp }}</td></tr>
            <tr><th>Email</th><td>{{ $tahap1->email }}</td></tr>
            <tr><th>Media Sosial</th><td>{{ $tahap1->media_sosial }}</td></tr>
            <tr><th>Nama Merek</th><td>{{ $tahap1->nama_merek }}</td></tr>
            <tr><th>Tahun Dibina</th><td>{{ $tahap1->tahun_dibina }}</td></tr>
            <tr><th>Bulan Pertama Pembinaan</th><td>{{ $tahap1->bulan_pertama_pembinaan }}</td></tr>
            <tr><th>Riwayat Pembinaan</th><td>{!! nl2br(e($tahap1->riwayat_pembinaan)) !!}</td></tr>
          </table>
        </div>

        {{-- === Tahap 2 === --}}
        <div class="col-md-6">
          <h5 class="text-info">Data Tahap 2</h5>
          @if($tahap2)
          <table class="table table-bordered">
            <tr><th>Omzet</th><td>{{ number_format($tahap2->omzet ?? 0, 0, ',', '.') }}</td></tr>
            <tr><th>Volume per Tahun</th><td>{{ $tahap2->volume_per_tahun }}</td></tr>
            <tr><th>Jumlah Tenaga Kerja</th><td>{{ $tahap2->jumlah_tenaga_kerja }}</td></tr>
            <tr>
              <th>Jangkauan Pemasaran</th>
              <td>
                @php
                  $jangkauan = is_array($tahap2->jangkauan_pemasaran ?? null)
                      ? $tahap2->jangkauan_pemasaran
                      : json_decode($tahap2->jangkauan_pemasaran ?? '[]', true);
                @endphp
                {{ implode(', ', $jangkauan) }}
              </td>
            </tr>
            <tr><th>Link Dokumen</th><td><a href="{{ $tahap2->link_dokumen }}" target="_blank">{{ $tahap2->link_dokumen }}</a></td></tr>
            <tr><th>Alamat Kantor</th><td>{{ $tahap2->alamat_kantor }}</td></tr>
            <tr><th>Alamat Pabrik</th><td>{{ $tahap2->alamat_pabrik }}</td></tr>
            <tr>
              <th>Instansi</th>
              <td>
                @php
                  $instansi = is_array($tahap2->instansi ?? null)
                      ? $tahap2->instansi
                      : json_decode($tahap2->instansi ?? '{}', true);
                @endphp
                <ul class="mb-0">
                  @foreach($instansi as $nama => $detail)
                    <li>{{ $nama }} - {{ $detail }}</li>
                  @endforeach
                </ul>
              </td>
            </tr>
            <tr><th>Legalitas Usaha</th><td>{{ $tahap2->legalitas_usaha }}</td></tr>
            <tr><th>Tahun Pendirian</th><td>{{ $tahap2->tahun_pendirian }}</td></tr>
            <tr><th>SNI Diterapkan</th><td>{{ $tahap2->sni_yang_diterapkan }}</td></tr>
            <tr><th>Sertifikat</th><td>{{ $tahap2->sertifikat }}</td></tr>
            <tr><th>Gruping</th><td>{{ $tahap2->gruping }}</td></tr>
            
            {{-- Foto Produk (pindah ke Tahap 2) --}}
            <tr>
              <th>Foto Produk</th>
              <td>
                @php
                  $foto_produk = is_array($tahap2->foto_produk ?? null)
                      ? $tahap2->foto_produk
                      : json_decode($tahap2->foto_produk ?? '[]', true);
                @endphp
                @foreach($foto_produk as $foto)
                  <img src="{{ asset('storage/' . $foto) }}" class="img-thumbnail m-1" width="120" alt="Foto Produk">
                @endforeach
              </td>
            </tr>

            {{-- Foto Tempat Produksi --}}
            <tr>
              <th>Foto Tempat Produksi</th>
              <td>
                @php
                  $foto_tempat = is_array($tahap2->foto_tempat_produksi ?? null)
                      ? $tahap2->foto_tempat_produksi
                      : json_decode($tahap2->foto_tempat_produksi ?? '[]', true);
                @endphp
                @foreach($foto_tempat as $foto)
                  <img src="{{ asset('storage/' . $foto) }}" class="img-thumbnail m-1" width="120" alt="Foto Tempat Produksi">
                @endforeach
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
