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
        Schema::create('tbl_absen', function (Blueprint $table) {
            $table->id();
            
            // Foreign key ke penetapan prakerin
            $table->foreignId('penetapan_prakerin_id')
                  ->constrained('tbl_penetapan_prakerin')
                  ->onDelete('cascade');
            
            // Data absensi
            $table->timestamp('tanggal')->useCurrent();
            $table->enum('jenis_absen', ['Absen Datang', 'Absen Pulang']);
            $table->enum('status_kehadiran', ['Hadir', 'Izin', 'Sakit'])->nullable();
            $table->text('keterangan')->nullable();
            $table->string('file'); // Path file bukti
            
            // Self-referencing (absen pulang mengacu ke absen datang)
            $table->unsignedBigInteger('absen_datang_id')->nullable();
            
            $table->timestamps();
            
            // Unique constraint
            $table->unique(['penetapan_prakerin_id', 'tanggal', 'jenis_absen']);
        });

        // Tambahkan foreign key untuk self-referencing SETELAH tabel dibuat
        Schema::table('tbl_absen', function (Blueprint $table) {
            $table->foreign('absen_datang_id')
                  ->references('id')
                  ->on('tbl_absen')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus foreign key dulu untuk menghindari error
        Schema::table('tbl_absen', function (Blueprint $table) {
            $table->dropForeign(['absen_datang_id']);
            $table->dropForeign(['penetapan_prakerin_id']);
        });
        
        Schema::dropIfExists('tbl_absen');
    }
};