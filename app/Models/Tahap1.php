<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tahap1 extends Model
{
    protected $table = 'pelaku_usaha';
    public $timestamps = false;

    protected $fillable = [
        'nama_pelaku',
        'produk',
        'klasifikasi',
        'status',
        'provinsi'
    ];

    /*---- Relasi ----*/
    public function kontak(): HasMany
    {
        return $this->hasMany(Tahap2::class, 'pelaku_usaha_id');
    }

    public function legalitas(): HasOne
    {
        return $this->hasOne(Tahap3::class, 'pelaku_usaha_id');
    }

    public function pembinaan(): HasMany
    {
        return $this->hasMany(Tahap4::class, 'pelaku_usaha_id');
    }

    public function produksi(): HasMany
    {
        return $this->hasMany(Tahap6::class, 'pelaku_usaha_id');
    }
}
