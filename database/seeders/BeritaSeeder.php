<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $admin = User::first();

        if (!$admin) {
            return;
        }

        // Clear existing news to avoid duplicates if running multiple times
        Berita::truncate();

        $categories = ['Pemerintahan', 'Sosial', 'Ekonomi', 'Pendidikan', 'Kesehatan', 'Keamanan', 'Prestasi'];

        $titles = [
            'Rapat Koordinasi Pembangunan Infrastruktur Lingkungan',
            'Pelatihan Pemberdayaan Ekonomi Kreatif bagi Pemuda',
            'Penyaluran Bantuan Sembako untuk Warga Kurang Mampu',
            'Lomba Kebersihan Antar RT dalam Rangka HUT Kelurahan',
            'Vaksinasi Massal dan Pemeriksaan Kesehatan Gratis',
            'Peresmian Taman Bermain Ramah Anak di RW 04',
            'Program Kelurahan Digital: Peluncuran Aplikasi Layanan Mandiri',
            'Kerja Bakti Massal Membersihkan Saluran Drainase',
            'Workshop Pengelolaan Sampah Menjadi Kompos',
            'Pemberian Beasiswa Berprestasi untuk Anak-anak Kurang Mampu',
            'Penyuluhan Bahaya Narkoba bagi Generasi Muda',
            'Sosialisasi Ketahanan Pangan Keluarga Melalui Hidroponik',
            'Festival Kuliner Lokal Menyajikan Jajanan Khas Kelurahan',
            'Peluncuran Pos Kamling Modern Berbasis Teknologi',
            'Pawai Budaya Menyambut Peringatan Hari Kemerdekaan',
            'Pelatihan Pembuatan Laporan Keuangan bagi Pelaku UMKM',
            'Seminar Pola Hidup Sehat di Tengah Pandemi',
            'Lomba Cerdas Cermat Tingkat SD Se-Kelurahan',
            'Renovasi Kantor Kelurahan untuk Meningkatkan Pelayanan',
            'Kunjungan Studi Banding dari Kelurahan Tetangga',
            'Bantuan Alat Pertanian untuk Kelompok Tani Urban',
            'Pemberangkatan Jamaah Pengajian ke Pengajian Akbar',
            'Kampanye Pengurangan Penggunaan Plastik Sekali Pakai',
            'Lokal Karya Pengembangan Potensi Pariwisata Lokal',
            'Perbaikan Lampu Penerangan Jalan Umum di Gang Sempit',
            'Pendataan Ulang Penduduk untuk Akurasi Data Bansos',
            'Penyuluhan Pencegahan Stunting bagi Ibu Hamil',
            'Turnamen Sepak Bola Antar Kampung Memperebutkan Piala Lurah',
            'Pameran Foto Sejarah Kelurahan dari Masa ke Masa',
            'Rapat Pleno Penetapan Rencana Anggaran Kelurahan'
        ];

        foreach ($titles as $index => $judul) {
            $category = $categories[array_rand($categories)];
            $date = $faker->dateTimeBetween('-1 year', 'now');

            Berita::create([
                'judul' => $judul,
                'kategori' => $category,
                'slug' => Str::slug($judul) . '-' . Str::random(5),
                'konten' => $this->generateHtmlContent($judul, $faker),
                'image' => 'https://placehold.co/800x600/f1f5f9/64748b?text=BERITA+KELURAHAN',
                'user_id' => $admin->id,
                'view_count' => rand(50, 2000),
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
    }

    private function generateHtmlContent($title, $faker)
    {
        $paragraphs = $faker->paragraphs(rand(3, 6));
        $content = "<h3><strong>Pelaksanaan Kegiatan " . $title . "</strong></h3>";

        foreach ($paragraphs as $p) {
            $content .= "<p>" . $p . "</p>";
        }

        $content .= "<p>Diharapkan dengan adanya kegiatan ini, masyarakat Kelurahan Ujung Sabbang dapat merasakan manfaat langsung dan terus mendukung program-program pemerintah kelurahan demi kemajuan bersama.</p>";

        return $content;
    }
}
