<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruWali extends Model
{
    use HasFactory;

    // TABEL: guru_wali (bukan guru_walis)
    protected $table = 'guru_wali';

    // KITA STANDARKAN: nama kolom identitas adalah 'nama_guru'
    protected $fillable = ['user_id','nip','nama_guru','no_hp','alamat'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bimbingans()
    {
        return $this->hasMany(Bimbingan::class, 'guru_id');
    }

    // Jika di tabel 'kelas' ada kolom 'guru_wali_id', kamu bisa aktifkan relasi ini:
    // public function kelas()
    // {
    //     return $this->hasMany(Kelas::class, 'guru_wali_id');
    // }
}
