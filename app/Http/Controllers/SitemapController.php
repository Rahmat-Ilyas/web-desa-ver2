<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = [
            // Static Pages
            ['loc' => route('landing'), 'priority' => '1.0', 'changefreq' => 'daily'],

            // Profil
            ['loc' => route('profil.sambutan'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => route('profil.visimisi'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => route('profil.sejarah'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => route('profil.kondisi'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => route('profil.lokasi-kantor'), 'priority' => '0.6', 'changefreq' => 'yearly'],
            ['loc' => route('profil.peta-lokasi'), 'priority' => '0.6', 'changefreq' => 'yearly'],

            // Lembaga
            ['loc' => route('lembaga.rt'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => route('lembaga.rw'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => route('lembaga.pkk'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => route('lembaga.karang-taruna'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => route('lembaga.lpmk'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => route('lembaga.majelis-taklim'), 'priority' => '0.7', 'changefreq' => 'monthly'],

            // Pemerintahan
            ['loc' => route('pemerintahan.aparatur'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => route('pemerintahan.anggaran'), 'priority' => '0.7', 'changefreq' => 'monthly'],

            // Data
            ['loc' => route('data.statistik'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => route('data.umur'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => route('data.pemilih'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => route('data.agama'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => route('data.pendidikan'), 'priority' => '0.7', 'changefreq' => 'monthly'],

            // Lainnya
            ['loc' => route('galeri'), 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['loc' => route('download'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => route('layanan'), 'priority' => '0.9', 'changefreq' => 'monthly'],
            ['loc' => route('pengaduan'), 'priority' => '0.9', 'changefreq' => 'never'],

            // Informasi Lists
            ['loc' => route('informasi.berita'), 'priority' => '0.9', 'changefreq' => 'daily'],
            ['loc' => route('informasi.potensi'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => route('informasi.program'), 'priority' => '0.8', 'changefreq' => 'monthly'],
        ];

        // Dynamic News (Berita)
        $berita = Berita::latest()->get();
        foreach ($berita as $item) {
            $urls[] = [
                'loc' => route('informasi.berita.show', $item->slug),
                'lastmod' => $item->updated_at->toIso8601String(),
                'priority' => '0.8',
                'changefreq' => 'weekly'
            ];
        }

        return response()->view('sitemap', [
            'urls' => $urls
        ])->header('Content-Type', 'text/xml');
    }
}
