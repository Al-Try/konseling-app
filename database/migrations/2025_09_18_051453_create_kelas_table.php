<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
    {
        
        // database/migrations/XXXX_create_kelas_table.php
        Schema::create('kelas', function (Blueprint $t) {
            $t->id();
            $t->string('nama_kelas');          // ex: "X IPA 1"
            $t->string('tingkat')->nullable(); // ex: X/XI/XII
            $t->timestamps();
        });

        // database/migrations/XXXX_create_siswa_table.php
        Schema::create('siswa', function (Blueprint $t) {
            $t->id();
            $t->string('nis')->unique();
            $t->string('nama_siswa');
            $t->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
            $t->string('jk', 1)->nullable(); // L/P
            $t->date('tanggal_lahir')->nullable();
            $t->timestamps();
        });

        // database/migrations/XXXX_create_guru_wali_table.php
        Schema::create('guru_wali', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete(); // akun login
            $t->string('nip')->nullable();
            $t->string('nama')->nullable(); // redundan (bisa ambil dari user)
            $t->timestamps();
        });

        // database/migrations/XXXX_create_jenis_bimbingans_table.php
        Schema::create('jenis_bimbingans', function (Blueprint $t) {
            $t->id();
            $t->string('kode')->unique();
            $t->string('nama_jenis');     // prestasi/pelanggaran/kedisiplinan/…
            $t->integer('poin')->default(0);
            $t->timestamps();
        });

        // database/migrations/XXXX_create_bimbingans_table.php
        Schema::create('bimbingans', function (Blueprint $t) {
            $t->id();
            $t->date('tanggal');
            $t->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $t->foreignId('guru_id')->constrained('guru_wali')->cascadeOnDelete();
            $t->foreignId('jenis_id')->constrained('jenis_bimbingans')->cascadeOnDelete();
            $t->text('catatan')->nullable();
            $t->integer('poin')->default(0); // cache dari jenis.poin saat input
            $t->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
