<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tahap1 extends Model
{
    protected $table = 'pelaku_usaha';

    protected $fillable = [
        'nama_pelaku',
        'produk',
        'klasifikasi',
        'status',
        'provinsi',
    ];

    public function tahap2(): HasOne
    {
        return $this->hasOne(Tahap2::class, 'pelaku_usaha_id');
    }

    public function tahap3(): HasOne
    {
        return $this->hasOne(Tahap3::class, 'pelaku_usaha_id');
    }

    public function tahap4(): HasOne
    {
        return $this->hasOne(LegalitasUsaha::class, 'pelaku_usaha_id');
    }

    public function tahap5(): HasOne
    {
        return $this->hasOne(Tahap5::class, 'pelaku_usaha_id');
    }

    public function tahap6(): HasOne
    {
        return $this->hasOne(Tahap6::class, 'pelaku_usaha_id');
    }
}
