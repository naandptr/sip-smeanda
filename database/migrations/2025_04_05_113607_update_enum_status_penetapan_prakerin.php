<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateEnumStatusPenetapanPrakerin extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE tbl_penetapan_prakerin 
            MODIFY COLUMN status ENUM('Belum Dimulai', 'Berlangsung', 'Selesai', 'Dibatalkan') 
            DEFAULT 'Belum Dimulai'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE tbl_penetapan_prakerin 
            MODIFY COLUMN status ENUM('Berlangsung', 'Selesai')");
    }
}
