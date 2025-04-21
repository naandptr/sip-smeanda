<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    // database/seeders/AdminSeeder.php
    public function run()
    {
        DB::table('tbl_users')->insert([
            'username' => 'adminutama',
            'email' => 'admin@sekolah.sch.id',
            'password' => Hash::make('password123'), 
            'is_default_password' => false,
            'role' => User::ROLE_ADMIN_UTAMA, 
            'status' => User::STATUS_AKTIF,
            'email_verified_at' => now(), 
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
