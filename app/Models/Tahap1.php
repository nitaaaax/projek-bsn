<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tahap1 extends Model
{
    protected $table = 'pelaku_usaha';          // ganti jika tabelmu bernama lain
    protected $fillable = [
        'nama_pelaku',
        'produk',
        'klasifikasi',
        'status',
        'provinsi',
    ];

    /* ---------- RELASI ---------- */
    public function tahap2()
    {
        return $this->hasOne(Tahap2::class, 'pelaku_usaha_id');
    }

    public function tahap3()
    {
        return $this->hasOne(Tahap3::class, 'pelaku_usaha_id');
    }

    public function tahap4()
    {
        return $this->hasOne(Tahap4::class, 'pelaku_usaha_id');
    }

    public function tahap5()
    {
        // Tahap5 pakai FK pembinaan_id → ambil relasi via tahap4
        return $this->hasOneThrough(
            Tahap5::class,   // model target
            Tahap4::class,   // model perantara
            'pelaku_usaha_id', // FK di Tahap4
            'pembinaan_id',    // FK di Tahap5
            'id',              // PK di Tahap1
            'id'               // PK di Tahap4
        );
    }

    public function tahap6()
    {
        return $this->hasOne(Tahap6::class, 'pelaku_usaha_id');
    }
}
