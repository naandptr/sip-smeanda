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
        Schema::table('tbl_jurusan', function (Blueprint $table) {
            $table->unique('kode_jurusan');
            $table->unique('nama_jurusan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_jurusan', function (Blueprint $table) {
            $table->dropUnique(['kode_jurusan']);
            $table->dropUnique(['nama_jurusan']);
        });
    }
};
