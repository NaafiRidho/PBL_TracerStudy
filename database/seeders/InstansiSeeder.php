<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstansiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jenis_instansi')->insert([
            ['jenis_instansi' => 'Pendidikan Tinggi'],
            ['jenis_instansi' => 'Instansi Pemerintah'],
            ['jenis_instansi' => 'Perusahaan Swasta'],
            ['jenis_instansi' => 'BUMN'],
        ]);
    }
}
