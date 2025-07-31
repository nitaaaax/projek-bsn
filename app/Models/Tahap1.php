<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tahap1 extends Model
{
    protected $table = 'tahap1';

    protected $fillable = [
        'nama_pelaku', 'produk', 'klasifikasi', 'status', 'pembina_1', 'pembina_2','lspro',
        'sinergi', 'nama_kontak_person', 'no_hp', 'bulan_pertama_pembinaan', 'tahun_dibina',
        'riwayat_pembinaan', 'status_pembinaan', 'email', 'media_sosial', 'nama_merek','tanda_daftar_merk'
    ];

    protected $casts = [
    'riwayat_pembinaan' => 'array',
];

    public function tahap2(): HasOne
    {
        return $this->hasOne(Tahap2::class, 'pelaku_usaha_id');
    }
}

