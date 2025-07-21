@extends('layout.app')

@section('content')
<style>
.card {
    background-color: #f0f4f8;
    border: 1px solid #dce3ea;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    height: 100%;
}
.card-header {
    background-color: #e4edf5;
    font-weight: 600;
    font-size: 15px;
    color: #333;
    border-bottom: 1px solid #dce3ea;
    display: flex;
    align-items: center;
}
.card-header i {
    margin-right: 8px;
    color: #6c757d;
}
</style>

<div class="container mt-4">
    <h3 class="mb-4 text-primary">Detail UMKM - {{ $tahap->nama_pelaku }}</h3>
    

    <form action="{{ route('umkm.update', $tahap->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-header"><i class="fa fa-user-circle"></i> Data Pelaku Usaha</div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">Nama Pelaku:</dt>
                            <dd class="col-sm-8"><input type="text" name="nama_pelaku" class="form-control" value="{{ $tahap->nama_pelaku }}"></dd>
                            <dt class="col-sm-4">Produk:</dt>
                            <dd class="col-sm-8"><input type="text" name="produk" class="form-control" value="{{ $tahap->produk }}"></dd>
                            <dt class="col-sm-4">Klasifikasi:</dt>
                            <dd class="col-sm-8"><input type="text" name="klasifikasi" class="form-control" value="{{ $tahap->klasifikasi }}"></dd>
                            <dt class="col-sm-4">Status:</dt>
<dd class="col-sm-8">
    <select name="status" class="form-control">
        <option value="">-- Pilih Status --</option>
        <option value="Masih Dibina" {{ $tahap->status == 'Masih Dibina' ? 'selected' : '' }}>Masih Dibina</option>
        <option value="Drop/Tidak Dilanjutkan" {{ $tahap->status == 'Drop/Tidak Dilanjutkan' ? 'selected' : '' }}>Drop/Tidak Dilanjutkan</option>
    </select>
