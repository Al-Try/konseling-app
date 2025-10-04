<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bimbingans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete();
            $table->foreignId('guru_id')->constrained('guru_walis')->cascadeOnDelete();
            $table->foreignId('jenis_id')->constrained('jenis_bimbingans')->cascadeOnDelete();
            $table->date('tanggal');
            $table->text('catatan')->nullable();
            $table->integer('poin')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bimbingans');
    }
};
