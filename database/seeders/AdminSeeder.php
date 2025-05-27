<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        DB::table('tbl_users')->insert([
            'username' => 'adminutama',
            'password' => Hash::make('123456'), 
            'is_default_password' => true,
            'role' => User::ROLE_ADMIN_UTAMA, 
            'status' => User::STATUS_PENDING,
        ]);
    }
}