</dd>

                        </dl>
                    </div>
                </div>
            </div>

            @if ($tahap->tahap2)
            @php
                $bulanMap = [1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'];
                $angkaBulan = (int) $tahap->tahap2->bulan_pertama_pembinaan;
            @endphp
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-header"><i class="fa fa-phone"></i> Kontak & Pembina</div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">Pembina II:</dt>
                            <dd class="col-sm-8"><input type="text" name="pembina_2" class="form-control" value="{{ $tahap->tahap2->pembina_2 }}"></dd>
                            <dt class="col-sm-4">Sinergi:</dt>
                            <dd class="col-sm-8"><input type="text" name="sinergi" class="form-control" value="{{ $tahap->tahap2->sinergi }}"></dd>
                            <dt class="col-sm-4">Nama Kontak:</dt>
                            <dd class="col-sm-8"><input type="text" name="nama_kontak_person" class="form-control" value="{{ $tahap->tahap2->nama_kontak_person }}"></dd>
                            <dt class="col-sm-4">No HP:</dt>
                            <dd class="col-sm-8"><input type="text" name="no_hp" class="form-control" value="{{ $tahap->tahap2->no_hp }}"></dd>
                            <dt class="col-sm-4">Bulan Pertama Pembinaan:</dt>
                            <dd class="col-sm-8">
                                <select name="bulan_pertama_pembinaan" class="form-control">
                                    @foreach ($bulanMap as $key => $val)
                                        <option value="{{ $key }}" @if($key == $angkaBulan) selected @endif>{{ $val }}</option>
                                    @endforeach
                                </select>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            @endif

            @if ($tahap->tahap3)
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-header"><i class="fa fa-history"></i> Riwayat Pembinaan</div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">Tahun Dibina:</dt>
                            <dd class="col-sm-8"><input type="text" name="tahun_dibina" class="form-control" value="{{ $tahap->tahap3->tahun_dibina }}"></dd>
                            <dt class="col-sm-4">Riwayat Pembinaan:</dt>
                            <dd class="col-sm-8"><input type="text" name="riwayat_pembinaan" class="form-control" value="{{ $tahap->tahap3->riwayat_pembinaan }}"></dd>
                           <dt class="col-sm-4">Status Pembinaan:</dt>
                            <dd class="col-sm-8">
                                <select name="status_pembinaan" class="form-control">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Identifikasi awal dan Gap" {{ $tahap->tahap3->status_pembinaan == 'Identifikasi awal dan Gap' ? 'selected' : '' }}>Identifikasi awal dan Gap</option>
                                    <option value="Set up Sistem" {{ $tahap->tahap3->status_pembinaan == 'Set up Sistem' ? 'selected' : '' }}>Set up Sistem</option>
                                    <option value="Implementasi" {{ $tahap->tahap3->status_pembinaan == 'Implementasi' ? 'selected' : '' }}>Implementasi</option>
                                    <option value="Review Sistem & Audit Internal" {{ $tahap->tahap3->status_pembinaan == 'Review Sistem & Audit Internal' ? 'selected' : '' }}>Review Sistem & Audit Internal</option>
                                    <option value="Pengajuan Sertifikasi" {{ $tahap->tahap3->status_pembinaan == 'Pengajuan Sertifikasi' ? 'selected' : '' }}>Pengajuan Sertifikasi</option>
                                    <option value="Perbaikan Temuan Audit" {{ $tahap->tahap3->status_pembinaan == 'Perbaikan Temuan Audit' ? 'selected' : '' }}>Perbaikan Temuan Audit</option>
                                    <option value="Perbaikan Lokasi" {{ $tahap->tahap3->status_pembinaan == 'Perbaikan Lokasi' ? 'selected' : '' }}>Perbaikan Lokasi</option>
                                    <option value="SPPT SNI"
                                        style="font-weight:bold; color:green;"
                                        {{ $tahap->tahap3->status_pembinaan == 'SPPT SNI' ? 'selected' : '' }}>
                                        SPPT SNI (Tersertifikasi)
                                    </option>
                                </select>
                            </dd>

                            <dt class="col-sm-4">Email:</dt>
                            <dd class="col-sm-8"><input type="email" name="email" class="form-control" value="{{ $tahap->tahap3->email }}"></dd>
                            <dt class="col-sm-4">Media Sosial:</dt>
                            <dd class="col-sm-8"><input type="text" name="media_sosial" class="form-control" value="{{ $tahap->tahap3->media_sosial }}"></dd>
                        </dl>
                    </div>
                </div>
            </div>
            @endif

            @if ($tahap->tahap4)
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-header"><i class="fa fa-map-marker-alt"></i> Alamat dan Legalitas</div>
                    <div class="card-body">
                        <dl class="row">
                            {{-- Alamat Kantor --}}
                            <dt class="col-sm-4">Alamat Kantor</dt>
                            <dd class="col-sm-8">
                                <input type="text" name="alamat_kantor" class="form-control" value="{{ $tahap->tahap4->alamat_kantor ?? '' }}">
                            </dd>

                            <dt class="col-sm-4">Provinsi Kantor</dt>
                            <dd class="col-sm-8">
                                <input type="text" name="provinsi_kantor" class="form-control" value="{{ $tahap->tahap4->provinsi_kantor ?? '' }}">
                            </dd>

                            <dt class="col-sm-4">Kota/Kabupaten Kantor</dt>
                            <dd class="col-sm-8">
                                <input type="text" name="kota_kantor" class="form-control" value="{{ $tahap->tahap4->kota_kantor ?? '' }}">
                            </dd>

                            {{-- Alamat Pabrik --}}
                            <dt class="col-sm-4">Alamat Pabrik / Plant</dt>
                            <dd class="col-sm-8">
                                <input type="text" name="alamat_pabrik" class="form-control" value="{{ $tahap->tahap4->alamat_pabrik ?? '' }}">
                            </dd>

                            <dt class="col-sm-4">Provinsi Pabrik</dt>
                            <dd class="col-sm-8">
                                <input type="text" name="provinsi_pabrik" class="form-control" value="{{ $tahap->tahap4->provinsi_pabrik ?? '' }}">
                            </dd>

                            <dt class="col-sm-4">Kota/Kabupaten Pabrik</dt>
                            <dd class="col-sm-8">
                                <input type="text" name="kota_pabrik" class="form-control" value="{{ $tahap->tahap4->kota_pabrik ?? '' }}">
                            </dd>
                            </dl>

                            <dt class="col-sm-4">Legalitas Usaha:</dt>
                            <dd class="col-sm-8"><input type="text" name="legalitas_usaha" class="form-control" value="{{ $tahap->tahap4->legalitas_usaha }}"></dd>
                            <dt class="col-sm-4">Tahun Pendirian:</dt>
                            <dd class="col-sm-8"><input type="text" name="tahun_pendirian" class="form-control" value="{{ $tahap->tahap4->tahun_pendirian }}"></dd>
                        </dl>
                    </div>
                </div>
            </div>
            @endif

            @if ($tahap->tahap5)
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-header"><i class="fa fa-box"></i> Produk & Sertifikasi</div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">Jenis Usaha:</dt>
                            <dd class="col-sm-8"><input type="text" name="jenis_usaha" class="form-control" value="{{ $tahap->tahap5->jenis_usaha }}"></dd>
                            <dt class="col-sm-4">Nama Merek:</dt>
                            <dd class="col-sm-8"><input type="text" name="nama_merek" class="form-control" value="{{ $tahap->tahap5->nama_merek }}"></dd>
                            <dt class="col-sm-4">SNI:</dt>
                            <dd class="col-sm-8">
                                <select name="sni" class="form-control">
                                    <option value="1" @if($tahap->tahap5->sni) selected @endif>Ya</option>
                                    <option value="0" @if(!$tahap->tahap5->sni) selected @endif>Tidak</option>
                                </select>
                            </dd>
                            <dt class="col-sm-4">LSPro:</dt>
                            <dd class="col-sm-8"><input type="text" name="lspro" class="form-control" value="{{ $tahap->tahap5->lspro }}"></dd>
                            <dt class="col-sm-4">Tanda Daftar Merk:</dt>
                            <dd class="col-sm-8">
                                <select name="tanda_daftar_merk" class="form-control">
                                    <option value="1" @if($tahap->tahap5->tanda_daftar_merk) selected @endif>Terdaftar di Kemenkumham</option>
                                    <option value="0" @if(!$tahap->tahap5->tanda_daftar_merk) selected @endif>Belum Terdaftar</option>
                                </select>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            @endif

            @if ($tahap->tahap6)
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-header"><i class="fa fa-industry"></i> Produksi</div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">Omzet:</dt>
                            <dd class="col-sm-8"><input type="number" name="omzet" class="form-control" value="{{ $tahap->tahap6->omzet }}"></dd>
                            <dt class="col-sm-4">Volume Produksi per Tahun:</dt>
                            <dd class="col-sm-8"><input type="text" name="volume_per_tahun" class="form-control" value="{{ $tahap->tahap6->volume_per_tahun }}"></dd>
                            <dt class="col-sm-4">Jumlah Tenaga Kerja:</dt>
                            <dd class="col-sm-8"><input type="number" name="jumlah_tenaga_kerja" class="form-control" value="{{ $tahap->tahap6->jumlah_tenaga_kerja }}"></dd>
                            <dt class="col-sm-4">Jangkauan Pemasaran:</dt>
                            <dd class="col-sm-8"><input type="text" name="jangkauan_pemasaran" class="form-control" value="{{ $tahap->tahap6->jangkauan_pemasaran }}"></dd>
                            <dt class="col-sm-4">Link Dokumen:</dt>
                            <dd class="col-sm-8"><input type="url" name="link_dokumen" class="form-control" value="{{ $tahap->tahap6->link_dokumen }}"></dd>
                           <!-- Gambar Produk -->
                            <dt class="col-sm-4">Gambar Produk</dt>
                            <dd class="col-sm-8">
                           <div class="mb-3">
                                <input type="file" name="gambar_produk[]" id="gambar_produk" class="form-control" multiple>
                            <div id="preview_gambar_produk" class="d-flex flex-wrap mt-2"></div>
                            </div>
                            </dd>
                            <!-- Gambar Tempat Produksi -->
                            <dt class="col-sm-4">Tempat Produksi</dt>
                            <dd class="col-sm-8">
                               <div class="mb-3">
                                    <input type="file" name="gambar_tempat_produksi[]" id="gambar_tempat_produksi" class="form-control" multiple>
                                    <div id="preview_gambar_tempat_produksi" class="d-flex flex-wrap mt-2"></div>
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="text-end mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> Simpan Data
            </button>
            <a href="{{ route('umkm.proses.index') }}" class="btn btn-secondary">&larr; Kembali</a>
        </div>
    </form>
    </div>



</div>
@endsection

@push('scripts')
<style>
  .img-preview-wrapper {
    position: relative;
    display: inline-block;
    margin: 10px;
  }

  .img-preview-wrapper img {
    max-width: 200px;
    border-radius: 5px;
  }

  .remove-img {
    position: absolute;
    top: -8px;
    right: -8px;
    background: red;
    color: white;
    border: none;
    border-radius: 50%;
    font-size: 18px;
    width: 28px;
    height: 28px;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 10;
    transition: 0.2s;
  }

  .remove-img:hover {
    transform: scale(1.1);
    background-color: darkred;
  }
</style>

<script>
  const inputProduk = document.getElementById('gambar_produk');
  const previewProduk = document.getElementById('preview_gambar_produk');
  let fileListProduk = new DataTransfer(); // simpan file yang aktif

  inputProduk.addEventListener('change', (e) => {
    const files = Array.from(e.target.files);

    files.forEach((file) => {
      const reader = new FileReader();
      reader.onload = (event) => {
        const wrapper = document.createElement('div');
        wrapper.classList.add('img-preview');

        const image = document.createElement('img');
        image.src = event.target.result;

        const btn = document.createElement('button');
        btn.innerHTML = '&times;';
        btn.classList.add('remove-img');

        btn.addEventListener('click', () => {
          // Hapus dari preview
          previewProduk.removeChild(wrapper);
          // Filter file dari fileListProduk
          fileListProduk.items.clear(); // reset dulu
          const newFiles = Array.from(inputProduk.files).filter(f => f !== file);
          newFiles.forEach(f => fileListProduk.items.add(f));
          inputProduk.files = fileListProduk.files;
        });

        wrapper.appendChild(image);
        wrapper.appendChild(btn);
        previewProduk.appendChild(wrapper);
      };
      reader.readAsDataURL(file);
      fileListProduk.items.add(file); // simpan file ke dalam fileListProduk
    });

    inputProduk.files = fileListProduk.files;
    inputProduk.value = ''; // clear agar bisa pilih file sama lagi
  });
</script>

@endpush



{{-- <img src="{{ asset('storage/uploads/foto_produk/' . $gambar) }}" width="120" class="img-thumbnail"> --}}
