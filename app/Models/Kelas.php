<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = ['nama_kelas','tingkat','jurusan','guru_wali_id'];

    public function guruWali() { return $this->belongsTo(GuruWali::class, 'guru_wali_id'); }
    public function siswas() { return $this->hasMany(Siswa::class, 'kelas_id'); }
}

