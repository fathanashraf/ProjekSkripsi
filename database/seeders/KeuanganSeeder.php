<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Keuangan;

class KeuanganSeeder extends Seeder
{
    public function run(): void
    {
        $keuangans = [
            [
                'user_id' => 6,
                'acara_id' => 1,
                'pembayaran_id' => 1,
                'biaya_id' => 1,
                'total' => 50000,
            ],
            [
                'user_id' => 6,
                'acara_id' => 1,
                'pembayaran_id' => 2,
                'biaya_id' => 1,
                'total' => 50000,
            ],
            [
                'user_id' => 6,
                'acara_id' => 2,
                'pembayaran_id' => 3,
                'biaya_id' => 1,
                'total' => 50000,
            ],
            [
                'user_id' => 6,
                'acara_id' => 2,
                'pembayaran_id' => 4,
                'biaya_id' => 1,
                'total' => 50000,
            ],
            [
                'user_id' => 6,
                'acara_id' => 3,
                'pembayaran_id' => 5,
                'biaya_id' => 1,
                'total' => 50000,
            ],
            [
                'user_id' => 6,
                'acara_id' => 3,
                'pembayaran_id' => 6,
                'biaya_id' => 1,
                'total' => 50000,
            ],
            [
                'user_id' => 6,
                'acara_id' => 5,
                'pembayaran_id' => 8,
                'biaya_id' => 1,
                'total' => 50000,
            ],
            [
                'user_id' => 6,
                'acara_id' => 6,
                'pembayaran_id' => 9,
                'biaya_id' => 1,
                'total' => 50000,
            ],
        ];

        foreach ($keuangans as $keuangan) {
            Keuangan::updateOrCreate(
                ['pembayaran_id' => $keuangan['pembayaran_id']],
                $keuangan
            );
        }
    }
}
