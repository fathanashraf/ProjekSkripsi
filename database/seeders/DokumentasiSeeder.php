<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dokumentasi;

class DokumentasiSeeder extends Seeder
{
    public function run(): void
    {
        $dokumentasis = [
            // Acara 1: Seminar TI
            [
                'acara_id' => 1,
                'name_dokumentasi' => 'Foto Pembukaan Seminar TI',
                'file' => null,
            ],
            [
                'acara_id' => 1,
                'name_dokumentasi' => 'Foto Sesi Materi Seminar TI',
                'file' => null,
            ],
            [
                'acara_id' => 1,
                'name_dokumentasi' => 'Foto Sesi Tanya Jawab Seminar TI',
                'file' => null,
            ],
            [
                'acara_id' => 1,
                'name_dokumentasi' => 'Foto Penutupan Seminar TI',
                'file' => null,
            ],

            // Acara 2: Bakti Sosial
            [
                'acara_id' => 2,
                'name_dokumentasi' => 'Foto Kegiatan Bakti Sosial',
                'file' => null,
            ],
            [
                'acara_id' => 2,
                'name_dokumentasi' => 'Foto Bersama Warga',
                'file' => null,
            ],

            // Acara 3: Workshop Web
            [
                'acara_id' => 3,
                'name_dokumentasi' => 'Foto Workshop Pemrograman Web',
                'file' => null,
            ],
            [
                'acara_id' => 3,
                'name_dokumentasi' => 'Foto Sesi Praktek Workshop',
                'file' => null,
            ],

            // Acara 6: Pelatihan Desain Grafis
            [
                'acara_id' => 6,
                'name_dokumentasi' => 'Foto Pelatihan Desain Grafis',
                'file' => null,
            ],

            // Acara 7: Kajian Islam
            [
                'acara_id' => 7,
                'name_dokumentasi' => 'Foto Kajian Islam Ilmiah',
                'file' => null,
            ],
            [
                'acara_id' => 7,
                'name_dokumentasi' => 'Foto Sesi Diskusi Kajian',
                'file' => null,
            ],
        ];

        foreach ($dokumentasis as $dokumentasi) {
            Dokumentasi::updateOrCreate(
                ['name_dokumentasi' => $dokumentasi['name_dokumentasi']],
                $dokumentasi
            );
        }
    }
}
