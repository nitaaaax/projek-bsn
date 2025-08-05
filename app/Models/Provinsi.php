<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;

    protected $table = 'provinsis'; 

    protected $fillable = ['nama'];

    // Relasi ke kota
    public function kotas()
    {
        return $this->hasMany(Kota::class);
    }
}
