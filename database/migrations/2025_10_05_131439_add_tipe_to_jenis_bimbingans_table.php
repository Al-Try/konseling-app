<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('jenis_bimbingans', function (Blueprint $table) {
            // kalau sudah ada kolom 'tipe', lewati saja
            if (!Schema::hasColumn('jenis_bimbingans', 'tipe')) {
                $table->string('tipe', 10)->default('positif')->after('nama_jenis');
                $table->index('tipe');
            }
        });
    }

    public function down(): void
    {
        Schema::table('jenis_bimbingans', function (Blueprint $table) {
            if (Schema::hasColumn('jenis_bimbingans', 'tipe')) {
                $table->dropIndex(['tipe']);
                $table->dropColumn('tipe');
            }
        });
    }
};
