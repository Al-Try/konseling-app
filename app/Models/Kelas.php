<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

    // app/Models/Kelas.php
    class Kelas extends Model {
        protected $fillable = ['nama_kelas','tingkat'];
        public function siswa() { return $this->hasMany(Siswa::class); }
    }

    // app/Models/Siswa.php
    class Siswa extends Model {
        protected $table = 'siswa';
        protected $fillable = ['nis','nama_siswa','kelas_id','jk','tanggal_lahir'];
        public function kelas()     { return $this->belongsTo(Kelas::class); }
        public function bimbingans(){ return $this->hasMany(Bimbingan::class); }
    }

    // app/Models/GuruWali.php
    class GuruWali extends Model {
        protected $table = 'guru_wali';
        protected $fillable = ['user_id','nip','nama'];
        public function user()      { return $this->belongsTo(User::class); }
        public function bimbingans(){ return $this->hasMany(Bimbingan::class, 'guru_id'); }
    }

    // app/Models/JenisBimbingan.php
    class JenisBimbingan extends Model {
        protected $fillable = ['kode','nama_jenis','poin'];
        public function bimbingans(){ return $this->hasMany(Bimbingan::class,'jenis_id'); }
    }

    // app/Models/Bimbingan.php
    class Bimbingan extends Model {
        protected $fillable = ['tanggal','siswa_id','guru_id','jenis_id','catatan','poin'];
        protected $casts = ['tanggal' => 'date'];
        public function siswa() { return $this->belongsTo(Siswa::class); }
        public function guruWali(){ return $this->belongsTo(GuruWali::class,'guru_id'); }
        public function jenis() { return $this->belongsTo(JenisBimbingan::class,'jenis_id'); }
    }
