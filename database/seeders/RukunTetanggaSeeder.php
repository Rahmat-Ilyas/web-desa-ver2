<?php

namespace Database\Seeders;

use App\Models\RukunTetangga;
use App\Models\RukunWarga;
use Illuminate\Database\Seeder;

class RukunTetanggaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rws = RukunWarga::all();

        if ($rws->isEmpty()) {
            $this->command->warn('No Rukun Warga found. Skipping Rukun Tetangga seeding.');
            return;
        }

        foreach ($rws as $rw) {
            // Create 2 RTs for each RW
            for ($i = 1; $i <= 2; $i++) {
                RukunTetangga::create([
                    'rukun_warga_id' => $rw->id,
                    'no_rt' => str_pad($i, 2, '0', STR_PAD_LEFT),
                    'nama_ketua' => 'Ketua RT ' . $i . ' RW ' . $rw->no_rw,
                    'no_hp' => '08' . rand(100000000, 999999999),
                ]);
            }
        }
    }
}
