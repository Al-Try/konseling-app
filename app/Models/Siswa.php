<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    // ✅ relasi yang diminta
    public function bimbingans()
    {
        // pakai nama FK yang benar di tabel bimbingans kamu
        // umumnya 'siswa_id'
        return $this->hasMany(Bimbingan::class, 'siswa_id');
    }

    // (opsional) alias kalau ada kode lama memanggil singular
    public function bimbingan()
    {
        return $this->bimbingans();
    }
}
