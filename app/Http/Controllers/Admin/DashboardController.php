<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Pengaduan;
use App\Models\Setting;
use App\Models\Galeri;
use App\Models\Download;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // Get Statistics
        $totalBerita = Berita::count();
        $totalPengaduan = Pengaduan::count();
        $pendingPengaduan = Pengaduan::where('status', 'pending')->count();
        $totalGaleri = Galeri::count();
        $totalDownload = Download::count();

        // Get Population from Setting
        $statistikUmum = Setting::where('key', 'statistik_umum')->first();
        $totalPenduduk = '0';
        if ($statistikUmum) {
            $data = json_decode($statistikUmum->value, true);
            $totalPenduduk = collect($data)->firstWhere('label', 'Total Penduduk')['value'] ?? '0';
        }

        // Stats array for frontend
        $stats = [
            ['name' => 'Total Berita', 'value' => (string) $totalBerita, 'icon' => 'fa-newspaper', 'color' => 'blue'],
            ['name' => 'Aduan Masuk', 'value' => (string) $totalPengaduan, 'icon' => 'fa-exclamation-circle', 'color' => 'rose'],
            ['name' => 'Data Penduduk', 'value' => (string) $totalPenduduk, 'icon' => 'fa-users', 'color' => 'emerald'],
            ['name' => 'Dokumen Download', 'value' => (string) $totalDownload, 'icon' => 'fa-file-download', 'color' => 'amber'],
        ];

        // Recent Activities (Combined as raw models first for sorting)
        $latestBeritaRaw = Berita::latest()->take(3)->get();
        $latestPengaduanRaw = Pengaduan::latest()->take(3)->get();
        $latestGaleriRaw = Galeri::latest()->take(2)->get();

        $merged = collect()
            ->concat($latestBeritaRaw->map(fn($b) => [
                'title' => 'Berita Baru: ' . $b->judul,
                'timestamp' => $b->created_at,
                'time' => $b->created_at->diffForHumans(),
                'type' => 'Berita'
            ]))
            ->concat($latestPengaduanRaw->map(fn($p) => [
                'title' => 'Aduan Baru: ' . substr($p->pesan, 0, 40) . '...',
                'timestamp' => $p->created_at,
                'time' => $p->created_at->diffForHumans(),
                'type' => 'Pengaduan'
            ]))
            ->concat($latestGaleriRaw->map(fn($g) => [
                'title' => 'Upload Galeri: ' . $g->judul,
                'timestamp' => $g->created_at,
                'time' => $g->created_at->diffForHumans(),
                'type' => 'Galeri'
            ]))
            ->sortByDesc('timestamp')
            ->values()
            ->take(5);

        // Server Status Data
        $diskFree = disk_free_space(base_path());
        $diskTotal = disk_total_space(base_path());
        $diskUsed = $diskTotal - $diskFree;
        $storagePercentage = round(($diskUsed / $diskTotal) * 100, 1);

        $serverStatus = [
            [
                'label' => 'Storage Usage',
                'value' => $storagePercentage . '%',
                'raw' => $storagePercentage,
                'color' => 'blue',
                'detail' => round($diskUsed / (1024 * 1024 * 1024), 2) . ' GB / ' . round($diskTotal / (1024 * 1024 * 1024), 2) . ' GB'
            ],
            [
                'label' => 'Memory Peak',
                'value' => round(memory_get_peak_usage(true) / (1024 * 1024), 2) . ' MB',
                'raw' => min(100, round((memory_get_peak_usage(true) / (128 * 1024 * 1024)) * 100, 1)), // Mocking against 128MB limit
                'color' => 'violet',
                'detail' => 'PHP Runtime Limit'
            ]
        ];

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'recentActivities' => $merged,
            'pendingPengaduanCount' => $pendingPengaduan,
            'serverStatus' => $serverStatus
        ]);
    }
}
