<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pembayaran;

class PembayaranSeeder extends Seeder
{
    public function run(): void
    {
        $pembayarans = [
            [
                'user_id' => 3,
                'acara_id' => 1,
                'pendaftaran_id' => 1,
                'status' => 'lunas',
                'jenis' => 'cash',
                'bukti_pembayaran' => null,
            ],
            [
                'user_id' => 4,
                'acara_id' => 1,
                'pendaftaran_id' => 2,
                'status' => 'lunas',
                'jenis' => 'cash',
                'bukti_pembayaran' => null,
            ],
            [
                'user_id' => 5,
                'acara_id' => 2,
                'pendaftaran_id' => 3,
                'status' => 'lunas',
                'jenis' => 'cash',
                'bukti_pembayaran' => null,
            ],
            [
                'user_id' => 6,
                'acara_id' => 2,
                'pendaftaran_id' => 4,
                'status' => 'lunas',
                'jenis' => 'kredit',
                'bukti_pembayaran' => null,
            ],
            [
                'user_id' => 9,
                'acara_id' => 3,
                'pendaftaran_id' => 5,
                'status' => 'lunas',
                'jenis' => 'cash',
                'bukti_pembayaran' => null,
            ],
            [
                'user_id' => 10,
                'acara_id' => 3,
                'pendaftaran_id' => 6,
                'status' => 'lunas',
                'jenis' => 'cash',
                'bukti_pembayaran' => null,
            ],
            [
                'user_id' => 11,
                'acara_id' => 4,
                'pendaftaran_id' => 7,
                'status' => 'pending',
                'jenis' => 'cash',
                'bukti_pembayaran' => null,
            ],
            [
                'user_id' => 13,
                'acara_id' => 5,
                'pendaftaran_id' => 9,
                'status' => 'lunas',
                'jenis' => 'kredit',
                'bukti_pembayaran' => null,
            ],
            [
                'user_id' => 14,
                'acara_id' => 6,
                'pendaftaran_id' => 10,
                'status' => 'lunas',
                'jenis' => 'cash',
                'bukti_pembayaran' => null,
            ],
        ];

        foreach ($pembayarans as $pembayaran) {
            Pembayaran::updateOrCreate(
                ['user_id' => $pembayaran['user_id'], 'pendaftaran_id' => $pembayaran['pendaftaran_id']],
                $pembayaran
            );
        }
    }
}
