<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruWali extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','nip','nama_guru','no_hp','alamat'];

    public function user() { return $this->belongsTo(User::class); }
    public function kelas() { return $this->hasMany(Kelas::class, 'guru_wali_id'); }
    public function bimbingans() { return $this->hasMany(Bimbingan::class, 'guru_id'); }
}

