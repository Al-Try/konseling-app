<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBimbingan extends Model
{
    use HasFactory;

    // Default sudah benar: jenis_bimbingans
    protected $fillable = ['kode','nama_jenis','poin'];

    public function bimbingans()
    {
        return $this->hasMany(Bimbingan::class, 'jenis_id');
    }
}
