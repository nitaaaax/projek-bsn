<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpjDetail extends Model
{
    use HasFactory;

    protected $table = 'spj_details'; 
    protected $fillable = [
        'spj_id',
        'item',
        'nominal',
        'status_pembayaran',
        'keterangan',
    ];

    public function spj()
    {
        return $this->belongsTo(Spj::class);
    }
}
