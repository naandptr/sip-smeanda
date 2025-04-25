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
        Schema::create('tbl_admin_jurusan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('tbl_users')
                  ->onDelete('cascade');
            
            $table->unsignedBigInteger('jurusan_id')->nullable();
            $table->foreign('jurusan_id')
                  ->references('id')
                  ->on('tbl_jurusan')
                  ->onDelete('set null');
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_admin_jurusan');
    }
};
