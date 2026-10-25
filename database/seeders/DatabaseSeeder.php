<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Foundation
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ProfilSeeder::class);

        // 2. Organisasi
        $this->call(JabatanSeeder::class);
        $this->call(DevisiSeeder::class);
        $this->call(StrukturSeeder::class);

        // 3. Master Data
        $this->call(SyaratSeeder::class);
        $this->call(BiayaSeeder::class);

        // 4. Konten
        $this->call(AcaraSeeder::class);
        $this->call(BeritaSeeder::class);
        $this->call(AspirasiSeeder::class);

        // 5. Pendaftaran & Pembayaran
        $this->call(PendaftaranSeeder::class);
        $this->call(PembayaranSeeder::class);
        $this->call(KeuanganSeeder::class);

        // 6. Pelengkap
        $this->call(LaporanSeeder::class);
        $this->call(DokumentasiSeeder::class);
    }
}
