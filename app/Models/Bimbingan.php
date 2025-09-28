<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{
    protected $fillable = [
        'siswa_id',
        'guru_id',
        'jenis_id',
        'deskripsi',
        'tanggal',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function guruWali()
    {
        return $this->belongsTo(GuruWali::class, 'guru_id');
    }

    public function jenisBimbingan()
    {
        return $this->belongsTo(JenisBimbingan::class, 'jenis_id');
    }
}
