@extends('layout.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Detail UMKM - {{ $tahap->nama_pelaku }}</h4>
        </div>
        <div class="card-body">

            <dl class="row">
                {{-- Data Pelaku Usaha --}}
                <dt class="col-sm-4">Nama Pelaku</dt>
                <dd class="col-sm-8">{{ $tahap->nama_pelaku }}</dd>

                <dt class="col-sm-4">Produk</dt>
                <dd class="col-sm-8">{{ $tahap->produk }}</dd>

                <dt class="col-sm-4">Klasifikasi</dt>
                <dd class="col-sm-8">{{ $tahap->klasifikasi }}</dd>

                <dt class="col-sm-4">Status</dt>
                <dd class="col-sm-8">{{ $tahap->status }}</dd>

                <dt class="col-sm-4">Provinsi</dt>
                <dd class="col-sm-8">{{ $tahap->provinsi }}</dd>

                {{-- Kontak & Media --}}
                @if ($tahap->tahap2)
                    <dt class="col-sm-4">Nama Kontak</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap2->nama_kontak }}</dd>

                    <dt class="col-sm-4">Nomor HP</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap2->no_hp }}</dd>

                    <dt class="col-sm-4">Email</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap2->email }}</dd>

                    <dt class="col-sm-4">Media Sosial</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap2->media_sosial }}</dd>
                @endif

                {{-- Informasi Usaha --}}
                @if ($tahap->tahap3)
                    <dt class="col-sm-4">Jenis Usaha</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap3->jenis_usaha }}</dd>

                    <dt class="col-sm-4">Nama Merek</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap3->nama_merek }}</dd>

                    <dt class="col-sm-4">Legalitas</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap3->legalitas }}</dd>

                    <dt class="col-sm-4">Tahun Pendirian</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap3->tahun_pendirian }}</dd>

                    <dt class="col-sm-4">SNI</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap3->sni ? 'Ya' : 'Tidak' }}</dd>
                @endif

                {{-- Riwayat Pembinaan --}}
                @if ($tahap->tahap4)
                    <dt class="col-sm-4">Bulan Pertama Dibina</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap4->bulan_pertama }}</dd>

                    <dt class="col-sm-4">Tahun Pembinaan</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap4->tahun_bina }}</dd>

                    <dt class="col-sm-4">Kegiatan</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap4->kegiatan }}</dd>

                    <dt class="col-sm-4">Gruping</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap4->gruping }}</dd>
                @endif

                {{-- Detail Kegiatan --}}
                @if ($tahap->tahap5)
                    <dt class="col-sm-4">Kegiatan Terakhir</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap5->kegiatan }}</dd>

                    <dt class="col-sm-4">Gruping</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap5->gruping }}</dd>

                    <dt class="col-sm-4">Tanggal</dt>
                    <dd class="col-sm-8">{{ \Carbon\Carbon::parse($tahap->tahap5->tanggal)->translatedFormat('d F Y') }}</dd>

                    <dt class="col-sm-4">Catatan</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap5->catatan }}</dd>
                @endif

                {{-- Capaian Produksi --}}
                @if ($tahap->tahap6)
                    <dt class="col-sm-4">Omzet per Tahun</dt>
                    <dd class="col-sm-8">Rp {{ number_format($tahap->tahap6->omzet_per_tahun ?? 0, 0, ',', '.') }}</dd>

                    <dt class="col-sm-4">Volume Produksi</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap6->volume_produksi }}</dd>

                    <dt class="col-sm-4">Tenaga Kerja</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap6->tenaga_kerja }}</dd>

                    <dt class="col-sm-4">Jangkauan Pasar</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap6->jangkauan_pasar }}</dd>
                @endif
            </dl>

            <div class="text-end mt-4">
                <a href="{{ route('umkm.index') }}" class="btn btn-secondary">← Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
