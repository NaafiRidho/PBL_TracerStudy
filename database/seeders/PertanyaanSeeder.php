<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PertanyaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['pertanyaan' => 'Kerjasama Tim', 'created_at' => now(), 'updated_at' => now()],
            ['pertanyaan' => 'Keahlian di bidang TI', 'created_at' => now(), 'updated_at' => now()],
            ['pertanyaan' => 'Kemampuan berbahasa asing (Inggris)', 'created_at' => now(), 'updated_at' => now()],
            ['pertanyaan' => 'Kemampuan berkomunikasi', 'created_at' => now(), 'updated_at' => now()],
            ['pertanyaan' => 'Pengembangan diri', 'created_at' => now(), 'updated_at' => now()],
            ['pertanyaan' => 'Kepemimpinan', 'created_at' => now(), 'updated_at' => now()],
            ['pertanyaan' => 'Etos Kerja', 'created_at' => now(), 'updated_at' => now()],
            ['pertanyaan' => 'Kompetensi yang dibutuhkan tapi belum dapat dipenuhi', 'created_at' => now(), 'updated_at' => now()],
            ['pertanyaan' => 'Saran untuk kurikulum program studi', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('pertanyaan')->insert($data);
    }
}
