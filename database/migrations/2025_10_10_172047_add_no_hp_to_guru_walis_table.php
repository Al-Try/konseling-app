<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('guru_walis', function (Blueprint $table) {
            $table->string('no_hp', 20)->nullable()->after('nama'); // atur posisi sesuai kolom kamu
            // Kalau mau sekalian:
            // $table->string('alamat')->nullable()->after('no_hp');
        });
    }

    public function down(): void
    {
        Schema::table('guru_walis', function (Blueprint $table) {
            $table->dropColumn('no_hp');
            // $table->dropColumn('alamat');
        });
    }
};
