<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tahap4 extends Model
{
    protected $table = 'pembinaan';
    public $timestamps = false;

    protected $fillable = [
        'pelaku_usaha_id',
        'bulan_pertama',
        'tahun_bina',
        'kegiatan',
        'gruping'
    ];

    public function pelaku(): BelongsTo
    {
        return $this->belongsTo(Tahap1::class, 'pelaku_usaha_id');
    }

    public function detail(): HasMany
    {
        return $this->hasMany(Tahap5::class, 'pembinaan_id');
    }
}
