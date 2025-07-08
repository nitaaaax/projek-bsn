<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalitasUsaha extends Model
{
    protected $table = 'legalitas_usaha';

    protected $fillable = [
        'pelaku_usaha_id',
        'jenis_usaha',
        'nama_merek',
        'legalitas',
        'tahun_pendirian',
        'sni'
    ];
}
