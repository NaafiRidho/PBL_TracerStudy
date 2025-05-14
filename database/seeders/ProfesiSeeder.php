<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfesiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data =[[
            'kategori_profesi_id' => 1,
            'profesi'=> 'Developer/Programmer/Software Engineer'
        ],
        [
            'kategori_profesi_id' => 1,
            'profesi'=> 'IT Support/IT Administrator'
        ],
        [
            'kategori_profesi_id' =>1,
            'profesi'=>'Infrastructure Engineer'
        ],
        [
            'kategori_profesi_id' =>1,
            'profesi'=>'Digital Marketing Specialist'
        ],
        [
            'kategori_profesi_id' =>1,
            'profesi'=>'Graphic Designer/Multimedia Designer'
        ],
        [
            'kategori_profesi_id' =>1,
            'profesi'=>'Business Analyst'
        ],
        [
            'kategori_profesi_id' =>1,
            'profesi'=>'QA Engineer/Tester'
        ],
        [
            'kategori_profesi_id' =>1,
            'profesi'=>'IT Enterpreneur'
        ],
        [
            'kategori_profesi_id' =>1,
            'profesi'=>'Trainer/Guru/Dosen (IT)'
        ],
        [
            'kategori_profesi_id' =>2,
            'profesi'=>'Procurement & Operational Team'
        ],
        [
            'kategori_profesi_id' =>2,
            'profesi'=>'Wirausahawan (Non IT)'
        ],
        [
            'kategori_profesi_id' =>2,
            'profesi'=>'Trainer/Guru/Dosen (Non IT)'
        ]
    ];

    DB::table('profesi')->insert($data);
    }
}
