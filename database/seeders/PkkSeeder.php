<?php

namespace Database\Seeders;

use App\Models\Pkk;
use Illuminate\Database\Seeder;

class PkkSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data first to avoid duplicates or mess
        Pkk::truncate();

        $members = [
            // --- INTI ---
            [
                'nama' => 'Hj. Fatimah Az-Zahra',
                'jabatan' => 'Ketua TP-PKK',
                'pokja' => 'Inti',
                'no_hp' => '081234567890',
                'urutan' => 1,
            ],
            [
                'nama' => 'Siti Nurhaliza, S.Pd',
                'jabatan' => 'Wakil Ketua I',
                'pokja' => 'Inti',
                'no_hp' => '081234567891',
                'urutan' => 2,
            ],
            [
                'nama' => 'Dra. H. Marlina',
                'jabatan' => 'Sekretaris',
                'pokja' => 'Inti',
                'no_hp' => '081234567892',
                'urutan' => 3,
            ],
            [
                'nama' => 'Andi Tenri Bau, S.E',
                'jabatan' => 'Bendahara',
                'pokja' => 'Inti',
                'no_hp' => '081234567893',
                'urutan' => 4,
            ],
            [
                'nama' => 'Nur Azizah, A.Md',
                'jabatan' => 'Wakil Sekretaris',
                'pokja' => 'Inti',
                'no_hp' => '081234567894',
                'urutan' => 5,
            ],

            // --- POKJA 1 ---
            [
                'nama' => 'Ibu Rahmawati',
                'jabatan' => 'Ketua Pokja 1',
                'pokja' => 'Pokja 1',
                'no_hp' => '082134567890',
                'urutan' => 6,
            ],
            [
                'nama' => 'Sitti Aminah',
                'jabatan' => 'Sekretaris Pokja 1',
                'pokja' => 'Pokja 1',
                'no_hp' => '082134567891',
                'urutan' => 7,
            ],
            [
                'nama' => 'Hj. Rosdiana',
                'jabatan' => 'Anggota Pokja 1',
                'pokja' => 'Pokja 1',
                'no_hp' => '082134567892',
                'urutan' => 8,
            ],
            [
                'nama' => 'Khadijah Al-Kubra',
                'jabatan' => 'Anggota Pokja 1',
                'pokja' => 'Pokja 1',
                'no_hp' => '082134567893',
                'urutan' => 9,
            ],

            // --- POKJA 2 ---
            [
                'nama' => 'Ibu Herlina',
                'jabatan' => 'Ketua Pokja 2',
                'pokja' => 'Pokja 2',
                'no_hp' => '083134567890',
                'urutan' => 10,
            ],
            [
                'nama' => 'Dwi Astuti, S.Pd',
                'jabatan' => 'Sekretaris Pokja 2',
                'pokja' => 'Pokja 2',
                'no_hp' => '083134567891',
                'urutan' => 11,
            ],
            [
                'nama' => 'Ratna Sari Dewi',
                'jabatan' => 'Anggota Pokja 2',
                'pokja' => 'Pokja 2',
                'no_hp' => '083134567892',
                'urutan' => 12,
            ],
            [
                'nama' => 'Endang Sri Wahyuni',
                'jabatan' => 'Anggota Pokja 2',
                'pokja' => 'Pokja 2',
                'no_hp' => '083134567893',
                'urutan' => 13,
            ],

            // --- POKJA 3 ---
            [
                'nama' => 'Ibu Suriani',
                'jabatan' => 'Ketua Pokja 3',
                'pokja' => 'Pokja 3',
                'no_hp' => '084134567890',
                'urutan' => 14,
            ],
            [
                'nama' => 'Andi Maryam',
                'jabatan' => 'Sekretaris Pokja 1',
                'pokja' => 'Pokja 3',
                'no_hp' => '084134567891',
                'urutan' => 15,
            ],
            [
                'nama' => 'Nurbaya Jafar',
                'jabatan' => 'Anggota Pokja 3',
                'pokja' => 'Pokja 3',
                'no_hp' => '084134567892',
                'urutan' => 16,
            ],

            // --- POKJA 4 ---
            [
                'nama' => 'Ibu Dr. Amalia',
                'jabatan' => 'Ketua Pokja 4',
                'pokja' => 'Pokja 4',
                'no_hp' => '085134567890',
                'urutan' => 17,
            ],
            [
                'nama' => 'Ns. Fitriani, S.Kep',
                'jabatan' => 'Sekretaris Pokja 4',
                'pokja' => 'Pokja 4',
                'no_hp' => '085134567891',
                'urutan' => 18,
            ],
            [
                'nama' => 'Hj. Kasmia',
                'jabatan' => 'Anggota Pokja 4',
                'pokja' => 'Pokja 4',
                'no_hp' => '085134567892',
                'urutan' => 19,
            ],
            [
                'nama' => 'Rina Andriani',
                'jabatan' => 'Anggota Pokja 4',
                'pokja' => 'Pokja 4',
                'no_hp' => '085134567893',
                'urutan' => 20,
            ],
        ];

        foreach ($members as $member) {
            Pkk::create($member);
        }
    }
}
