<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tbl_penilaian_detail', function (Blueprint $table) {
            $table->decimal('skor', 4, 1)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('tbl_penilaian_detail', function (Blueprint $table) {
            $table->decimal('skor', 3, 1)->change();
        });
    }
};
