<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Download;

class DownloadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documents = [
            [
                'judul' => 'Formulir Keterangan Tidak Mampu (SKTM)',
                'type' => 'PDF',
                'size' => '245 KB',
                'kategori' => 'Layanan Umum',
                'file_path' => 'dummy/sktm.pdf',
                'deskripsi' => 'Formulir untuk pengajuan Surat Keterangan Tidak Mampu.'
            ],
            [
                'judul' => 'Formulir Pengantar Nikah (N1-N4)',
                'type' => 'DOCX',
                'size' => '156 KB',
                'kategori' => 'Layanan Umum',
                'file_path' => 'dummy/pengantar_nikah.docx',
                'deskripsi' => 'Berkas persyaratan administrasi pernikahan.'
            ],
            [
                'judul' => 'Laporan Realisasi Anggaran 2023',
                'type' => 'PDF',
                'size' => '1.2 MB',
                'kategori' => 'Transparansi',
                'file_path' => 'dummy/laporan_anggaran_2023.pdf',
                'deskripsi' => 'Laporan pertanggungjawaban realisasi APBDes Tahun Anggaran 2023.'
            ],
            [
                'judul' => 'Peraturan Daerah No. 5 Tahun 2022',
                'type' => 'PDF',
                'size' => '850 KB',
                'kategori' => 'Hukum',
                'file_path' => 'dummy/perda_no_5_2022.pdf',
                'deskripsi' => 'Peraturan Daerah tentang Ketertiban Umum.'
            ],
            [
                'judul' => 'Formulir Perubahan Data KK',
                'type' => 'PDF',
                'size' => '312 KB',
                'kategori' => 'Kependudukan',
                'file_path' => 'dummy/perubahan_kk.pdf',
                'deskripsi' => 'Formulir permohonan perubahan elemen data Kartu Keluarga.'
            ],
            [
                'judul' => 'Surat Keterangan Usaha (SKU)',
                'type' => 'DOCX',
                'size' => '128 KB',
                'kategori' => 'Layanan Umum',
                'file_path' => 'dummy/sku.docx',
                'deskripsi' => 'Format surat keterangan memiliki usaha di wilayah kelurahan.'
            ],
        ];

        foreach ($documents as $doc) {
            Download::create($doc);
        }
    }
}
