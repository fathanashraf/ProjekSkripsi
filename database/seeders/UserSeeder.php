<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            // [0] Admin
            [
                'name'     => 'Admin',
                'email'    => 'admin@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 1,
            ],

            // [1] Pembina
            [
                'name'     => 'Ir. R. Joko Musridho, S.T, M.Phil',
                'email'    => 'pembina@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 3,
            ],

            // === BPH / Jabatan Pusat ===

            // [2] Ketua Himpunan
            [
                'name'     => 'Alpalah Baihaqi',
                'email'    => 'alpalah@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // [3] Wakil Ketua
            [
                'name'     => 'Muhammad Ramadani',
                'email'    => 'ramadani@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // [4] Sekretaris 1
            [
                'name'     => 'Salsabillah Rahmadhani',
                'email'    => 'salsabillah@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // [5] Sekretaris 2
            [
                'name'     => 'Sherly Agustina Arnanda',
                'email'    => 'sherly@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // [6] Bendahara
            [
                'name'     => 'Nanda Setiana',
                'email'    => 'nanda@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // === Divisi Kaderisasi ===

            // [7] Kepala
            [
                'name'     => 'Vivi Damayanti',
                'email'    => 'vivi@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // [8] Anggota
            [
                'name'     => 'Regina Sesilia',
                'email'    => 'regina@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // [9] Anggota
            [
                'name'     => 'Valikh Dwi Putra Noor',
                'email'    => 'valikh@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // [10] Anggota
            [
                'name'     => 'Agam Al Hakim Hasibuan',
                'email'    => 'agam@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // === Divisi Kominfo ===

            // [11] Kepala
            [
                'name'     => 'Widia Ningsih',
                'email'    => 'widia@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // [12] Anggota
            [
                'name'     => 'Muhammad Arifin',
                'email'    => 'arifin@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // [13] Anggota
            [
                'name'     => 'Bemby Novandry',
                'email'    => 'bemby@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // === Divisi Humas ===

            // [14] Kepala
            [
                'name'     => 'Adriansyah Pratama',
                'email'    => 'adriansyah@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // [15] Anggota
            [
                'name'     => 'Muhammad Abdi Ahzani',
                'email'    => 'abdi@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // [16] Anggota
            [
                'name'     => 'Muhammad Hasbullah',
                'email'    => 'hasbullah@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // [17] Anggota
            [
                'name'     => 'Muhammad Dzuryadi',
                'email'    => 'dzuryadi@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // === Divisi KWU ===

            // [18] Kepala
            [
                'name'     => 'Arlian Dinata',
                'email'    => 'arlian@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // [19] Anggota
            [
                'name'     => 'Nabillatul Syahbandi Ardyansal',
                'email'    => 'nabillatul@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // [20] Anggota
            [
                'name'     => 'Diah Lestari',
                'email'    => 'diah@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // [21] Anggota
            [
                'name'     => 'Wan Samsi Rahmi',
                'email'    => 'samsi@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // === Divisi Minat dan Bakat ===

            // [22] Kepala
            [
                'name'     => 'Adriansyah Mulia',
                'email'    => 'mulia@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // [23] Anggota
            [
                'name'     => 'Isvihani Ramadan',
                'email'    => 'isvihani@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // [24] Anggota
            [
                'name'     => 'Irsyadul Fikri',
                'email'    => 'irsyadul@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // [25] Anggota
            [
                'name'     => 'Muhammad Irsah',
                'email'    => 'irsah@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // [26] Anggota
            [
                'name'     => 'Muhammad Fadhli Arrafi',
                'email'    => 'fadhli@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // [27] Anggota
            [
                'name'     => 'Naila Zahida',
                'email'    => 'naila@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // === Divisi Keagamaan ===

            // [28] Kepala
            [
                'name'     => 'Afrila Fajar',
                'email'    => 'afrila@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // [29] Anggota
            [
                'name'     => 'Yunita Nur Aini',
                'email'    => 'yunita@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // === Divisi Sosial ===

            // [30] Kepala
            [
                'name'     => 'Muhammad Al Ghifran',
                'email'    => 'ghifran@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // [31] Anggota
            [
                'name'     => 'Irfan Alfalah',
                'email'    => 'irfan@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // [32] Anggota
            [
                'name'     => 'Habil Maulana',
                'email'    => 'habil@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // === Divisi Pemberdayaan Wanita ===

            // [33] Kepala
            [
                'name'     => 'Bripalia Alsya',
                'email'    => 'bripalia@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // [34] Anggota
            [
                'name'     => 'Jumata Berlyan',
                'email'    => 'jumata@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // [35] Anggota
            [
                'name'     => 'Angela Deyana',
                'email'    => 'angela@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // [36] Anggota
            [
                'name'     => 'Agrefina Hafiza Nur Maida',
                'email'    => 'agrefina@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],

            // [37] Anggota
            [
                'name'     => 'Risma Dly',
                'email'    => 'risma@example.com',
                'password' => Hash::make('password'),
                'role_id'  => 2,
            ],
        ];

        // Idempotent: aman dijalankan berulang tanpa menggandakan user
        foreach ($users as $user) {
            User::firstOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}
