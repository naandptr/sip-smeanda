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
        Schema::table('tbl_dudi', function (Blueprint $table) {
            $table->unique('nama_dudi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_dudi', function (Blueprint $table) {
            $table->dropUnique(['nama_dudi']);
        });
    }
};
