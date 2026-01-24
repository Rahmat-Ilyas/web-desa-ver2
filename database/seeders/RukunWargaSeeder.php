<?php

namespace Database\Seeders;

use App\Models\RukunWarga;
use Illuminate\Database\Seeder;

class RukunWargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'no_rw' => '01',
                'nama_ketua' => 'H. Andi Baso',
                'no_hp' => '081234567890',
            ],
            [
                'no_rw' => '02',
                'nama_ketua' => 'Drs. Syamsuddin',
                'no_hp' => '081298765432',
            ],
            [
                'no_rw' => '03',
                'nama_ketua' => 'Budi Santoso, S.Pd',
                'no_hp' => '082155556666',
            ],
            [
                'no_rw' => '04',
                'nama_ketua' => 'Hj. Fatimah',
                'no_hp' => '081344445555',
            ],
            [
                'no_rw' => '05',
                'nama_ketua' => 'Amran Sulaiman',
                'no_hp' => '085211112222',
            ],
            [
                'no_rw' => '06',
                'nama_ketua' => 'Ir. Muhammad Aris',
                'no_hp' => '081199998888',
            ],
        ];

        foreach ($data as $item) {
            RukunWarga::updateOrCreate(
                ['no_rw' => $item['no_rw']], // Key untuk cek duplikat
                $item
            );
        }
    }
}
