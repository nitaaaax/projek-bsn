<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spj extends Model
{
    protected $fillable = ['nama_spj'];

    public function details()
{
    return $this->hasMany(SpjDetail::class, 'spj_id'); // sesuaikan jika nama foreign key berbeda
}

}
