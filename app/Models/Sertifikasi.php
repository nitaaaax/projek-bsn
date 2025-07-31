<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sertifikasi extends Model
{
    protected $table = 'sertifikasi';

   protected $fillable = [
    'pelaku_usaha_id',

    // Dari Tahap1
    'nama_pelaku', 'produk', 'klasifikasi', 'status', 'pembina_1', 'pembina_2',
    'sinergi', 'nama_kontak_person', 'no_hp', 'bulan_pertama_pembinaan',
    'tahun_dibina', 'riwayat_pembinaan', 'status_pembinaan', 'email',
    'media_sosial', 'nama_merek',

    // Dari Tahap2
    'omzet', 'volume_per_tahun', 'jumlah_tenaga_kerja', 'jangkauan_pemasaran',
    'link_dokumen', 'alamat_kantor', 'provinsi_kantor', 'kota_kantor',
    'alamat_pabrik', 'provinsi_pabrik', 'kota_pabrik', 'legalitas_usaha',
    'tahun_pendirian', 'foto_produk', 'foto_tempat_produksi', 'jenis_usaha',
    'sni_yang_akan_diterapkan', 'lspro', 'tanda_daftar_merek', 'instansi',
    'sertifikat',
];

protected $casts = [
    'jangkauan_pemasaran' => 'array',
    'foto_produk' => 'array',
    'foto_tempat_produksi' => 'array',
];

}
