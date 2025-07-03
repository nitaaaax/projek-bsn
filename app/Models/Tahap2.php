<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tahap2 extends Model
{
    protected $table = 'kontak';
    public $timestamps = false;

    protected $fillable = [
        'pelaku_usaha_id',
        'nama_kontak',
        'no_hp',
        'email',
        'media_sosial'
    ];

    public function pelaku(): BelongsTo
    {
        return $this->belongsTo(Tahap1::class, 'pelaku_usaha_id');
    }
}
