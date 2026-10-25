<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Berita;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        $beritas = [
            [
                'name_berita' => 'HIMANIKKA Sukses Gelar Seminar Teknologi Informasi 2026',
                'tanggal' => '2026-06-16',
                'thumnail' => null,
                'keterangan' => 'Himpunan Mahasiswa Teknik Informatika (HIMANIKKA) Universitas Pahlawan Tuanku Tambusai sukses menggelar Seminar Teknologi Informasi 2026. Acara yang diadakan di Aula Universitas ini dihadiri oleh lebih dari 200 peserta dari berbagai universitas di Riau.',
                'user_id' => 11,
            ],
            [
                'name_berita' => 'Penerimaan Anggota Baru HIMANIKKA 2026/2027',
                'tanggal' => '2026-07-05',
                'thumnail' => null,
                'keterangan' => 'HIMANIKKA membuka pendaftaran anggota baru untuk periode 2026/2027. Pendaftaran dibuka untuk seluruh mahasiswa Teknik Informatika angkatan 2024 dan 2025.',
                'user_id' => 12,
            ],
            [
                'name_berita' => 'Rekap Kegiatan Bakti Sosial HIMANIKKA',
                'tanggal' => '2026-07-12',
                'thumnail' => null,
                'keterangan' => 'HIMANIKKA telah melaksanakan kegiatan bakti sosial di Desa Tanah Merah. Kegiatan ini meliputi pembersihan lingkungan, penghijauan, dan pemberian bantuan sembako kepada warga kurang mampu.',
                'user_id' => 11,
            ],
            [
                'name_berita' => 'Workshop Pemrograman Web Berlangsung Sukses',
                'tanggal' => '2026-07-22',
                'thumnail' => null,
                'keterangan' => 'Workshop pemrograman web dengan topik Laravel dan Vue.js telah berhasil dilaksanakan. Peserta mendapatkan materi praktis tentang pengembangan web modern.',
                'user_id' => 13,
            ],
            [
                'name_berita' => 'HIMANIKKA Gelar Lomba Cerdas Cermat Teknologi',
                'tanggal' => '2026-08-06',
                'thumnail' => null,
                'keterangan' => 'Lomba cerdas cermat seputar pengetahuan teknologi informasi berhasil digelar dengan antusiasme tinggi dari peserta. Tim dari angkatan 2024 berhasil menjadi juara.',
                'user_id' => 12,
            ],
        ];

        foreach ($beritas as $berita) {
            Berita::updateOrCreate(
                ['name_berita' => $berita['name_berita']],
                $berita
            );
        }
    }
}
