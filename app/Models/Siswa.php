<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = ['nis','nama_siswa','kelas_id','jk','alamat','no_hp','orang_tua'];

    
    public function kelas(){ return $this->belongsTo(\App\Models\Kelas::class,'kelas_id'); }
    public function bimbingans() { return $this->hasMany(Bimbingan::class, 'siswa_id'); }
}

