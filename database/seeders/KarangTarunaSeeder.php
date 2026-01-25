<?php

namespace Database\Seeders;

use App\Models\KarangTaruna;
use Illuminate\Database\Seeder;

class KarangTarunaSeeder extends Seeder
{
    public function run(): void
    {
        KarangTaruna::truncate();

        $members = [
            // Pengurus Harian
            [
                'nama' => 'Andi Muhammad Yusuf',
                'jabatan' => 'Ketua Karang Taruna',
                'bidang' => 'Pengurus Harian',
                'no_hp' => '081234567890',
                'urutan' => 1,
            ],
            [
                'nama' => 'Rizky Amalia, S.T',
                'jabatan' => 'Wakil Ketua',
                'bidang' => 'Pengurus Harian',
                'no_hp' => '081234567891',
                'urutan' => 2,
            ],
            [
                'nama' => 'Fadel Muhammad',
                'jabatan' => 'Sekretaris',
                'bidang' => 'Pengurus Harian',
                'no_hp' => '081234567892',
                'urutan' => 3,
            ],
            [
                'nama' => 'Siti Aisyah, S.E',
                'jabatan' => 'Bendahara',
                'bidang' => 'Pengurus Harian',
                'no_hp' => '081234567893',
                'urutan' => 4,
            ],

            // Seksi Olahraga
            [
                'nama' => 'Baim Wong',
                'jabatan' => 'Ketua Seksi Olahraga',
                'bidang' => 'Seksi Olahraga',
                'no_hp' => '081234567801',
                'urutan' => 5,
            ],
            [
                'nama' => 'Ardiansyah',
                'jabatan' => 'Anggota Seksi Olahraga',
                'bidang' => 'Seksi Olahraga',
                'no_hp' => '081234567802',
                'urutan' => 6,
            ],

            // Seksi Humas
            [
                'nama' => 'Dewi Persik',
                'jabatan' => 'Ketua Seksi Humas',
                'bidang' => 'Seksi Humas',
                'no_hp' => '081234567803',
                'urutan' => 7,
            ],

            // Seksi Kewirausahaan
            [
                'nama' => 'Raffi Ahmad',
                'jabatan' => 'Ketua Seksi Kewirausahaan',
                'bidang' => 'Seksi Kewirausahaan',
                'no_hp' => '081234567804',
                'urutan' => 8,
            ],
            [
                'nama' => 'Nagita Slavina',
                'jabatan' => 'Anggota Seksi Kewirausahaan',
                'bidang' => 'Seksi Kewirausahaan',
                'no_hp' => '081234567805',
                'urutan' => 9,
            ],

            // Seksi Kerohanian
            [
                'nama' => 'Ustadz Syam',
                'jabatan' => 'Ketua Seksi Kerohanian',
                'bidang' => 'Seksi Kerohanian',
                'no_hp' => '081234567806',
                'urutan' => 10,
            ],
        ];

        foreach ($members as $member) {
            KarangTaruna::create($member);
        }
    }
}
