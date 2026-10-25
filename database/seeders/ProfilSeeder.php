<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profil;

class ProfilSeeder extends Seeder
{
    public function run(): void
    {
        Profil::updateOrCreate(
            ['id' => 1],
            [
                'name_instansi' => 'HIMANIKKA',
                'singkatan' => 'HIMA NIKKA',
                'alamat' => 'Universitas Pahlawan Tuanku Tambusai',
                'logo' => null,
                'tahun_berdiri' => '2020',
                'visi' => 'Menjadi organisasi mahasiswa yang unggul dan profesional',
                'misi' => 'Meningkatkan kualitas mahasiswa dalam bidang akademik dan non-akademik',
                'tujuan' => 'Mewadahi aspirasi mahasiswa',
                'fungsi' => 'Sebagai organisasi kemahasiswaan',
                'ad_art' => null,
                'hymne_teknik' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}