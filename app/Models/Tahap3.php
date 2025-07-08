<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tahap3 extends Model
{
    protected $table = 'pembinaan';
    public $timestamps = true;

    protected $fillable = [
        'pelaku_usaha_id',
        'bulan_pertama',
        'tahun_bina',
        'kegiatan',
        'gruping',
        'email',
        'media_sosial',
    ];
}
