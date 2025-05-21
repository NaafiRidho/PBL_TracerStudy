<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user')->insert([
            'role_id' => 1, // id role admin
            'username' => 'admin',
            'password' => Hash::make('password123'), // password di-hash
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
