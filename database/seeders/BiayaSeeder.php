<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Biaya;

class BiayaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Biaya::firstOrCreate(
            ['name_biaya' => 'Biaya Proposal'],
            [
                'keterangan' => 'Biaya Proposal',
                'nominal' => 50000
            ]
        );
    }
}
