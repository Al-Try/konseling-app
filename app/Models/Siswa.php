<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table   = 'siswas';
    protected $guarded = [];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id'); // siswas.kelas_id
    }

    public function bimbingans()
    {
        return $this->hasMany(Bimbingan::class, 'siswa_id'); // bimbingans.siswa_id
    }
}
