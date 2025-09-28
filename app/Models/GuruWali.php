<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class GuruWali extends Authenticatable
{
    protected $fillable = [
        'nama',
        'nip',
        'email',
        'password'
    ];

    // Relasi ke kelas (satu guru wali punya satu kelas)
    public function kelas()
    {
        return $this->hasOne(Kelas::class, 'wali_id');
    }

    // Relasi ke bimbingan (satu guru wali bisa punya banyak bimbingan)
    public function bimbingans()
    {
        return $this->hasMany(Bimbingan::class, 'guru_id');
    }
}
