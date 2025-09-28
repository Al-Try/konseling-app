<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisBimbingan extends Model
{
    protected $fillable = ['nama_jenis','deskripsi','poin'];

    public function bimbingans()
    {
        return $this->hasMany(Bimbingan::class, 'jenis_id');
    }
}
