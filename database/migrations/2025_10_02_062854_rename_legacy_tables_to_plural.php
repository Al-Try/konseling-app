<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Rename tabel tunggal ke jamak
        if (Schema::hasTable('siswa') && !Schema::hasTable('siswas')) {
            Schema::rename('siswa', 'siswas');
        }
        if (Schema::hasTable('guru_wali') && !Schema::hasTable('guru_walis')) {
            Schema::rename('guru_wali', 'guru_walis');
        }
        if (Schema::hasTable('kelas') && !Schema::hasTable('kelas')) {
            // kalau mau pakai class_rooms:
            // Schema::rename('kelas', 'class_rooms');
        }
        if (Schema::hasTable('jenis_bimbingan') && !Schema::hasTable('jenis_bimbingans')) {
            Schema::rename('jenis_bimbingan', 'jenis_bimbingans');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('siswas') && !Schema::hasTable('siswa')) {
            Schema::rename('siswas', 'siswa');
        }
        if (Schema::hasTable('guru_walis') && !Schema::hasTable('guru_wali')) {
            Schema::rename('guru_walis', 'guru_wali');
        }
        if (Schema::hasTable('jenis_bimbingans') && !Schema::hasTable('jenis_bimbingan')) {
            Schema::rename('jenis_bimbingans', 'jenis_bimbingan');
        }
    }
};
