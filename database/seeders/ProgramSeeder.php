<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            [
                'judul' => 'Pembangunan Posyandu Lansia RW 03',
                'kategori' => 'Kesehatan & Posyandu',
                'deskripsi' => 'Pembangunan gedung baru Posyandu khusus lansia untuk mendekatkan pelayanan kesehatan rutin.',
                'status' => 'Berjalan',
                'progress' => 65,
                'waktu_pelaksanaan' => 'Januari - Mei 2024',
                'icon' => 'fa-heartbeat',
                'color' => 'bg-pink-50 text-pink-600',
            ],
            [
                'judul' => 'Betonisasi Jalan Lingkungan Ujung Baru',
                'kategori' => 'Pembangunan Infrastruktur',
                'deskripsi' => 'Perbaikan jalan lingkungan sepanjang 500 meter untuk akses warga yang lebih baik.',
                'status' => 'Rencana',
                'progress' => 0,
                'waktu_pelaksanaan' => 'Juni - Agustus 2024',
                'icon' => 'fa-road',
                'color' => 'bg-orange-50 text-orange-600',
            ],
            [
                'judul' => 'Pelatihan Digital Marketing UMKM',
                'kategori' => 'Pemberdayaan Masyarakat',
                'deskripsi' => 'Pelatihan pemasaran online bagi pelaku UMKM di kelurahan agar bisa bersaing di pasar digital.',
                'status' => 'Selesai',
                'progress' => 100,
                'waktu_pelaksanaan' => 'Oktober 2023',
                'icon' => 'fa-store',
                'color' => 'bg-indigo-50 text-indigo-600',
            ],
            [
                'judul' => 'Festival Budaya Pesisir',
                'kategori' => 'Keagamaan & Budaya',
                'deskripsi' => 'Pagelaran seni dan budaya tahunan untuk melestarikan tradisi masyarakat pesisir Parepare.',
                'status' => 'Rencana',
                'progress' => 15,
                'waktu_pelaksanaan' => 'Desember 2024',
                'icon' => 'fa-mosque',
                'color' => 'bg-purple-50 text-purple-600',
            ],
            [
                'judul' => 'Jumat Bersih & Bank Sampah',
                'kategori' => 'Kebersihan & Lingkungan',
                'deskripsi' => 'Program rutin kerja bakti dan pengelolaan sampah mandiri warga setiap hari Jumat.',
                'status' => 'Berjalan',
                'progress' => 80,
                'waktu_pelaksanaan' => 'Sepanjang Tahun',
                'icon' => 'fa-trash',
                'color' => 'bg-emerald-50 text-emerald-600',
            ],
            [
                'judul' => 'Turnamen Futsal Pemuda Cup',
                'kategori' => 'Kepemudaan & Olahraga',
                'deskripsi' => 'Kompetisi olahraga antar RW untuk mempererat silaturahmi pemuda kelurahan.',
                'status' => 'Selesai',
                'progress' => 100,
                'waktu_pelaksanaan' => 'Agustus 2023',
                'icon' => 'fa-futbol',
                'color' => 'bg-cyan-50 text-cyan-600',
            ],
        ];

        foreach ($programs as $program) {
            Program::updateOrCreate(['judul' => $program['judul']], $program);
        }
    }
}
