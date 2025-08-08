<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spj extends Model
{
    protected $table = 'spjs'; 
    protected $fillable = ['nama_spj', 'no_ukd', 'keterangan', 'dokumen', 'lembaga_sertifikasi'];

    public function details()
    {
        return $this->hasMany(SpjDetail::class, 'spj_id');
    }
}
