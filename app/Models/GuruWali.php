<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruWali extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'wali_id'); // sesuaikan jika beda
    }

    // ✅ relasi yang diminta controller: bimbingans()
    public function bimbingans()
    {
        // Ganti 'guru_id' dengan nama kolom FK yang benar di tabel bimbingans kamu:
        //   - kalau kolomnya 'guru_id'  → gunakan 'guru_id'
        //   - kalau kolomnya 'guru_wali_id' → gunakan 'guru_wali_id'
        return $this->hasMany(Bimbingan::class, 'guru_id');
    }

    // (opsional) relasi alias kalau ada kode lama pakai nama lain
    public function bimbingan()
    {
        return $this->bimbingans();
    }
}
