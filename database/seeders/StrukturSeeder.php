<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Devisi;
use App\Models\Jabatan;
use App\Models\Struktur;
use Illuminate\Database\Seeder;

class StrukturSeeder extends Seeder
{
    public function run(): void
    {
        // Jabatan IDs: 1=Pembina, 2=Kahim, 3=Wakahim, 4=Sekretaris, 5=Bendahara
        // Devisi IDs:  1=Kaderisasi, 2=Kominfo, 3=Humas, 4=KWU, 5=Minat dan Bakat, 6=Keagamaan, 7=Sosial, 8=Pemberdayaan Wanita

        $strukturs = [

            // ==========================================
            //  JABATAN / BPH
            // ==========================================

            // Pembina
            [
                'user_id'       => 2, // Ir. R. Joko Musridho, S.T, M.Phil
                'jabatan_id'    => 1, // Pembina
                'devisi_id'     => null,
                'posisi'        => null,
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            // Ketua Himpunan
            [
                'user_id'       => 3, // Alpalah Baihaqi
                'jabatan_id'    => 2, // Kahim
                'devisi_id'     => null,
                'posisi'        => null,
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            // Wakil Ketua
            [
                'user_id'       => 4, // Muhammad Ramadani
                'jabatan_id'    => 3, // Wakahim
                'devisi_id'     => null,
                'posisi'        => null,
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            // Sekretaris 1
            [
                'user_id'       => 5, // Salsabillah Rahmadhani
                'jabatan_id'    => 4, // Sekretaris
                'devisi_id'     => null,
                'posisi'        => null,
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            // Sekretaris 2
            [
                'user_id'       => 6, // Sherly Agustina Arnanda
                'jabatan_id'    => 4, // Sekretaris
                'devisi_id'     => null,
                'posisi'        => null,
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            // Bendahara
            [
                'user_id'       => 7, // Nanda Setiana
                'jabatan_id'    => 5, // Bendahara
                'devisi_id'     => null,
                'posisi'        => null,
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            // ==========================================
            //  DIVISI KADERISASI (devisi_id: 1)
            // ==========================================

            // Kepala
            [
                'user_id'       => 8, // Vivi Damayanti
                'jabatan_id'    => null,
                'devisi_id'     => 1,
                'posisi'        => 'Koordinator',
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            // Anggota
            [
                'user_id'       => 9, // Regina Sesilia
                'jabatan_id'    => null,
                'devisi_id'     => 1,
                'posisi'        => 'Anggota',
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            [
                'user_id'       => 10, // Valikh Dwi Putra Noor
                'jabatan_id'    => null,
                'devisi_id'     => 1,
                'posisi'        => 'Anggota',
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            [
                'user_id'       => 11, // Agam Al Hakim Hasibuan
                'jabatan_id'    => null,
                'devisi_id'     => 1,
                'posisi'        => 'Anggota',
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            // ==========================================
            //  DIVISI KOMINFO (devisi_id: 2)
            // ==========================================

            // Kepala
            [
                'user_id'       => 12, // Widia Ningsih
                'jabatan_id'    => null,
                'devisi_id'     => 2,
                'posisi'        => 'Koordinator',
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            // Anggota
            [
                'user_id'       => 13, // Muhammad Arifin
                'jabatan_id'    => null,
                'devisi_id'     => 2,
                'posisi'        => 'Anggota',
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            [
                'user_id'       => 14, // Bemby Novandry
                'jabatan_id'    => null,
                'devisi_id'     => 2,
                'posisi'        => 'Anggota',
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            // ==========================================
            //  DIVISI HUMAS (devisi_id: 3)
            // ==========================================

            // Kepala
            [
                'user_id'       => 15, // Adriansyah Pratama
                'jabatan_id'    => null,
                'devisi_id'     => 3,
                'posisi'        => 'Koordinator',
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            // Anggota
            [
                'user_id'       => 16, // Muhammad Abdi Ahzani
                'jabatan_id'    => null,
                'devisi_id'     => 3,
                'posisi'        => 'Anggota',
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            [
                'user_id'       => 17, // Muhammad Hasbullah
                'jabatan_id'    => null,
                'devisi_id'     => 3,
                'posisi'        => 'Anggota',
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            [
                'user_id'       => 18, // Muhammad Dzuryadi
                'jabatan_id'    => null,
                'devisi_id'     => 3,
                'posisi'        => 'Anggota',
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            // ==========================================
            //  DIVISI KWU (devisi_id: 4)
            // ==========================================

            // Kepala
            [
                'user_id'       => 19, // Arlian Dinata
                'jabatan_id'    => null,
                'devisi_id'     => 4,
                'posisi'        => 'Koordinator',
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            // Anggota
            [
                'user_id'       => 20, // Nabillatul Syahbandi Ardyansal
                'jabatan_id'    => null,
                'devisi_id'     => 4,
                'posisi'        => 'Anggota',
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            [
                'user_id'       => 21, // Diah Lestari
                'jabatan_id'    => null,
                'devisi_id'     => 4,
                'posisi'        => 'Anggota',
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            [
                'user_id'       => 22, // Wan Samsi Rahmi
                'jabatan_id'    => null,
                'devisi_id'     => 4,
                'posisi'        => 'Anggota',
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            // ==========================================
            //  DIVISI MINAT DAN BAKAT (devisi_id: 5)
            // ==========================================

            // Kepala
            [
                'user_id'       => 23, // Adriansyah Mulia
                'jabatan_id'    => null,
                'devisi_id'     => 5,
                'posisi'        => 'Koordinator',
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            // Anggota
            [
                'user_id'       => 24, // Isvihani Ramadan
                'jabatan_id'    => null,
                'devisi_id'     => 5,
                'posisi'        => 'Anggota',
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            [
                'user_id'       => 25, // Irsyadul Fikri
                'jabatan_id'    => null,
                'devisi_id'     => 5,
                'posisi'        => 'Anggota',
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            [
                'user_id'       => 26, // Muhammad Irsah
                'jabatan_id'    => null,
                'devisi_id'     => 5,
                'posisi'        => 'Anggota',
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            [
                'user_id'       => 27, // Muhammad Fadhli Arrafi
                'jabatan_id'    => null,
                'devisi_id'     => 5,
                'posisi'        => 'Anggota',
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            [
                'user_id'       => 28, // Naila Zahida
                'jabatan_id'    => null,
                'devisi_id'     => 5,
                'posisi'        => 'Anggota',
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            // ==========================================
            //  DIVISI KEAGAMAAN (devisi_id: 6)
            // ==========================================

            // Kepala
            [
                'user_id'       => 29, // Afrila Fajar
                'jabatan_id'    => null,
                'devisi_id'     => 6,
                'posisi'        => 'Koordinator',
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            // Anggota
            [
                'user_id'       => 30, // Yunita Nur Aini
                'jabatan_id'    => null,
                'devisi_id'     => 6,
                'posisi'        => 'Anggota',
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            // ==========================================
            //  DIVISI SOSIAL (devisi_id: 7)
            // ==========================================

            // Kepala
            [
                'user_id'       => 31, // Muhammad Al Ghifran
                'jabatan_id'    => null,
                'devisi_id'     => 7,
                'posisi'        => 'Koordinator',
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            // Anggota
            [
                'user_id'       => 32, // Irfan Alfalah
                'jabatan_id'    => null,
                'devisi_id'     => 7,
                'posisi'        => 'Anggota',
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            [
                'user_id'       => 33, // Habil Maulana
                'jabatan_id'    => null,
                'devisi_id'     => 7,
                'posisi'        => 'Anggota',
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            // ==========================================
            //  DIVISI PEMBERDAYAAN WANITA (devisi_id: 8)
            // ==========================================

            // Kepala
            [
                'user_id'       => 34, // Bripalia Alsya
                'jabatan_id'    => null,
                'devisi_id'     => 8,
                'posisi'        => 'Koordinator',
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            // Anggota
            [
                'user_id'       => 35, // Jumata Berlyan
                'jabatan_id'    => null,
                'devisi_id'     => 8,
                'posisi'        => 'Anggota',
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            [
                'user_id'       => 36, // Angela Deyana
                'jabatan_id'    => null,
                'devisi_id'     => 8,
                'posisi'        => 'Anggota',
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            [
                'user_id'       => 37, // Agrefina Hafiza Nur Maida
                'jabatan_id'    => null,
                'devisi_id'     => 8,
                'posisi'        => 'Anggota',
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],

            [
                'user_id'       => 38, // Risma Dly
                'jabatan_id'    => null,
                'devisi_id'     => 8,
                'posisi'        => 'Anggota',
                'masa_jabatan'  => '2025/2026',
                'foto'          => null,
            ],
        ];

        // Idempotent: kunci unik (user_id + devisi_id + jabatan_id) agar aman
        // dijalankan berulang tanpa menggandakan struktur
        foreach ($strukturs as $struktur) {
            Struktur::updateOrCreate(
                [
                    'user_id' => $struktur['user_id'],
                    'devisi_id' => $struktur['devisi_id'] ?? null,
                    'jabatan_id' => $struktur['jabatan_id'] ?? null,
                ],
                $struktur
            );
        }
    }
}
