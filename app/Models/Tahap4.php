<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tahap4 extends Model
{
    protected $table = 'alamat';

    protected $fillable = [
        'pelaku_usaha_id',
        'alamat_kantor', 'provinsi_kantor', 'kota_kantor',
        'alamat_pabrik', 'provinsi_pabrik', 'kota_pabrik',
        'provinsi',
        'kota',
        'legalitas_usaha',
        'tahun_pendirian',
    ];

    public function tahap1(): BelongsTo
    {
        return $this->belongsTo(Tahap1::class, 'pelaku_usaha_id');
    }
}
