<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tahap3 extends Model
{
    protected $table = 'legalitas_usaha';
    public $timestamps = false;
    protected $primaryKey = 'pelaku_usaha_id';   // one‑to‑one

    public $incrementing = false;                // PK bukan AUTO_INCREMENT

    protected $fillable = [
        'pelaku_usaha_id',
        'jenis_usaha',
        'nama_merek',
        'legalitas',
        'tahun_pendirian',
        'sni'
    ];

    public function pelaku(): BelongsTo
    {
        return $this->belongsTo(Tahap1::class, 'pelaku_usaha_id');
    }
}
