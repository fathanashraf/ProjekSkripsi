<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Laporan;

class LaporanSeeder extends Seeder
{
    public function run(): void
    {
        $laporans = [
            // Acara 1: Seminar TI
            [
                'acaras_id'    => 1,
                'jenis'       => 'proposal',
                'nama_laporan' => 'Proposal Seminar Teknologi Informasi 2026',
                'tanggal'     => '2026-06-10',
                'status'      => 'approved',
            ],
            [
                'acaras_id'    => 1,
                'jenis'       => 'lpj',
                'nama_laporan' => 'LPJ Seminar Teknologi Informasi 2026',
                'tanggal'     => '2026-06-20',
                'status'      => 'diajukan',
            ],
            [
                'acaras_id'    => 1,
                'jenis'       => 'sk',
                'nama_laporan' => 'SK Kepanitiaan Seminar TI 2026',
                'tanggal'     => '2026-06-05',
                'status'      => 'approved',
            ],

            // Acara 2: Bakti Sosial
            [
                'acaras_id'    => 2,
                'jenis'       => 'proposal',
                'nama_laporan' => 'Proposal Bakti Sosial Desa Binaan',
                'tanggal'     => '2026-07-01',
                'status'      => 'approved',
            ],
            [
                'acaras_id'    => 2,
                'jenis'       => 'lpj',
                'nama_laporan' => 'LPJ Bakti Sosial Desa Binaan',
                'tanggal'     => '2026-07-15',
                'status'      => 'diajukan',
            ],

            // Acara 3: Workshop Pemrograman Web
            [
                'acaras_id'    => 3,
                'jenis'       => 'proposal',
                'nama_laporan' => 'Proposal Workshop Pemrograman Web',
                'tanggal'     => '2026-07-15',
                'status'      => 'approved',
            ],

            // Acara 4: Lomba Cerdas Cermat
            [
                'acaras_id'    => 4,
                'jenis'       => 'proposal',
                'nama_laporan' => 'Proposal Lomba Cerdas Cermat Teknologi',
                'tanggal'     => '2026-07-28',
                'status'      => 'diajukan',
            ],

            // Acara 6: Pelatihan Desain Grafis
            [
                'acaras_id'    => 6,
                'jenis'       => 'proposal',
                'nama_laporan' => 'Proposal Pelatihan Desain Grafis',
                'tanggal'     => '2026-08-10',
                'status'      => 'diajukan',
            ],

            // Acara 7: Kajian Islam Ilmiah
            [
                'acaras_id'    => 7,
                'jenis'       => 'proposal',
                'nama_laporan' => 'Proposal Kajian Islam Ilmiah',
                'tanggal'     => '2026-08-25',
                'status'      => 'approved',
            ],
        ];

        foreach ($laporans as $laporan) {
            Laporan::updateOrCreate(
                ['nama_laporan' => $laporan['nama_laporan']],
                $laporan
            );
        }
    }
}
