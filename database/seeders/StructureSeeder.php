<?php

namespace Database\Seeders;

use App\Models\Structure;
use Illuminate\Database\Seeder;

class StructureSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Lurah (Level 1)
        $lurah = Structure::create([
            'name' => 'H. Andi Muhammad Idris, S.STP, M.Si',
            'nip' => '19850101 201001 1 001',
            'position' => 'Lurah Ujung Sabbang',
            'photo' => null,
            'level' => 1,
            'parent_id' => null,
            'order' => 1,
        ]);

        // 2. Sekretaris Lurah (Level 2)
        $seklur = Structure::create([
            'name' => 'Siti Aminah, S.E, M.Ak',
            'nip' => '19881212 201503 2 005',
            'position' => 'Sekretaris Lurah',
            'photo' => null,
            'level' => 2,
            'parent_id' => $lurah->id,
            'order' => 1,
        ]);

        // 3. Kasi-Kasi (Level 3)
        $kasiPem = Structure::create([
            'name' => 'Bambang Sudjatmiko, S.Sos',
            'nip' => '19820505 200801 1 003',
            'position' => 'Kasi Pemerintahan',
            'photo' => null,
            'level' => 3,
            'parent_id' => $seklur->id,
            'order' => 1,
        ]);

        $kasiEkbag = Structure::create([
            'name' => 'Ir. Hj. Ratnasari',
            'nip' => '19800315 200501 2 002',
            'position' => 'Kasi Ekonomi & Pembangunan',
            'photo' => null,
            'level' => 3,
            'parent_id' => $seklur->id,
            'order' => 2,
        ]);

        $kasiKesra = Structure::create([
            'name' => 'dr. Faisal Hamzah',
            'nip' => '19900707 201801 1 010',
            'position' => 'Kasi Kesejahteraan Rakyat',
            'photo' => null,
            'level' => 3,
            'parent_id' => $seklur->id,
            'order' => 3,
        ]);

        // 4. Staf (Level 4)
        Structure::create([
            'name' => 'Zulkifli, A.Md',
            'nip' => null,
            'position' => 'Staf Administrasi Umum',
            'photo' => null,
            'level' => 4,
            'parent_id' => $seklur->id,
            'order' => 1,
        ]);

        Structure::create([
            'name' => 'Maya Sari',
            'nip' => null,
            'position' => 'Staf Pelayanan',
            'photo' => null,
            'level' => 4,
            'parent_id' => $kasiPem->id,
            'order' => 1,
        ]);
    }
}
