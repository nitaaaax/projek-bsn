<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tahap3 extends Model
{
    protected $table = 'riwayat';

    protected $fillable = [
        'pelaku_usaha_id',
        'tahun_dibina',
        'riwayat_pembinaan',
        'status_pembinaan',
        'email',
        'media_sosial',
    ];

    public function pelaku_usaha(): BelongsTo
    {
        return $this->belongsTo(Tahap1::class, 'pelaku_usaha_id');
    }
}
