<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{
    use HasFactory;

    protected $fillable = ['guru_id','siswa_id','jenis_id','tanggal','jam','catatan','poin'];
    protected $casts = ['tanggal' => 'date','jam' => 'datetime:H:i:s'];

    public function guruWali() { return $this->belongsTo(GuruWali::class, 'guru_id'); }
    public function siswa()    { return $this->belongsTo(Siswa::class, 'siswa_id'); }
    public function jenis()    { return $this->belongsTo(JenisBimbingan::class, 'jenis_id'); }
}
