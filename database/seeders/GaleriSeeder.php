<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GaleriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'judul' => 'Musrenbang Kelurahan 2024',
                'kategori' => 'Kegiatan',
                'image' => 'https://plus.unsplash.com/premium_photo-1661281350976-59b9514e5364?q=80&w=2069&auto=format&fit=crop',
                'deskripsi' => 'Musyawarah Perencanaan Pembangunan (Musrenbang) Kelurahan Ujung Sabbang untuk penyusunan RKPD tahun 2025. Dihadiri oleh seluruh Ketua RT/RW dan tokoh masyarakat.',
                'tanggal' => '2024-01-15'
            ],
            [
                'judul' => 'Pembersihan Saluran Drainase',
                'kategori' => 'Pembangunan',
                'image' => 'https://images.unsplash.com/photo-1589939705384-5185137a7f0f?q=80&w=2070&auto=format&fit=crop',
                'deskripsi' => 'Kegiatan gotong royong pembersihan saluran drainase utama untuk mencegah banjir saat musim hujan.',
                'tanggal' => '2024-02-02'
            ],
            [
                'judul' => 'Penyaluran Bantuan Sembako',
                'kategori' => 'Sosial',
                'image' => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=2070&auto=format&fit=crop',
                'deskripsi' => 'Penyaluran bantuan sosial berupa paket sembako bagi warga kurang mampu di wilayah RW 02.',
                'tanggal' => '2024-03-10'
            ],
            [
                'judul' => 'Peringatan Isra Miraj',
                'kategori' => 'Keagamaan',
                'image' => 'https://images.unsplash.com/photo-1564121211835-e88c852648ab?q=80&w=2070&auto=format&fit=crop',
                'deskripsi' => 'Pengajian akbar dalam rangka memperingati Isra Miraj Nabi Muhammad SAW di Masjid Jami Al-Ikhlas.',
                'tanggal' => '2024-02-08'
            ],
            [
                'judul' => 'Posyandu Balita Melati',
                'kategori' => 'Sosial',
                'image' => 'https://plus.unsplash.com/premium_photo-1681483648937-67de6663ce95?q=80&w=2070&auto=format&fit=crop',
                'deskripsi' => 'Kegiatan rutin penimbangan dan pemeriksaan kesehatan balita serta pemberian vitamin A.',
                'tanggal' => '2024-04-05'
            ],
            [
                'judul' => 'Perbaikan Jalan Lingkungan RW 03',
                'kategori' => 'Pembangunan',
                'image' => 'https://images.unsplash.com/photo-1584463673574-d022e37905f4?q=80&w=2070&auto=format&fit=crop',
                'deskripsi' => 'Proses pengaspalan jalan lingkungan di wilayah RW 03 sepanjang 300 meter.',
                'tanggal' => '2024-05-20'
            ],
            [
                'judul' => 'Senam Sehat Lansia',
                'kategori' => 'Kegiatan',
                'image' => 'https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?q=80&w=2070&auto=format&fit=crop',
                'deskripsi' => 'Senam pagi bersama para lansia untuk menjaga kesehatan dan kebugaran tubuh.',
                'tanggal' => '2024-06-12'
            ],
            [
                'judul' => 'Rapat Koordinasi Keamanan',
                'kategori' => 'Kegiatan',
                'image' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?q=80&w=2032&auto=format&fit=crop',
                'deskripsi' => 'Rapat koordinasi keamanan lingkungan bersama Babinsa, Bhabinkamtibmas, dan Linmas.',
                'tanggal' => '2024-07-01'
            ]
        ];

        foreach ($data as $item) {
            \App\Models\Galeri::create($item);
        }

        // Generate more dummy data using Faker
        $faker = \Faker\Factory::create('id_ID');
        $categories = ['Kegiatan', 'Pembangunan', 'Sosial', 'Keagamaan'];
        $sampleImages = [
            'https://images.unsplash.com/photo-1541560052-7eec2ade5d7e?q=80&w=2000',
            'https://images.unsplash.com/photo-1596468138838-29138d32813c?q=80&w=2000',
            'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?q=80&w=2000',
            'https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?q=80&w=2000',
            'https://images.unsplash.com/photo-1604937455095-ef2fe9d2c122?q=80&w=2000',
            'https://images.unsplash.com/photo-1577791465935-43033620f4f9?q=80&w=2000',
            'https://images.unsplash.com/photo-1491438590914-bc09fcaaf77a?q=80&w=2000',
            'https://images.unsplash.com/photo-1473649085228-583485e6e4d7?q=80&w=2000',
            'https://images.unsplash.com/photo-1529338296731-c423854eb0e5?q=80&w=2000',
            'https://images.unsplash.com/photo-1576089172869-4f5f6f315620?q=80&w=2000',
            'https://images.unsplash.com/photo-1511632765486-a019809dd040?q=80&w=2000',
            'https://images.unsplash.com/photo-1544027993-37dbfe43562a?q=80&w=2000'
        ];

        for ($i = 0; $i < 50; $i++) {
            \App\Models\Galeri::create([
                'judul' => $faker->sentence(3),
                'kategori' => $faker->randomElement($categories),
                'image' => $faker->randomElement($sampleImages),
                'deskripsi' => $faker->paragraph(2),
                'tanggal' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            ]);
        }
    }
}
