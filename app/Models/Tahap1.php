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
        'pembina_1',
    ];

    // Relasi ke Tahap 2 (tabel: kontak)
    public function tahap2(): HasOne
    {
        return $this->hasOne(Tahap2::class, 'pelaku_usaha_id');
    }

    // Relasi ke Tahap 3 (tabel: pembinaan)
    public function tahap3(): HasOne
    {
        return $this->hasOne(Tahap3::class, 'pelaku_usaha_id');
    }

    // Relasi ke Tahap 4 (tabel: alamat, model: LegalitasUsaha)
    public function tahap4(): HasOne
    {
        return $this->hasOne(Tahap4::class, 'pelaku_usaha_id');
    }

    // Relasi ke Tahap 5 (tabel: usaha)
    public function tahap5(): HasOne
    {
        return $this->hasOne(Tahap5::class, 'pelaku_usaha_id');
    }

    // Relasi ke Tahap 6 (tabel: produksi)
    public function tahap6(): HasOne
    {
        return $this->hasOne(Tahap6::class, 'pelaku_usaha_id');
    }
}
