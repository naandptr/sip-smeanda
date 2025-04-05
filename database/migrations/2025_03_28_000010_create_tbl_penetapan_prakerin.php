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
        Schema::create('tbl_penetapan_prakerin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('tbl_siswa')->onDelete('cascade');
            $table->foreignId('dudi_jurusan_id')->constrained('tbl_dudi_jurusan')->onDelete('cascade');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->foreignId('tahun_ajar_id')->constrained('tbl_tahun_ajar')->onDelete('cascade');
            $table->enum('status', ['Berlangsung', 'Selesai'])->default('Berlangsung');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_penetapan_prakerin');
    }
};
