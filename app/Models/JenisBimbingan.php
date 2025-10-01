<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBimbingan extends Model
{
    use HasFactory;

    protected $fillable = ['nama_jenis','tipe','poin']; // tipe: positif|negatif
    public function bimbingans() { return $this->hasMany(Bimbingan::class, 'jenis_id'); }
}

