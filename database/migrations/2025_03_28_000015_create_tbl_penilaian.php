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
        Schema::create('tbl_penilaian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penetapan_prakerin_id')->constrained('tbl_penetapan_prakerin')->onDelete('cascade');
            $table->string('nama_instruktur');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_penilaian');
    }
};
