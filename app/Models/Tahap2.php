<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tahap2 extends Model
{
    protected $table = 'tahap2';

    protected $fillable = [
        'pelaku_usaha_id',
        'alamat_kantor', 'provinsi_kantor', 'kota_kantor',
        'alamat_pabrik', 'provinsi_pabrik', 'kota_pabrik',
        'legalitas_usaha', 'tahun_pendirian',
        'omzet', 'volume_per_tahun', 'jumlah_tenaga_kerja',
        'jangkauan_pemasaran', 'link_dokumen',
        'foto_produk', 'foto_tempat_produksi', 'sni_yang_diterapkan',
        'instansi', 'sertifikat', 'gruping',
    ];

    protected $casts = [
        'jangkauan_pemasaran' => 'array',
        'foto_produk' => 'array',
        'foto_tempat_produksi' => 'array',
        'instansi' => 'array',
    ];

    public function tahap1()
    {
        return $this->belongsTo(Tahap1::class, 'pelaku_usaha_id', 'id');
    }

    // Relasi wilayah
    public function provinsiKantor() { return $this->belongsTo(Provinsi::class, 'provinsi_kantor'); }
    public function kotaKantor()     { return $this->belongsTo(Kota::class, 'kota_kantor'); }
    public function provinsiPabrik() { return $this->belongsTo(Provinsi::class, 'provinsi_pabrik'); }
    public function kotaPabrik()     { return $this->belongsTo(Kota::class, 'kota_pabrik'); }
}
