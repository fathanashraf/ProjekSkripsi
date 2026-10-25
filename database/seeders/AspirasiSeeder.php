<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aspirasi;

class AspirasiSeeder extends Seeder
{
    public function run(): void
    {
        $aspirasis = [
            // Aspirasi untuk acara
            [
                'users_id' => 8,
                'acaras_id' => 1,
                'beritas_id' => null,
                'like' => 'like',
                'dislike' => null,
                'Masukkan' => 'Acara seminarnya sangat bermanfaat, next tingkatkan lagi pesertanya.',
                'status' => 'pending',
            ],
            [
                'users_id' => 9,
                'acaras_id' => 1,
                'beritas_id' => null,
                'like' => null,
                'dislike' => 'dislike',
                'Masukkan' => 'Mohon untuk acara selanjutnya waktunya ditambah.',
                'status' => 'pending',
            ],
            [
                'users_id' => 10,
                'acaras_id' => 2,
                'beritas_id' => null,
                'like' => 'like',
                'dislike' => null,
                'Masukkan' => 'Kegiatan bakti sosialnya seru dan bermanfaat bagi masyarakat.',
                'status' => 'selesai',
            ],
            [
                'users_id' => 11,
                'acaras_id' => 3,
                'beritas_id' => null,
                'like' => 'like',
                'dislike' => null,
                'Masukkan' => 'Workshopnya keren, materinya mudah dipahami.',
                'status' => 'pending',
            ],
            [
                'users_id' => 12,
                'acaras_id' => null,
                'beritas_id' => null,
                'like' => null,
                'dislike' => null,
                'Masukkan' => 'Saya ingin HIMANIKKA lebih aktif lagi di sosial media.',
                'status' => 'pending',
            ],
            [
                'users_id' => 13,
                'acaras_id' => null,
                'beritas_id' => null,
                'like' => null,
                'dislike' => null,
                'Masukkan' => 'Tolong sediakan wifi gratis di area fakultas untuk mendukung kegiatan belajar.',
                'status' => 'proses',
            ],

            // Aspirasi untuk berita
            [
                'users_id' => 14,
                'acaras_id' => null,
                'beritas_id' => 1,
                'like' => 'like',
                'dislike' => null,
                'Masukkan' => 'Beritanya informatif, semoga HIMANIKKA semakin maju.',
                'status' => 'pending',
            ],
            [
                'users_id' => 15,
                'acaras_id' => null,
                'beritas_id' => 2,
                'like' => 'like',
                'dislike' => null,
                'Masukkan' => 'Saya tertarik mendaftar jadi anggota baru.',
                'status' => 'selesai',
            ],
            [
                'users_id' => 16,
                'acaras_id' => null,
                'beritas_id' => 3,
                'like' => null,
                'dislike' => 'dislike',
                'Masukkan' => 'Rekapannya kurang detail, tolong ditambahkan dokumentasi foto.',
                'status' => 'pending',
            ],
            [
                'users_id' => 17,
                'acaras_id' => null,
                'beritas_id' => 4,
                'like' => 'like',
                'dislike' => null,
                'Masukkan' => 'Workshopnya bagus, mohon diadakan lagi untuk topik lain.',
                'status' => 'pending',
            ],
            [
                'users_id' => 18,
                'acaras_id' => null,
                'beritas_id' => 5,
                'like' => null,
                'dislike' => null,
                'Masukkan' => 'Apakah lombanya untuk umum atau hanya mahasiswa TI?',
                'status' => 'pending',
            ],
        ];

        foreach ($aspirasis as $aspirasi) {
            Aspirasi::updateOrCreate(
                ['Masukkan' => $aspirasi['Masukkan']],
                $aspirasi
            );
        }
    }
}
