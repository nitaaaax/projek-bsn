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
        'omzet_per_tahun',
        'volume_produksi',
        'tenaga_kerja',
        'jangkauan_pasar'
    ];

    public function pelaku(): BelongsTo
    {
        return $this->belongsTo(Tahap1::class, 'pelaku_usaha_id');
    }
}
