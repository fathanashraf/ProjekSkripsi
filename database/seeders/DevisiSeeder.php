<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Devisi;

class DevisiSeeder extends Seeder
{
    public function run(): void
    {
        $devisis = [
            'Kaderisasi',
            'Kominfo',
            'Humas',
            'KWU',
            'Minat dan Bakat',
            'Keagamaan',
            'Sosial',
            'Pemberdayaan Wanita',
        ];

        foreach ($devisis as $name) {
            Devisi::firstOrCreate(['name_devisi' => $name]);
        }
    }
}
