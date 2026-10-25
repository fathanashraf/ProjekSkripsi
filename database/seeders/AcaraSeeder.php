<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Acara;

class AcaraSeeder extends Seeder
{
    public function run(): void
    {
        // Status vocabulary yang dipakai controller:
        // 'diajukan' -> menunggu persetujuan pembina
        // 'approved' -> sudah diizinkan
        // 'rejected' -> ditolak
        $acaras = [
            [
                'name_acara' => 'Seminar Teknologi Informasi 2026',
                'keterangan' => 'Seminar nasional tentang perkembangan teknologi informasi dan dampaknya terhadap dunia pendidikan.',
                'thumnail' => null,
                'tipe' => 'internal',
                'tempat' => 'Aula Universitas Pahlawan Tuanku Tambusai',
                'tanggal' => '2026-06-15',
                'status' => 'approved',
                'syarat_id' => 1,
                'biaya_id' => 1,
                'user_id' => 3,
            ],
            [
                // Eksternal + approved -> tampil di halaman welcome
                'name_acara' => 'Bakti Sosial Desa Binaan',
                'keterangan' => 'Kegiatan bakti sosial membersihkan lingkungan dan memberikan bantuan kepada warga desa binaan.',
                'thumnail' => null,
                'tipe' => 'eksternal',
                'tempat' => 'Desa Tanah Merah, Rokan Hulu',
                'tanggal' => '2026-07-10',
                'status' => 'approved',
                'syarat_id' => 1,
                'biaya_id' => 1,
                'user_id' => 3,
            ],
            [
                // Eksternal + diajukan -> menunggu izin pembina (tombol Konfirmasi/Tolak muncul)
                'name_acara' => 'Lomba Cerdas Cermat Nasional',
                'keterangan' => 'Lomba cerdas cermat antar perguruan tinggi yang disertai seminar pembicara tamu.',
                'thumnail' => null,
                'tipe' => 'eksternal',
                'tempat' => 'Gedung Serbaguna Universitas Pahlawan',
                'tanggal' => '2026-10-25',
                'status' => 'diajukan',
                'syarat_id' => 1,
                'biaya_id' => 1,
                'user_id' => 3,
            ],
            [
                'name_acara' => 'Workshop Pemrograman Web',
                'keterangan' => 'Workshop intensif pemrograman web menggunakan Laravel dan Vue.js untuk mahasiswa.',
                'thumnail' => null,
                'tipe' => 'internal',
                'tempat' => 'Lab Komputer Fakultas Teknik',
                'tanggal' => '2026-07-20',
                'status' => 'approved',
                'syarat_id' => 1,
                'biaya_id' => 1,
                'user_id' => 4,
            ],
            [
                // Diajukan -> pembina bisa menyetujui atau menolak
                'name_acara' => 'Lomba Cerdas Cermat Teknologi',
                'keterangan' => 'Lomba cerdas cermat seputar pengetahuan teknologi informasi antar angkatan.',
                'thumnail' => null,
                'tipe' => 'internal',
                'tempat' => 'Aula Universitas Pahlawan Tuanku Tambusai',
                'tanggal' => '2026-08-05',
                'status' => 'diajukan',
                'syarat_id' => 1,
                'biaya_id' => 1,
                'user_id' => 5,
            ],
            [
                'name_acara' => 'Fun Coding Competition',
                'keterangan' => 'Kompetisi pemrograman seru dengan berbagai tantangan coding untuk semua level.',
                'thumnail' => null,
                'tipe' => 'internal',
                'tempat' => 'Lab Komputer Fakultas Teknik',
                'tanggal' => '2026-08-15',
                'status' => 'approved',
                'syarat_id' => 1,
                'biaya_id' => 1,
                'user_id' => 3,
            ],
            [
                'name_acara' => 'Pelatihan Desain Grafis',
                'keterangan' => 'Pelatihan desain grafis menggunakan Adobe Photoshop dan Illustrator untuk pemula.',
                'thumnail' => null,
                'tipe' => 'internal',
                'tempat' => 'Ruang Multimedia Fakultas Teknik',
                'tanggal' => '2026-08-20',
                'status' => 'approved',
                'syarat_id' => 2,
                'biaya_id' => 1,
                'user_id' => 4,
            ],
            [
                'name_acara' => 'Kajian Islam Ilmiah',
                'keterangan' => 'Kajian rutin mengenai Islam dan sains yang menghubungkan ilmu pengetahuan dengan ajaran Islam.',
                'thumnail' => null,
                'tipe' => 'internal',
                'tempat' => 'Masjid Kampus Universitas Pahlawan',
                'tanggal' => '2026-09-01',
                'status' => 'approved',
                'syarat_id' => 2,
                'biaya_id' => 1,
                'user_id' => 5,
            ],
            [
                // Contoh penolakan
                'name_acara' => 'Rapat Kerja Tahunan',
                'keterangan' => 'Rapat evaluasi program kerja tahunan kepengurusan HIMANIKKA.',
                'thumnail' => null,
                'tipe' => 'internal',
                'tempat' => 'Ruang Rapat Fakultas Teknik',
                'tanggal' => '2026-12-10',
                'status' => 'rejected',
                'syarat_id' => 1,
                'biaya_id' => 1,
                'user_id' => 5,
            ],
        ];

        // Idempotent: aman dijalankan berulang tanpa menggandakan data
        foreach ($acaras as $acara) {
            Acara::updateOrCreate(
                ['name_acara' => $acara['name_acara']],
                $acara
            );
        }
    }
}
