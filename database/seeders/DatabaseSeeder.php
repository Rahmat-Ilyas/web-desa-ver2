<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            StructureSeeder::class,
            SettingSeeder::class,
            HistoricalTimelineSeeder::class,
            BeritaSeeder::class,
            PotensiSeeder::class,
            ProgramSeeder::class,
            GaleriSeeder::class,
            AnggaranSeeder::class,
            DownloadSeeder::class,
            LayananSeeder::class,
            RukunWargaSeeder::class,
            RukunTetanggaSeeder::class,
            LpmkSeeder::class,
            PkkSeeder::class,
            KarangTarunaSeeder::class,
            MajelisTaklimSeeder::class,
        ]);
    }
}
