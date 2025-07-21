<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tahap6 extends Model
{
    protected $table = 'produksi';

     public $timestamps = false;

    protected $fillable = [
        'pelaku_usaha_id',
        'omzet',
        'volume_per_tahun',
        'jumlah_tenaga_kerja',
        'jangkauan_pemasaran',
        'link_dokumen',
        'foto_produk',
        'foto_tempat_produksi',
    ];

    public function tahap1(): BelongsTo
    {
        return $this->belongsTo(Tahap1::class, 'pelaku_usaha_id');
    }
}
