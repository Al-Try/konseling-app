<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBimbingan extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'jenis_bimbingans';
    protected $fillable = ['nama_jenis','tipe','poin'];
}
