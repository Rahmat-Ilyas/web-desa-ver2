<?php

namespace Database\Seeders;

use App\Models\HistoricalTimeline;
use Illuminate\Database\Seeder;

class HistoricalTimelineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'year' => '1945',
                'title' => 'Era Kemerdekaan',
                'content' => 'Pasca proklamasi kemerdekaan Indonesia, wilayah ini mulai menata diri sebagai bagian dari administrasi pemerintahan yang baru di bawah naungan kedaulatan Republik Indonesia.',
                'order' => 1
            ],
            [
                'year' => '1960',
                'title' => 'Pembentukan Struktur Desa',
                'content' => 'Wilayah ini secara resmi ditetapkan sebagai unit administratif tingkat desa dengan kepemimpinan lokal yang pertama, menandai awal pertumbuhan ekonomi berbasis pertanian.',
                'order' => 2
            ],
            [
                'year' => '1985',
                'title' => 'Peningkatan Status Kelurahan',
                'content' => 'Seiring dengan pertumbuhan jumlah penduduk dan kepadatan kawasan, status administratif ditingkatkan dari desa menjadi kelurahan untuk mengoptimalkan pelayanan publik.',
                'order' => 3
            ],
            [
                'year' => '2005',
                'title' => 'Era Digitalisasi Pelayanan',
                'content' => 'Kelurahan mulai menerapkan sistem administrasi berbasis komputer secara sederhana, meningkatkan efisiensi pendataan warga dan pengelolaan data pertanahan.',
                'order' => 4
            ],
            [
                'year' => '2023',
                'title' => 'Pembangunan Infrastruktur Terpadu',
                'content' => 'Kelurahan berhasil merampungkan renovasi gedung kantor pusat dan peningkatan akses jalan utama, menciptakan lingkungan yang lebih nyaman bagi seluruh warga.',
                'order' => 5
            ]
        ];

        foreach ($data as $item) {
            HistoricalTimeline::updateOrCreate(
                ['year' => $item['year'], 'title' => $item['title']],
                $item
            );
        }
    }
}
