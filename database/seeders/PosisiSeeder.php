<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PosisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posisis = [
            [
                'name_posisi' => 'Koordinator',
            ],
            [
                'name_posisi' => 'Anggota',
            ],
        ];

        foreach ($posisis as $posisi) {
            DB::table('posisis')->insert($posisi);
        }
    }
}
