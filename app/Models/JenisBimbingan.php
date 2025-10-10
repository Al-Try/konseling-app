<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class JenisBimbingan extends Model
{
    use HasFactory;

    // Default sudah benar: jenis_bimbingans
    protected $fillable = ['kode','nama_jenis','tipe', 'poin'];

    public function bimbingans()
    {
        return $this->hasMany(Bimbingan::class, 'jenis_id');
    }
    protected static function booted()
    {
        static::creating(function ($m) {
            if (!$m->kode) {
                $m->kode = Str::slug($m->nama_jenis, '_'); // auto jika user lupa
            }
        });
    }
}
