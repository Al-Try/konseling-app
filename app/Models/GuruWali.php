<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruWali extends Model
{
    use HasFactory;

    protected $table   = 'guru_walis';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'wali_id'); // kelas.wali_id
    }

    public function bimbingans()
    {
        return $this->hasMany(Bimbingan::class, 'guru_id'); // bimbingans.guru_id
    }
}
