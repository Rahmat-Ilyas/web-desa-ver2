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
            ]),
            'profil_pkk' => 'Pemberdayaan Kesejahteraan Keluarga (PKK) adalah organisasi kemasyarakatan yang memberdayakan wanita untuk turut berpartisipasi dalam pembangunan Indonesia.',
            'program_pkk' => json_encode([
                "Meningkatkan kesadaran berbangsa dan bernegara.",
                "Menyelenggarakan kursus-kursus keterampilan.",
                "Mengembangkan koperasi dan ekonomi produktif.",
                "Meningkatkan derajat kesehatan keluarga."
            ]),
            'profil_karang_taruna' => 'Karang Taruna adalah organisasi kepemudaan di Indonesia yang merupakan wadah pengembangan generasi muda yang tumbuh di atas dasar kesadaran dan tanggung jawab sosial.',
            'tugas_karang_taruna' => json_encode([
                "Membangun jiwa kewirausahaan pemuda.",
                "Mengadakan kegiatan olahraga dan seni budaya.",
                "Berpartisipasi dalam bakti sosial dan pemberdayaan masyarakat.",
                "Menjadi benteng pertahanan dari pengaruh negatif di lingkungan masyarakat."
            ]),
            'profil_lpmk' => 'Lembaga Pemberdayaan Masyarakat Kelurahan (LPMK) adalah lembaga mitra kelurahan dalam rangka meningkatkan prakarsa dan partisipasi masyarakat.',
            'tugas_lpmk' => json_encode([
                "Menyusun rencana pembangunan yang partisipatif.",
                "Menggerakkan swadaya gotong royong masyarakat.",
                "Melaksanakan dan mengendalikan pembangunan.",
                "Melakukan koordinasi dengan berbagai instansi terkait."
            ]),
            'profil_majelis_taklim' => 'Majelis Taklim adalah lembaga pendidikan non-formal yang memiliki fungsi sebagai pembinaan umat, khususnya dalam bidang agama Islam.',
            'kegiatan_majelis_taklim' => json_encode([
                "Pengajian rutin mingguan.",
                "Peringatan Hari Besar Islam (PHBI).",
                "Santunan anak yatim dan dhuafa.",
                "Pelatihan pemulasaraan jenazah."
            ]),
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
