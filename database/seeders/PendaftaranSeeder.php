<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pendaftaran;

class PendaftaranSeeder extends Seeder
{
    public function run(): void
    {
        $pendaftarans = [
            // Acara 1: Seminar TI
            [
                'nama_pendaftar' => 'Muhammad Ramadani',
                'NO_HP' => '081234567890',
                'user_id' => 3,
                'acaras_id' => 1,
                'status' => 'diterima',
                'keterangan' => 'Pendaftaran diterima',
                'file' => null,
            ],
            [
                'nama_pendaftar' => 'Salsabillah Rahmadhani',
                'NO_HP' => '081234567891',
                'user_id' => 4,
                'acaras_id' => 1,
                'status' => 'diterima',
                'keterangan' => 'Pendaftaran diterima',
                'file' => null,
            ],

            // Acara 2: Bakti Sosial
            [
                'nama_pendaftar' => 'Sherly Agustina Arnanda',
                'NO_HP' => '081234567892',
                'user_id' => 5,
                'acaras_id' => 2,
                'status' => 'diterima',
                'keterangan' => 'Pendaftaran diterima',
                'file' => null,
            ],
            [
                'nama_pendaftar' => 'Nanda Setiana',
                'NO_HP' => '081234567893',
                'user_id' => 6,
                'acaras_id' => 2,
                'status' => 'diterima',
                'keterangan' => 'Pendaftaran diterima',
                'file' => null,
            ],

            // Acara 3: Workshop Web
            [
                'nama_pendaftar' => 'Valikh Dwi Putra Noor',
                'NO_HP' => '081234567894',
                'user_id' => 9,
                'acaras_id' => 3,
                'status' => 'diterima',
                'keterangan' => 'Pendaftaran workshop diterima',
                'file' => null,
            ],
            [
                'nama_pendaftar' => 'Agam Al Hakim Hasibuan',
                'NO_HP' => '081234567895',
                'user_id' => 10,
                'acaras_id' => 3,
                'status' => 'diterima',
                'keterangan' => 'Pendaftaran workshop diterima',
                'file' => null,
            ],

            // Acara 4: Lomba Cerdas Cermat
            [
                'nama_pendaftar' => 'Widia Ningsih',
                'NO_HP' => '081234567896',
                'user_id' => 11,
                'acaras_id' => 4,
                'status' => 'diajukan',
                'keterangan' => 'Menunggu konfirmasi',
                'file' => null,
            ],
            [
                'nama_pendaftar' => 'Muhammad Arifin',
                'NO_HP' => '081234567897',
                'user_id' => 12,
                'acaras_id' => 4,
                'status' => 'ditolak',
                'keterangan' => 'Berkas tidak lengkap',
                'file' => null,
            ],

            // Acara 5: Fun Coding
            [
                'nama_pendaftar' => 'Bemby Novandry',
                'NO_HP' => '081234567898',
                'user_id' => 13,
                'acaras_id' => 5,
                'status' => 'diterima',
                'keterangan' => 'Pendaftaran diterima',
                'file' => null,
            ],

            // Acara 6: Pelatihan Desain
            [
                'nama_pendaftar' => 'Adriansyah Pratama',
                'NO_HP' => '081234567899',
                'user_id' => 14,
                'acaras_id' => 6,
                'status' => 'diterima',
                'keterangan' => 'Pendaftaran diterima',
                'file' => null,
            ],
        ];

        foreach ($pendaftarans as $pendaftaran) {
            Pendaftaran::updateOrCreate(
                ['nama_pendaftar' => $pendaftaran['nama_pendaftar']],
                $pendaftaran
            );
        }
    }
}
