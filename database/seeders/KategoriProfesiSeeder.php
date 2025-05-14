<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriProfesiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kategori_profesi' => 'Infokom'
            ],
            [
                'kategori_profesi' => 'Non Infokom'
            ]
        ];
        DB::table('kategori_profesi')->insert($data);
    }
}
