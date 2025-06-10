<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriProfesiIds = DB::table('kategori_profesi')->pluck('kategori_profesi_id')->toArray();
        $profesiIds = DB::table('profesi')->pluck('profesi_id')->toArray();
        $jenisInstansiIds = DB::table('jenis_instansi')->pluck('jenis_instansi_id')->toArray();
        $faker = Faker::create('id_ID');

        // Ambil semua pertanyaan
        $pertanyaan = DB::table('pertanyaan')->pluck('pertanyaan_id');

        for ($i = 1; $i <= 50; $i++) {
            // Buat user dummy
            // $userId = DB::table('user')->insertGetId([
            //     'username' => 'user' . $i,
            //     'password' => bcrypt('password'),
            //     'role' => 'alumni'
            // ]);

            // Buat atasan
            $atasanId = DB::table('atasan')->insertGetId([
                'nama_atasan' => $faker->name(),
                'nama_instansi' => $faker->company(),
                'jabatan' => $faker->jobTitle(),
                'email_atasan' => $faker->safeEmail(),
                'no_hp_atasan' => $faker->phoneNumber(),
                'otp_code' => null,
                'isOtp' => false,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Buat alumni
            $alumniId = DB::table('alumni')->insertGetId([
                'atasan_id' => $atasanId,
                'kategori_profesi_id' => $faker->randomElement($kategoriProfesiIds),
                'profesi_id' => $faker->randomElement($profesiIds),
                'jenis_instansi_id' => $faker->randomElement($jenisInstansiIds),
                'nim' => '190' . rand(10000, 99999),
                'nama_alumni' => $faker->name(),
                'prodi' => $faker->randomElement(['D-IV TI', 'D-IV SIB']),
                'no_hp' => $faker->phoneNumber(),
                'email' => $faker->email(),
                'tanggal_lulus' => $faker->dateTimeBetween('-4 years', '-2 years'),
                'tanggal_kerja_pertama' => $faker->dateTimeBetween('-3 years', '-1 years'),
                'masa_tunggu' => rand(1, 12),
                'tanggal_mulai_instansi' => $faker->dateTimeBetween('-3 years', '-1 years'),
                'nama_instansi' => $faker->company(),
                'skala_instansi' => $faker->randomElement(['international', 'nasional', 'wirausaha']),
                'lokasi_instansi' => $faker->city(),
                'otp_code' => null,
                'isOtp' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            // Jawaban untuk setiap pertanyaan
            $opsiJawaban = ['Kurang', 'Cukup', 'Baik', 'Sangat Baik'];

            $pertanyaanIds = DB::table('pertanyaan')->pluck('pertanyaan_id')->toArray();
            foreach ($pertanyaanIds as $pertanyaanId) {
                DB::table('jawaban')->insert([
                    'pertanyaan_id' => $pertanyaanId,
                    'alumni_id' => $alumniId,
                    'atasan_id' => $atasanId,
                    'jawaban' => $faker->randomElement($opsiJawaban),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
