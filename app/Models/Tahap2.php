<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tahap2 extends Model
{
    protected $table = 'pembinaan';

    protected $fillable = [
        'pelaku_usaha_id',
        'pembina_2',
        'sinergi',
        'nama_kontak_person',
        'No_Hp',
        'bulan__pertama_pembinaan',
    ];



    public function tahap1(): BelongsTo
    {
        return $this->belongsTo(Tahap1::class, 'pelaku_usaha_id');
    }
}
