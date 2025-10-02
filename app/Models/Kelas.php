<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    // TABEL: kelas (bukan kelases)
    protected $table = 'kelas';

    protected $fillable = ['nama_kelas','tingkat']; // tambah 'guru_wali_id' bila ada kolom itu

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }
}
