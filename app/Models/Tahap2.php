<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
    