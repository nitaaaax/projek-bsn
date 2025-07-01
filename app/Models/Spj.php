<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spj extends Model
{
    protected $table = 'spj';
    protected $fillable = ['nama_spj', 'pembayaran', 'keterangan'];

    public function details()
    {
     return $this->hasMany(SpjDetail::class, 'spj_id');
    }

}

// app/Models/SpjDetail.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpjDetail extends Model
{
    protected $table = 'spj_detail';
    protected $fillable = ['spj_id', 'item', 'nominal'];

    public function spj()
    {
        return $this->belongsTo(Spj::class);
    }
}

