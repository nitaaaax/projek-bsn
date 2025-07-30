<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Relasi ke model User
     * Setiap role bisa memiliki banyak user
     */
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
