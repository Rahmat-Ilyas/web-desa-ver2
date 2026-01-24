<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Anggaran;

class AnggaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tahun = date('Y');

        $pendapatan = [
            [
                'tahun' => $tahun,
                'kategori' => 'pendapatan',
                'nama' => 'Dana Desa (DD)',
                'jumlah' => 800000000
            ],
            [
                'tahun' => $tahun,
                'kategori' => 'pendapatan',
                'nama' => 'Alokasi Dana Desa (ADD)',
                'jumlah' => 350000000
            ],
            [
                'tahun' => $tahun,
                'kategori' => 'pendapatan',
                'nama' => 'Pendapatan Asli Desa (PAD)',
                'jumlah' => 50000000
            ],
            [
                'tahun' => $tahun,
                'kategori' => 'pendapatan',
                'nama' => 'Bagi Hasil Pajak',
                'jumlah' => 50000000
            ],
        ];

        $belanja = [
            [
                'tahun' => $tahun,
                'kategori' => 'belanja',
                'nama' => 'Penyelenggaraan Pemdes',
                'jumlah' => 413175000
            ],
            [
                'tahun' => $tahun,
                'kategori' => 'belanja',
                'nama' => 'Pembangunan Desa',
                'jumlah' => 531225000
            ],
            [
                'tahun' => $tahun,
                'kategori' => 'belanja',
                'nama' => 'Pembinaan Kemasyarakatan',
                'jumlah' => 177075000
            ],
            [
                'tahun' => $tahun,
                'kategori' => 'belanja',
                'nama' => 'Pemberdayaan Masyarakat',
                'jumlah' => 59025000
            ],
        ];

        foreach (array_merge($pendapatan, $belanja) as $item) {
            Anggaran::create($item);
        }
    }
}
