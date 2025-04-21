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
        Schema::create('tbl_ketidakhadiran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penilaian_id')->constrained('tbl_penilaian')->onDelete('cascade');
            $table->integer('sakit')->default(0);
            $table->integer('ijin')->default(0);
            $table->integer('tanpa_keterangan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_ketidakhadiran');
    }
};
