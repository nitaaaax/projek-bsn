<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spj extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_spj',
        'item',
        'nominal',
        'pembayaran',
        'keterangan',
    ];
}
