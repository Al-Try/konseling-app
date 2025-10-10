<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    // TABEL: siswa (bukan siswas)
    protected $table = 'siswas';

    protected $fillable = [
        'nis','nama_siswa','kelas_id','jk'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function bimbingans()
    {
        return $this->hasMany(Bimbingan::class, 'siswa_id');
    }
}
