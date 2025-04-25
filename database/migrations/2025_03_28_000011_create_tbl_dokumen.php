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
        Schema::create('tbl_dokumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('tbl_siswa')->onDelete('cascade');
            $table->enum('jenis', ['CV', 'Portofolio', 'Laporan', 'Sertifikat']);
            $table->string('file'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_dokumen');
    }
};
