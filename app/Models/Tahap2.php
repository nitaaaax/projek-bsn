<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tahap2 extends Model
{
    protected $table = 'kontak';

    protected $fillable = [
        'pelaku_usaha_id',
        'pembina_2',
        'sinergi',
        'nama_kontak_person',
        'no_hp',
        'bulan_pertama_pembinaan',
    ];



    public function tahap1(): BelongsTo
    {
        return $this->belongsTo(Tahap1::class, 'pelaku_usaha_id');
    }
}
