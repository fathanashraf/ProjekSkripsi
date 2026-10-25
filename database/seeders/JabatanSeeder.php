<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jabatan;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jabatans = [
            [
                'name_jabatan' => 'Pembina',
            ],
            [
                'name_jabatan' => 'Kahim',
            ],
            [
                'name_jabatan' => 'Wakahim',
            ],
            [
                'name_jabatan' => 'Sekretaris',
            ],
            [
                'name_jabatan' => 'Bendahara',
            ]
        ];
        foreach ($jabatans as $jabatan) {
            Jabatan::updateOrCreate(
                ['name_jabatan' => $jabatan['name_jabatan']],
                $jabatan
            );
        }
    }
}
