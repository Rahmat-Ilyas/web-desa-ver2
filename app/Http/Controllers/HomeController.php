<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $lurah = \App\Models\Structure::where('level', 1)->first();
        $settings = \App\Models\Setting::whereIn('key', [
            'sambutan_quote',
            'sambutan_message',
            'visi',
            'misi'
        ])->get()->pluck('value', 'key');
        $structures = \App\Models\Structure::orderBy('level')->orderBy('order')->get();

        return Inertia::render('Home', [
            'villageName' => 'Kelurahan Ujung Sabbang',
            'lurah' => $lurah,
            'structures' => $structures,
            'sambutan' => [
                'quote' => $settings['sambutan_quote'] ?? '',
                'message' => $settings['sambutan_message'] ?? ''
            ],
            'visimisi' => [
                'visi' => $settings['visi'] ?? '',
                'misi' => $settings['misi'] ?? ''
            ],
            'latestBeritas' => \App\Models\Berita::latest()->take(3)->get(),
            'latestGaleris' => \App\Models\Galeri::latest()->take(8)->get()
        ]);
    }

    public function sambutan()
    {
        $lurah = \App\Models\Structure::where('level', 1)->first();
        $settings = \App\Models\Setting::whereIn('key', [
            'sambutan_quote',
            'sambutan_message'
        ])->get()->pluck('value', 'key');

        return Inertia::render('Profil/Sambutan', [
            'lurah' => $lurah,
            'sambutan' => [
                'quote' => $settings['sambutan_quote'] ?? '',
                'message' => $settings['sambutan_message'] ?? ''
            ]
        ]);
    }

    public function visimisi()
    {
        $lurah = \App\Models\Structure::where('level', 1)->first();
        $settings = \App\Models\Setting::whereIn('key', [
            'visi',
            'misi'
        ])->get()->pluck('value', 'key');

        $misi = $settings['misi'] ?? '[]';
        $misiArray = json_decode($misi, true);
        if (!is_array($misiArray)) {
            $misiArray = []; // Fallback
        }

        return Inertia::render('Profil/VisiMisi', [
            'lurah' => $lurah,
            'visimisi' => [
                'visi' => $settings['visi'] ?? '',
                'misi' => $misiArray
            ]
        ]);
    }

    public function aparatur()
    {
        $structures = \App\Models\Structure::with('parent')->orderBy('level')->orderBy('order')->get();
        return Inertia::render('Pemerintahan/Aparatur', [
            'structures' => $structures
        ]);
    }

    public function sejarah()
    {
        $intro = \App\Models\Setting::where('key', 'sejarah_singkat')->first();
        $timelines = \App\Models\HistoricalTimeline::orderBy('order')->orderBy('year')->get();

        return Inertia::render('Profil/Sejarah', [
            'intro' => $intro ? $intro->value : '',
            'timelines' => $timelines
        ]);
    }

    public function kondisi()
    {
        $settings = \App\Models\Setting::whereIn('key', [
            'kondisi_deskripsi',
            'kondisi_umum',
            'kondisi_batas',
            'kondisi_lahan',
            'kondisi_iklim'
        ])->get()->pluck('value', 'key');

        return Inertia::render('Profil/Kondisi', [
            'deskripsi' => $settings['kondisi_deskripsi'] ?? '',
            'umum' => json_decode($settings['kondisi_umum'] ?? '{}', true),
            'batas' => json_decode($settings['kondisi_batas'] ?? '{}', true),
            'lahan' => json_decode($settings['kondisi_lahan'] ?? '[]', true),
            'iklim' => json_decode($settings['kondisi_iklim'] ?? '{}', true),
        ]);
    }
    public function berita()
    {
        $kategori = request()->query('kategori');
        $search = request()->query('search');

        $query = \App\Models\Berita::with('user')->latest();

        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('konten', 'like', "%{$search}%");
            });
        }

        $beritas = $query->paginate(9)->withQueryString();

        $categories = [
            'Umum',
            'Prestasi',
            'Ekonomi',
            'Sosial',
            'Pembangunan',
            'Pemerintahan',
            'Kesehatan',
            'Pendidikan'
        ];

        return Inertia::render('Informasi/Berita/Index', [
            'beritas' => $beritas,
            'categories' => $categories,
            'currentCategory' => $kategori,
            'filters' => ['search' => $search]
        ]);
    }

    public function beritaDetail($slug)
    {
        $berita = \App\Models\Berita::with('user')->where('slug', $slug)->firstOrFail();
        $berita->increment('view_count');

        $latestBeritas = \App\Models\Berita::where('id', '!=', $berita->id)->latest()->take(5)->get();
        $categories = \App\Models\Berita::select('kategori')->distinct()->get()->pluck('kategori');

        return Inertia::render('Informasi/Berita/Show', [
            'berita' => $berita,
            'latestBeritas' => $latestBeritas,
            'categories' => $categories
        ]);
    }

    public function galeri()
    {
        $kategori = request()->query('kategori');
        $query = \App\Models\Galeri::latest();

        if ($kategori && $kategori !== 'Semua') {
            $query->where('kategori', $kategori);
        }

        $galeris = $query->paginate(12)->withQueryString();

        return Inertia::render('Galeri/Index', [
            'galeris' => $galeris,
            'currentCategory' => $kategori ?? 'Semua'
        ]);
    }
}
