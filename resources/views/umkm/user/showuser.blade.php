@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h3 class="fw-bold mb-4 text-primary">
        <i class="fa fa-eye me-2"></i> Detail UMKM
    </h3>

    {{-- CARD 1: Data Tahap 1 --}}
    <div class="card shadow-sm mb-4 border-0 rounded-3">
        <div class="card-header bg-light text-dark border-bottom fw-bold">
            <i class="fas fa-user me-2 text-secondary"></i> Informasi Pelaku UMKM
        </div>

        <div class="card-body row g-3">
            {{-- Kolom Kiri --}}
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label text-muted">Nama Pelaku</label>
                    <div class="form-control-plaintext">{{ $tahap1->nama_pelaku ?? '-' }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Produk</label>
                    <div class="form-control-plaintext">{{ $tahap1->produk ?? '-' }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Klasifikasi</label>
                    <div class="form-control-plaintext">{{ $tahap1->klasifikasi ?? '-' }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Status</label>
                    <div class="form-control-plaintext">{{ $tahap1->status ?? '-' }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">No HP</label>
                    <div class="form-control-plaintext">{{ $tahap1->no_hp ?? '-' }}</div>
                </div>
            </div>

            {{-- Kolom Kanan --}}
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label text-muted">Email</label>
                    <div class="form-control-plaintext">{{ $tahap1->email ?? '-' }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Media Sosial</label>
                    <div class="form-control-plaintext">{{ $tahap1->media_sosial ?? '-' }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Jenis Usaha</label>
                    <div class="form-control-plaintext">{{ $tahap1->jenis_usaha ?? '-' }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Tanda Daftar Merek</label>
                    <div class="form-control-plaintext">{{ $tahap1->tanda_daftar_merk ?? '-' }}</div>
                </div>
            </div>

            {{-- Riwayat Pembinaan --}}
            <div class="col-12">
                <label class="form-label text-muted">Riwayat Pembinaan</label>
                <div class="form-control-plaintext">
                    @if(!empty($tahap1->riwayat_pembinaan))
                        {{ is_array($tahap1->riwayat_pembinaan) ? implode(', ', $tahap1->riwayat_pembinaan) : $tahap1->riwayat_pembinaan }}
                    @else
                        -
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- CARD 2: Data Tahap 2 --}}
    @if($tahap2)
    <div class="card shadow-sm mb-4 border-0 rounded-3">
        <div class="card-header bg-light text-dark border-bottom fw-bold">
            <i class="fas fa-industry me-2 text-secondary"></i> Detail Usaha & Produksi
        </div>

        <div class="card-body row g-3">
            {{-- Data Dasar --}}
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label text-muted">Omzet</label>
                    <div class="form-control-plaintext">Rp {{ number_format($tahap2->omzet ?? 0, 0, ',', '.') }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Volume per Tahun</label>
                    <div class="form-control-plaintext">{{ $tahap2->volume_per_tahun ?? '-' }} unit</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label text-muted">Jumlah Tenaga Kerja</label>
                    <div class="form-control-plaintext">{{ $tahap2->jumlah_tenaga_kerja ?? '-' }}</div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Skala Usaha</label>
                    <div class="form-control-plaintext">{{ $tahap2->skala_usaha ?? '-' }}</div>
                </div>
            </div>

            {{-- Legalitas --}}
            <div class="col-12">
                <label class="form-label text-muted">Legalitas Usaha</label>
                <div class="form-control-plaintext">
                    @if(!empty($tahap2->legalitas_usaha))
                        @if(is_array($tahap2->legalitas_usaha))
                            {{ implode(', ', $tahap2->legalitas_usaha) }}
                        @else
                            {{ $tahap2->legalitas_usaha }}
                        @endif
                    @else
                        -
                    @endif
                </div>
            </div>

            {{-- Sertifikat --}}
            <div class="col-12">
                <label class="form-label text-muted">Sertifikat yang Dimiliki</label>
                <div class="form-control-plaintext">
                    @if(!empty($tahap2->sertifikat))
                        @if(is_array($tahap2->sertifikat))
                            {{ implode(', ', $tahap2->sertifikat) }}
                        @else
                            {{ $tahap2->sertifikat }}
                        @endif
                    @else
                        -
                    @endif
                </div>
            </div>

            {{-- Foto Produk --}}
            <div class="col-12 mt-3">
                <label class="form-label text-muted">Foto Produk</label>
                <div class="row g-2">
                    @forelse((array) $tahap2->foto_produk as $foto)
                        <div class="col-6 col-md-3">
                            <img src="{{ asset('storage/' . $foto) }}" class="img-fluid rounded border" style="height: 150px; object-fit: cover;">
                        </div>
                    @empty
                        <div class="col-12 text-muted">Tidak ada foto produk</div>
                    @endforelse
                </div>
            </div>

            {{-- Foto Tempat Produksi --}}
            <div class="col-12 mt-3">
                <label class="form-label text-muted">Foto Tempat Produksi</label>
                <div class="row g-2">
                    @forelse((array) $tahap2->foto_tempat_produksi as $foto)
                        <div class="col-6 col-md-3">
                            <img src="{{ asset('storage/' . $foto) }}" class="img-fluid rounded border" style="height: 150px; object-fit: cover;">
                        </div>
                    @empty
                        <div class="col-12 text-muted">Tidak ada foto tempat produksi</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-warning">Belum ada data Tahap 2</div>
    @endif

    {{-- Tombol Kembali --}}
    <a href="{{ route('user.umkm.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left me-1"></i> Kembali
    </a>
</div>
@endsection