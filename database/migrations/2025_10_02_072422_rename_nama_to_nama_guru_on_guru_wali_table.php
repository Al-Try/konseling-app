<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('guru_wali')
            && Schema::hasColumn('guru_wali','nama')
            && !Schema::hasColumn('guru_wali','nama')) {
            Schema::table('guru_wali', function (Blueprint $table) {
                $table->renameColumn('nama', 'nama');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('guru_wali')
            && Schema::hasColumn('guru_wali','nama')
            && !Schema::hasColumn('guru_wali','nama')) {
            Schema::table('guru_wali', function (Blueprint $table) {
                $table->renameColumn('nama', 'nama');
            });
        }
    }
};
