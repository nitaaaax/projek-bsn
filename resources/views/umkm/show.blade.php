@extends('layout.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Detail UMKM - {{ $tahap->nama_pelaku }}</h4>
        </div>
        <div class="card-body">

            <dl class="row">
                {{-- Tahap 1: Data Pelaku Usaha --}}
                <dt class="col-sm-4">Nama Pelaku</dt>
                <dd class="col-sm-8">{{ $tahap->nama_pelaku }}</dd>

                <dt class="col-sm-4">Produk</dt>
                <dd class="col-sm-8">{{ $tahap->produk }}</dd>

                <dt class="col-sm-4">Klasifikasi</dt>
                <dd class="col-sm-8">{{ $tahap->klasifikasi }}</dd>

                <dt class="col-sm-4">Status</dt>
                <dd class="col-sm-8">{{ $tahap->status }}</dd>

                {{-- Tahap 2: Kontak & Pembina --}}
                @if ($tahap->tahap2)
                    <dt class="col-sm-4">Pembina II</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap2->pembina_2 }}</dd>

                    <dt class="col-sm-4">Sinergi</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap2->sinergi }}</dd>

                    <dt class="col-sm-4">Nama Kontak</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap2->nama_kontak_person }}</dd>

                    <dt class="col-sm-4">No HP</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap2->No_Hp }}</dd>

                    <dt class="col-sm-4">Bulan Pertama Pembinaan</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap2->bulan__pertama_pembinaan }}</dd>
                @endif

                {{-- Tahap 3: Riwayat Pembinaan --}}
                @if ($tahap->tahap3)
                    <dt class="col-sm-4">Tahun Dibina</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap3->tahun_dibina }}</dd>

                    <dt class="col-sm-4">Riwayat Pembinaan</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap3->riwayat_pembinaan }}</dd>

                    <dt class="col-sm-4">Gruping</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap3->gruping }}</dd>

                    <dt class="col-sm-4">Email</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap3->email }}</dd>

                    <dt class="col-sm-4">Media Sosial</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap3->media_sosial }}</dd>
                @endif

                {{-- Tahap 4: Alamat dan Legalitas --}}
                @if ($tahap->tahap4)
                    <dt class="col-sm-4">Alamat</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap4->alamat }}</dd>

                    <dt class="col-sm-4">Provinsi</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap4->provinsi }}</dd>

                    <dt class="col-sm-4">Kota</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap4->kota }}</dd>

                    <dt class="col-sm-4">Legalitas Usaha</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap4->legalitas_usaha }}</dd>

                    <dt class="col-sm-4">Tahun Pendirian</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap4->tahun_pendirian }}</dd>
                @endif

                {{-- Tahap 5: Produk & Sertifikasi --}}
                @if ($tahap->tahap5)
                    <dt class="col-sm-4">Jenis Usaha</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap5->jenis_usaha }}</dd>

                    <dt class="col-sm-4">Nama Merek</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap5->nama_merek }}</dd>

                    <dt class="col-sm-4">SNI</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap5->sni ? 'Ya' : 'Tidak' }}</dd>

                    <dt class="col-sm-4">LSPro</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap5->lspro }}</dd>
                @endif

                {{-- Tahap 6: Produksi --}}
                @if ($tahap->tahap6)
                    <dt class="col-sm-4">Omzet</dt>
                    <dd class="col-sm-8">Rp {{ number_format($tahap->tahap6->omzet, 0, ',', '.') }}</dd>

                    <dt class="col-sm-4">Volume Produksi per Tahun</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap6->volume_per_tahun }}</dd>

                    <dt class="col-sm-4">Jumlah Tenaga Kerja</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap6->jumlah_tenaga_kerja }}</dd>

                    <dt class="col-sm-4">Jangkauan Pemasaran</dt>
                    <dd class="col-sm-8">{{ $tahap->tahap6->jangkauan_pemasaran }}</dd>

                    <dt class="col-sm-4">Link Dokumen</dt>
                    <dd class="col-sm-8">
                        @if($tahap->tahap6->link_dokumen)
                            <a href="{{ $tahap->tahap6->link_dokumen }}" target="_blank">Lihat Dokumen</a>
                        @else
                            -
                        @endif
                    </dd>
                @endif
            </dl>

            {{-- Tombol Aksi --}}
            <div class="text-end mt-4">
                <a href="{{ route('tahap.create.tahap', ['tahap' => 1, 'id' => $tahap->id]) }}" class="btn btn-warning">
                    <i class="fa fa-edit"></i> Edit
                </a>
                <a href="{{ route('umkm.index') }}" class="btn btn-secondary">&larr; Kembali</a>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endpush
