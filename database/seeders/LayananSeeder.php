<?php

namespace Database\Seeders;

use App\Models\Layanan;
use Illuminate\Database\Seeder;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'title' => 'KTP, KK & Surat Pindah',
                'description' => 'Pengurusan surat pengantar untuk pembuatan KTP baru, perpanjangan KK, maupun surat pindah datang/keluar.',
                'icon' => 'fa-id-card',
                'color' => 'bg-orange-50 text-orange-600',
                'requirements' => [
                    'Kartu Keluarga (KK) Asli & Fotokopi',
                    'KTP lama (untuk perpanjangan)',
                    'Surat Pengantar dari RT/RW setempat',
                    'Pas foto terbaru (jika diperlukan untuk dokumen fisik)',
                    'Akta Kelahiran (untuk pembuatan KTP baru)'
                ],
                'order' => 1
            ],
            [
                'title' => 'Akta Kelahiran & Nikah',
                'description' => 'Layanan pengantar untuk penerbitan akta kelahiran anak dan surat pengantar nikah (NA).',
                'icon' => 'fa-file-signature',
                'color' => 'bg-blue-50 text-blue-600',
                'requirements' => [
                    'Surat Keterangan Lahir dari Bidan/RS',
                    'Buku Nikah/Akta Perkawinan Orang Tua',
                    'KTP & KK Orang Tua',
                    'Fotokopi KTP 2 orang saksi kelahiran',
                    'Surat Pengantar RT/RW'
                ],
                'order' => 2
            ],
            [
                'title' => 'Ahli Waris & Surat Kuasa',
                'description' => 'Pembuatan surat pernyataan ahli waris dan legalitas surat kuasa untuk berbagai keperluan hukum.',
                'icon' => 'fa-users',
                'color' => 'bg-emerald-50 text-emerald-600',
                'requirements' => [
                    'Surat Kematian Pewaris',
                    'Fotokopi KTP & KK seluruh Ahli Waris',
                    'Surat Pernyataan Ahli Waris (bermaterai)',
                    'Saksi minimum 2 orang (beserta fotokopi KTP)',
                    'Surat Pengantar dari RT/RW'
                ],
                'order' => 3
            ],
            [
                'title' => 'SKCK & Ijin Keramaian',
                'description' => 'Pengurusan pengantar SKCK untuk melamar pekerjaan dan ijin pelaksanaan kegiatan/keramaian.',
                'icon' => 'fa-shield-alt',
                'color' => 'bg-red-50 text-red-600',
                'requirements' => [
                    'Fotokopi KTP & KK',
                    'Fotokopi Akta Kelahiran/Ijazah',
                    'Surat Pengantar dari RT/RW',
                    'Pas Foto 4x6 latar merah (3 lembar)',
                    'Proposal kegiatan (khusus ijin keramaian)'
                ],
                'order' => 4
            ],
            [
                'title' => 'Pengantar IMB',
                'description' => 'Surat pengantar untuk pengurusan Ijin Mendirikan Bangunan (IMB) atau PBG.',
                'icon' => 'fa-building',
                'color' => 'bg-amber-50 text-amber-600',
                'requirements' => [
                    'Fotokopi Sertifikat Tanah',
                    'Fotokopi KTP Pemohon',
                    'Fotokopi PBB Tahun Terakhir',
                    'Gambar Denah Bangunan',
                    'Surat Persetujuan Tetangga (jika diperlukan)'
                ],
                'order' => 5
            ],
            [
                'title' => 'Akta Kematian',
                'description' => 'Layanan pelaporan kematian warga untuk penerbitan akta kematian dari Disdukcapil.',
                'icon' => 'fa-book-reader',
                'color' => 'bg-gray-50 text-gray-600',
                'requirements' => [
                    'Surat Kematian dari RS/Puskesmas/Kelurahan',
                    'KTP & KK Asli Almarhum/Almarhumah',
                    'Fotokopi KTP Pelapor (Ahli Waris)',
                    'Fotokopi KTP 2 orang saksi',
                    'Surat Pengantar RT/RW'
                ],
                'order' => 6
            ],
            [
                'title' => 'SITU & Keterangan Usaha',
                'description' => 'Pembuatan Surat Keterangan Usaha (SKU) untuk pengajuan modal atau legalitas IKM/UMKM.',
                'icon' => 'fa-store',
                'color' => 'bg-indigo-50 text-indigo-600',
                'requirements' => [
                    'Fotokopi KTP & KK Pemilik Usaha',
                    'Surat Pengantar dari RT/RW',
                    'Foto lokasi atau tempat usaha',
                    'Surat pernyataan tidak keberatan tetangga',
                    'Dokumen legalitas tanah lokasi (jika perlu)'
                ],
                'order' => 7
            ],
            [
                'title' => 'Keterangan Tidak Mampu',
                'description' => 'Penerbitan SKTM untuk keperluan keringanan biaya sekolah, kesehatan, atau bantuan sosial.',
                'icon' => 'fa-hand-holding-heart',
                'color' => 'bg-rose-50 text-rose-600',
                'requirements' => [
                    'Fotokopi KTP & KK',
                    'Surat Pengantar dari RT/RW (mencantumkan keterangan tidak mampu)',
                    'Surat pernyataan penghasilan orang tua',
                    'Foto kondisi rumah (opsional)',
                    'Tujuan penggunaan SKTM (Sekolah/RS/Bansos)'
                ],
                'order' => 8
            ]
        ];

        foreach ($services as $service) {
            Layanan::updateOrCreate(['title' => $service['title']], $service);
        }
    }
}
