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
        Schema::create('tbl_presensi', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('penetapan_prakerin_id')
                  ->constrained('tbl_penetapan_prakerin')
                  ->onDelete('cascade');
            
            $table->timestamp('tanggal')->useCurrent();
            $table->enum('jenis_presensi', ['Presensi Datang', 'Presensi Pulang']);
            $table->enum('status_kehadiran', ['Hadir', 'Izin', 'Sakit'])->nullable();
            $table->text('keterangan')->nullable();
            $table->string('file'); 
            
            $table->unsignedBigInteger('presensi_datang_id')->nullable();
            
            $table->timestamps();
            
            $table->unique(['penetapan_prakerin_id', 'tanggal', 'jenis_presensi']);
        });

        Schema::table('tbl_presensi', function (Blueprint $table) {
            $table->foreign('presensi_datang_id')
                  ->references('id')
                  ->on('tbl_presensi')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_absen', function (Blueprint $table) {
            $table->dropForeign(['presensi_datang_id']);
            $table->dropForeign(['penetapan_prakerin_id']);
        });
        
        Schema::dropIfExists('tbl_presensi');
    }
};