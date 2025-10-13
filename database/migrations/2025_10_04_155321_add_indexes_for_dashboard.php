<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ========= bimbingans =========

        
        //Schema::table('bimbingans', function (Blueprint $table) {
            // indeks single kolom
            //$table->index('tanggal', 'bimbingans_tanggal_idx');
            //$table->index('guru_id', 'bimbingans_guru_id_idx');
            //$table->index('siswa_id', 'bimbingans_siswa_id_idx');
            //$table->index('jenis_id', 'bimbingans_jenis_id_idx');

            // indeks komposit untuk query top & tren
            //$table->index(['guru_id', 'tanggal'], 'bimbingans_guru_tanggal_idx');
            //$table->index(['siswa_id', 'tanggal'], 'bimbingans_siswa_tanggal_idx');
        //});

        Schema::table('bimbingans', function (Blueprint $t) {
            $t->index('tanggal');
            $t->index('siswa_id');
            $t->index('guru_id');
            $t->index('jenis_id');
        });

        // ========= siswas =========
        Schema::table('siswas', function (Blueprint $table) {
            $table->index('kelas_id', 'siswas_kelas_id_idx');
            $table->index('nama_siswa', 'siswas_nama_idx'); // bantu pencarian/autocomplete
        });

        // ========= guru_walis =========
        Schema::table('guru_walis', function (Blueprint $table) {
            $table->index('user_id', 'guru_walis_user_id_idx');
        });

        // ========= jenis_bimbingans =========
        Schema::table('jenis_bimbingans', function (Blueprint $table) {
            $table->index('nama_jenis', 'jenis_bimbingans_nama_idx');
        });
    }

    public function down(): void
    {
        Schema::table('bimbingans', function (Blueprint $table) {
            $table->dropIndex('bimbingans_tanggal_idx');
            $table->dropIndex('bimbingans_guru_id_idx');
            $table->dropIndex('bimbingans_siswa_id_idx');
            $table->dropIndex('bimbingans_jenis_id_idx');
            $table->dropIndex('bimbingans_guru_tanggal_idx');
            $table->dropIndex('bimbingans_siswa_tanggal_idx');
        });

        Schema::table('siswas', function (Blueprint $table) {
            $table->dropIndex('siswas_kelas_id_idx');
            $table->dropIndex('siswas_nama_idx');
        });

        Schema::table('guru_walis', function (Blueprint $table) {
            $table->dropIndex('guru_walis_user_id_idx');
        });

        Schema::table('jenis_bimbingans', function (Blueprint $table) {
            $table->dropIndex('jenis_bimbingans_nama_idx');
        });
    }
};
