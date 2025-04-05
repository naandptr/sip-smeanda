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
        Schema::create('tbl_dudi_jurusan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dudi_id')->constrained('tbl_dudi')->onDelete('cascade');
            $table->foreignId('jurusan_id')->constrained('tbl_jurusan')->onDelete('cascade');
            $table->foreignId('tahun_ajar_id')->constrained('tbl_tahun_ajar')->onDelete('cascade');
            $table->foreignId('pembimbing_id')->constrained('tbl_pembimbing')->onDelete('cascade');
        
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_dudi_jurusan');
    }
};
