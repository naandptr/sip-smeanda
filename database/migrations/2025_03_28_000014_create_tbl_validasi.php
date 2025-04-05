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
        Schema::create('tbl_validasi', function (Blueprint $table) {
            $table->id();
            $table->enum('status_validasi', ['Menunggu', 'Selesai'])->default('Menunggu');
            $table->text('catatan')->nullable();
            $table->foreignId('jurnal_id')->constrained('tbl_jurnal')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_validasi');
    }
};
