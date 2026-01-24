<?php

namespace Database\Seeders;

use App\Models\Potensi;
use Illuminate\Database\Seeder;

class PotensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $potensis = [
            [
                'judul' => 'Kawasan Wisata Mattirotasi',
                'kategori' => 'Wisata Alam',
                'deskripsi' => 'Salah satu ikon wisata kebanggaan Parepare yang terletak di pesisir Ujung Sabbang. Tempat terbaik untuk menikmati pemandangan laut lepas dan matahari terbenam (sunset) yang memukau. Dilengkapi dengan area jogging track dan gazebo untuk bersantai bersama keluarga.',
                'lokasi' => 'Jl. Mattirotasi, Pesisir Pantai',
                'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'judul' => 'Sentra Olahan Hasil Laut',
                'kategori' => 'UMKM & Produk',
                'deskripsi' => 'Pusat produksi oleh-oleh khas berbahan dasar hasil laut seperti abon ikan, kerupuk amplang, dan ikan kering berkualitas. Dikelola langsung oleh kelompok wanita nelayan setempat dengan standar kebersihan yang terjamin.',
                'lokasi' => 'Kampung Nelayan Ujung',
                'image' => 'https://images.unsplash.com/photo-1567620832903-9fc6debc209f?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'judul' => 'Kuliner Mantau Parepare',
                'kategori' => 'Kuliner',
                'deskripsi' => 'Roti kukus lembut khas Parepare yang disajikan dengan daging sapi lada hitam atau manis. Menjadi kuliner legendaris yang wajib dicicipi saat berkunjung ke Ujung Sabbang. Tersedia dalam kemasan beku untuk oleh-oleh.',
                'lokasi' => 'Pusat Kuliner Kota',
                'image' => 'https://images.unsplash.com/photo-1619532456587-809ba8795779?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'judul' => 'Aktivitas Nelayan Tradisional',
                'kategori' => 'Potensi Ekonomi',
                'deskripsi' => 'Kehidupan masyarakat pesisir yang masih menjaga tradisi melaut dengan perahu "Lepa-lepa" atau perahu cadik. Hasil tangkapan segar seperti Ikan Layang dan Cakalang menjadi komoditas utama yang menggerakkan ekonomi warga sekitar.',
                'lokasi' => 'Dermaga Rakyat',
                'image' => 'https://images.unsplash.com/photo-1520627582539-71275037d042?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'judul' => 'Sanggar Seni Budaya Bugis',
                'kategori' => 'Seni Budaya',
                'deskripsi' => 'Wadah pelestarian budaya Bugis bagi generasi muda, meliputi pelatihan Tari Paduppa, musik gendang, dan teater daerah. Sering tampil menyambut tamu kehormatan kota Parepare.',
                'lokasi' => 'Aula Kelurahan',
                'image' => 'https://images.unsplash.com/photo-1516972084-239537877997?auto=format&fit=crop&w=800&q=80',
            ],
        ];

        foreach ($potensis as $potensi) {
            Potensi::updateOrCreate(['judul' => $potensi['judul']], $potensi);
        }
    }
}
