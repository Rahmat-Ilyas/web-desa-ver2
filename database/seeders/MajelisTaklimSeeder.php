<?php

namespace Database\Seeders;

use App\Models\MajelisTaklim;
use Illuminate\Database\Seeder;

class MajelisTaklimSeeder extends Seeder
{
    public function run(): void
    {
        MajelisTaklim::truncate();

        $members = [
            [
                'nama' => 'Hj. Sitti Maryam',
                'jabatan' => 'Ketua Majelis Taklim',
                'kategori' => 'Induk',
                'no_hp' => '081244556677',
                'urutan' => 1,
            ],
            [
                'nama' => 'Hj. Nuraini',
                'jabatan' => 'Wakil Ketua',
                'kategori' => 'Induk',
                'no_hp' => '081244556678',
                'urutan' => 2,
            ],
            [
                'nama' => 'Ustadzah Fatimah',
                'jabatan' => 'Sekretaris',
                'kategori' => 'Induk',
                'no_hp' => '081244556679',
                'urutan' => 3,
            ],
            [
                'nama' => 'Hj. Aminah',
                'jabatan' => 'Bendahara',
                'kategori' => 'Induk',
                'no_hp' => '081244556680',
                'urutan' => 4,
            ],
            [
                'nama' => 'Ahmad Fauzi',
                'jabatan' => 'Ketua Remaja Masjid',
                'kategori' => 'Remaja',
                'no_hp' => '081244556681',
                'urutan' => 5,
            ],
            [
                'nama' => 'Siti Khadijah',
                'jabatan' => 'Ketua Kelompok Ibu-ibu',
                'kategori' => 'Ibu-ibu',
                'no_hp' => '081244556682',
                'urutan' => 6,
            ],
            [
                'nama' => 'H. Abdullah',
                'jabatan' => 'Ketua Kelompok Bapak-bapak',
                'kategori' => 'Bapak-bapak',
                'no_hp' => '081244556683',
                'urutan' => 7,
            ],
        ];

        foreach ($members as $member) {
            MajelisTaklim::create($member);
        }
    }
}
