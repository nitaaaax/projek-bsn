<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tahap5 extends Model
{
    protected $table = 'riwayat_pembinaan_detail';
    public $timestamps = false;

    protected $fillable = [
        'pembinaan_id',
        'kegiatan',
        'gruping',
        'tanggal',
        'catatan'
    ];

    public function pembinaan(): BelongsTo
    {
        return $this->belongsTo(Tahap4::class, 'pembinaan_id');
    }
}
