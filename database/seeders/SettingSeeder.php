<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'sambutan_quote' => 'Melayani masyarakat bukan sekadar tugas administratif, tapi sebuah panggilan hati untuk membawa perubahan nyata dan kemudahan bagi setiap warga.',
            'sambutan_message' => 'Puji syukur kita panjatkan ke hadirat Allah SWT, Tuhan Yang Maha Esa, atas segala limpahan rahmat dan karunia-Nya. Selamat datang di website resmi Kelurahan Ujung Sabbang. Website ini kami hadirkan sebagai wujud komitmen transparansi dan peningkatan kualitas pelayanan publik di era digital. Sebagai ujung tombak pemerintahan yang bersentuhan langsung dengan masyarakat, Kelurahan Ujung Sabbang terus berupaya berbenah diri. Kami menyadari bahwa tantangan zaman menuntut birokrasi yang lebih cepat, tepat, dan responsif. Oleh karena itu, digitalisasi layanan dan informasi menjadi salah satu prioritas utama kami.',
            'sambutan_commitments' => json_encode([
                [
                    'title' => 'Pelayanan Prima',
                    'description' => 'Memastikan setiap urusan administrasi warga dapat diselesaikan dengan mudah, cepat, dan tanpa pungutan liar.'
                ],
                [
                    'title' => 'Inovasi Berkelanjutan',
                    'description' => 'Terus mengembangkan program pemberdayaan masyarakat yang kreatif, solutif, dan berbasis teknologi tepat guna.'
                ],
                [
                    'title' => 'Lingkungan Kondusif',
                    'description' => 'Menjaga keamanan, ketertiban, dan kebersihan lingkungan bersama seluruh elemen masyarakat Kelurahan Ujung Sabbang.'
                ]
            ])
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
