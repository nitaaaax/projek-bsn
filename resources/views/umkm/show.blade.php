@extends('layout.app')

@section('content')
<div class="container mt-4">

    <h3 class="mb-4 text-primary">Detail UMKM - {{ $tahap->nama_pelaku }}</h3>

    {{-- Tahap 1 --}}
    <div class="card mb-3">
        <div class="card-header bg-info text-white"> Data Pelaku Usaha</div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">Nama Pelaku:</dt>
                <dd class="col-sm-8">{{ $tahap->nama_pelaku }}</dd>
                <dt class="col-sm-4">Produk:</dt>
                <dd class="col-sm-8">{{ $tahap->produk }}</dd>
                <dt class="col-sm-4">Klasifikasi:</dt>
                <dd class="col-sm-8">{{ $tahap->klasifikasi }}</dd>
                <dt class="col-sm-4">Status:</dt>
                <dd class="col-sm-8">{{ $tahap->status }}</dd>
            </dl>
        </div>
    </div>

    {{-- Tahap 2 --}}
    @if ($tahap->tahap2)
    @php
        $bulanMap = [1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'];
        $angkaBulan = (int) $tahap->tahap2->bulan_pertama_pembinaan;
    @endphp
    <div class="card mb-3">
        <div class="card-header bg-success text-white"> Kontak & Pembina</div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">Pembina II</dt>
                <dd class="col-sm-8">{{ $tahap->tahap2->pembina_2 }}</dd>
                <dt class="col-sm-4">Sinergi:</dt>
                <dd class="col-sm-8">{{ $tahap->tahap2->sinergi }}</dd>
                <dt class="col-sm-4">Nama Kontak:</dt>
                <dd class="col-sm-8">{{ $tahap->tahap2->nama_kontak_person }}</dd>
                <dt class="col-sm-4">No HP:</dt>
                <dd class="col-sm-8">{{ $tahap->tahap2->No_Hp }}</dd>
                <dt class="col-sm-4">Bulan Pertama Pembinaan:</dt>
                <dd class="col-sm-8">{{ $bulanMap[$angkaBulan] ?? '-' }}</dd>
            </dl>
        </div>
    </div>
    @endif

    {{-- Tahap 3 --}}
    @if ($tahap->tahap3)
    <div class="card mb-3">
        <div class="card-header bg-warning text-dark">Riwayat Pembinaan</div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">Tahun Dibina:</dt>
                <dd class="col-sm-8">{{ $tahap->tahap3->tahun_dibina }}</dd>
                <dt class="col-sm-4">Riwayat Pembinaan:</dt>
                <dd class="col-sm-8">{{ $tahap->tahap3->riwayat_pembinaan }}</dd>
                <dt class="col-sm-4">Status Pembinaan:</dt>
                <dd class="col-sm-8">{{ $tahap->tahap3->status_pembinaan }}</dd>
                <dt class="col-sm-4">Email:</dt>
                <dd class="col-sm-8">{{ $tahap->tahap3->email }}</dd>
                <dt class="col-sm-4">Media Sosial:</dt>
                <dd class="col-sm-8">{{ $tahap->tahap3->media_sosial }}</dd>
            </dl>
        </div>
    </div>
    @endif

    {{-- Tahap 4 --}}
    @if ($tahap->tahap4)
    <div class="card mb-3">
        <div class="card-header bg-danger text-white">Alamat dan Legalitas</div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">Alamat:</dt>
                <dd class="col-sm-8">{{ $tahap->tahap4->alamat }}</dd>
                <dt class="col-sm-4">Provinsi:</dt>
                <dd class="col-sm-8">{{ $tahap->tahap4->provinsi }}</dd>
                <dt class="col-sm-4">Kota:</dt>
                <dd class="col-sm-8">{{ $tahap->tahap4->kota }}</dd>
                <dt class="col-sm-4">Legalitas Usaha:</dt>
                <dd class="col-sm-8">{{ $tahap->tahap4->legalitas_usaha }}</dd>
                <dt class="col-sm-4">Tahun Pendirian:</dt>
                <dd class="col-sm-8">{{ $tahap->tahap4->tahun_pendirian }}</dd>
            </dl>
        </div>
    </div>
    @endif

    {{-- Tahap 5 --}}
    @if ($tahap->tahap5)
    <div class="card mb-3">
        <div class="card-header bg-secondary text-white"> Produk & Sertifikasi</div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">Jenis Usaha:</dt>
                <dd class="col-sm-8">{{ $tahap->tahap5->jenis_usaha }}</dd>
                <dt class="col-sm-4">Nama Merek:</dt>
                <dd class="col-sm-8">{{ $tahap->tahap5->nama_merek }}</dd>
                <dt class="col-sm-4">SNI:</dt>
                <dd class="col-sm-8">{{ $tahap->tahap5->sni ? 'Ya' : 'Tidak' }}</dd>
                <dt class="col-sm-4">LSPro:</dt>
                <dd class="col-sm-8">{{ $tahap->tahap5->lspro }}</dd>
            </dl>
        </div>
    </div>
    @endif

    {{-- Tahap 6 --}}
    @if ($tahap->tahap6)
    <div class="card mb-3">
        <div class="card-header bg-dark text-white"> Produksi</div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">Omzet:</dt>
                <dd class="col-sm-8">Rp {{ number_format($tahap->tahap6->omzet, 0, ',', '.') }}</dd>
                <dt class="col-sm-4">Volume Produksi per Tahun:</dt>
                <dd class="col-sm-8">{{ $tahap->tahap6->volume_per_tahun }}</dd>
                <dt class="col-sm-4">Jumlah Tenaga Kerja:</dt>
                <dd class="col-sm-8">{{ $tahap->tahap6->jumlah_tenaga_kerja }}</dd>
                <dt class="col-sm-4">Jangkauan Pemasaran:</dt>
                <dd class="col-sm-8">{{ $tahap->tahap6->jangkauan_pemasaran }}</dd>
                <dt class="col-sm-4">Link Dokumen:</dt>
                <dd class="col-sm-8">
                    @if($tahap->tahap6->link_dokumen)
                        <a href="{{ $tahap->tahap6->link_dokumen }}" target="_blank">Lihat Dokumen:</a>
                    @else
                        -
                    @endif
                </dd>
            </dl>
        </div>
    </div>
    @endif

    {{-- Tombol Aksi --}}
    <div class="text-end mt-4">
        <a href="{{ route('tahap.create.tahap', ['tahap' => 1, 'id' => $tahap->id]) }}" class="btn btn-warning">
            <i class="fa fa-edit"></i> Edit
        </a>
        <a href="{{ route('umkm.proses.index') }}" class="btn btn-secondary">&larr; Kembali</a>
    </div>

</div>
@endsection
