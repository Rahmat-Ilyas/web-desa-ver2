<?php

namespace Database\Seeders;

use App\Models\Lpmk;
use Illuminate\Database\Seeder;

class LpmkSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            [
                'nama' => 'H. Rahman, S.Sos',
                'jabatan' => 'Ketua LPMK',
                'no_hp' => '081234567890',
                'foto' => null,
                'urutan' => 1,
            ],
            [
                'nama' => 'Drs. Ahmad Faisal',
                'jabatan' => 'Sekretaris',
                'no_hp' => '081234567891',
                'foto' => null,
                'urutan' => 2,
            ],
            [
                'nama' => 'Hj. Siti Aminah',
                'jabatan' => 'Bendahara',
                'no_hp' => '081234567892',
                'foto' => null,
                'urutan' => 3,
            ],
            [
                'nama' => 'Ir. Bambang Wijaya',
                'jabatan' => 'Ketua Bidang Pembangunan',
                'no_hp' => '081234567893',
                'foto' => null,
                'urutan' => 4,
            ],
            [
                'nama' => 'M. Yusuf, S.T',
                'jabatan' => 'Ketua Bidang Kesejahteraan',
                'no_hp' => '081234567894',
                'foto' => null,
                'urutan' => 5,
            ]
        ];

        foreach ($members as $member) {
            Lpmk::updateOrCreate(
                ['nama' => $member['nama']],
                $member
            );
        }
    }
}
