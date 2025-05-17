<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=[[
            'role_kode'=>'ADM',
            'role_nama'=>'Admin'
        ],
        [
            'role_kode'=>'ALM',
            'role_nama'=>'Alumni'
        ],
        [
            'role_kode'=>'ATS',
            'role_nama'=>'Atasan'
        ]
    ]; 
    DB::table('role')->insert($data);
    }
}
