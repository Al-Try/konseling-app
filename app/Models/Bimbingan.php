<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{
    use HasFactory;

    protected $fillable = ['guru_id', 'siswa_id', 'jenis_id', 'tanggal', 'jam', 'catatan', 'status', 'tindak_lanjut'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function guruWali()
    {
        return $this->belongsTo(GuruWali::class);
    }
}
