<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tahap5 extends Model
{
    protected $table = 'usaha';

    protected $fillable = [
        'pelaku_usaha_id',
        'jenis_usaha',
        'nama_merek',
        'sni',
        'lspro',
        'tanda_daftar_merk'
    ];

    public function tahap1(): BelongsTo
    {
        return $this->belongsTo(Tahap1::class, 'pelaku_usaha_id');
    }
}
