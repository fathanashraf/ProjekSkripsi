<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Syarat;

class SyaratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $syarats = [
            [
                'name_syarat' => 'Syarat Pendaftaran Acara',
                'kebutuhan' => '1. Kartu Mahasiswa
                2. Surat Keterangan Aktif Mahasiswa
                3. Surat Keterangan Lulus
                4. Surat Keterangan Aktif Dosen
                5. Surat Keterangan Aktif Dosen Wali
                6. Surat Keterangan Aktif Dosen Pembimbing',
            ],

            [
                'name_syarat' => 'Proposal',
            ]
        ];

        foreach ($syarats as $syarat) {
            Syarat::updateOrCreate(
                ['name_syarat' => $syarat['name_syarat']],
                $syarat
            );
        }
    }
}
