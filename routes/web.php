<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('landing');
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index']);

Route::get('/profil/sambutan', [HomeController::class, 'sambutan'])->name('profil.sambutan');

Route::get('/profil/visi-misi', [HomeController::class, 'visimisi'])->name('profil.visimisi');

Route::get('/profil/sejarah', [HomeController::class, 'sejarah'])->name('profil.sejarah');

Route::get('/profil/kondisi', [HomeController::class, 'kondisi'])->name('profil.kondisi');

Route::get('/profil/lokasi-kantor', function () {
    return inertia('Profil/LokasiKantor');
})->name('profil.lokasi-kantor');

Route::get('/profil/peta-lokasi', function () {
    return inertia('Profil/PetaLokasi');
})->name('profil.peta-lokasi');

// Lembaga Routes
Route::get('/lembaga/rt', function () {
    return inertia('Lembaga/RT', [
        'members' => \App\Models\RukunTetangga::with('rukunWarga')->orderBy('no_rt', 'asc')->get()
    ]);
})->name('lembaga.rt');

Route::get('/lembaga/rw', function () {
    return inertia('Lembaga/RW', [
        'members' => \App\Models\RukunWarga::orderBy('no_rw', 'asc')->get()
    ]);
})->name('lembaga.rw');

Route::get('/lembaga/pkk', function () {
    $programs = \App\Models\Setting::where('key', 'program_pkk')->first()?->value;
    $programsArray = json_decode($programs, true);
    if (!is_array($programsArray)) {
        $programsArray = $programs ? explode("\n", $programs) : [];
    }

    return inertia('Lembaga/PKK', [
        'members' => \App\Models\Pkk::orderBy('urutan', 'asc')->get(),
        'profile' => \App\Models\Setting::where('key', 'profil_pkk')->first()?->value,
        'programs' => $programsArray
    ]);
})->name('lembaga.pkk');

Route::get('/lembaga/karang-taruna', function () {
    $tasks = \App\Models\Setting::where('key', 'tugas_karang_taruna')->first()?->value;
    $tasksArray = json_decode($tasks, true);
    if (!is_array($tasksArray)) {
        $tasksArray = $tasks ? explode("\n", $tasks) : [];
    }

    return inertia('Lembaga/KarangTaruna', [
        'members' => \App\Models\KarangTaruna::orderBy('urutan', 'asc')->get(),
        'profile' => \App\Models\Setting::where('key', 'profil_karang_taruna')->first()?->value,
        'tasks' => $tasksArray
    ]);
})->name('lembaga.karang-taruna');

Route::get('/lembaga/lpmk', function () {
    $tasks = \App\Models\Setting::where('key', 'tugas_lpmk')->first()?->value;
    $tasksArray = json_decode($tasks, true);
    if (!is_array($tasksArray)) {
        $tasksArray = $tasks ? explode("\n", $tasks) : [];
    }

    return inertia('Lembaga/LPMK', [
        'members' => \App\Models\Lpmk::orderBy('urutan', 'asc')->get(),
        'profile' => \App\Models\Setting::where('key', 'profil_lpmk')->first()?->value,
        'tasks' => $tasksArray
    ]);
})->name('lembaga.lpmk');

Route::get('/lembaga/majelis-taklim', function () {
    $activities = \App\Models\Setting::where('key', 'kegiatan_majelis_taklim')->first()?->value;
    $activitiesArray = json_decode($activities, true);
    if (!is_array($activitiesArray)) {
        $activitiesArray = $activities ? explode("\n", $activities) : [];
    }

    return inertia('Lembaga/MajelisTaklim', [
        'members' => \App\Models\MajelisTaklim::orderBy('urutan', 'asc')->get(),
        'profile' => \App\Models\Setting::where('key', 'profil_majelis_taklim')->first()?->value,
        'activities' => $activitiesArray
    ]);
})->name('lembaga.majelis-taklim');

// Pemerintahan Routes
Route::get('/pemerintahan/aparatur', [HomeController::class, 'aparatur'])->name('pemerintahan.aparatur');

Route::get('/pemerintahan/anggaran', function () {
    $tahun = request('tahun', date('Y'));
    $anggaran = \App\Models\Anggaran::where('tahun', $tahun)->get();

    // Get available years for filter
    $years = \App\Models\Anggaran::select('tahun')->distinct()->orderBy('tahun', 'asc')->pluck('tahun')->toArray();

    // Add current year if not present
    if (!in_array(date('Y'), $years)) {
        $years[] = date('Y');
    }

    // Ensure unique and sorted ascending
    $years = array_unique($years);
    sort($years);

    return inertia('Pemerintahan/Anggaran', [
        'anggaran' => $anggaran,
        'tahun' => $tahun,
        'years' => array_values($years)
    ]);
})->name('pemerintahan.anggaran');

// Data Routes
Route::get('/data/statistik', function () {
    return inertia('Data/Statistik');
})->name('data.statistik');

Route::get('/data/umur', function () {
    return inertia('Data/Umur');
})->name('data.umur');

Route::get('/data/pemilih', function () {
    return inertia('Data/Pemilih');
})->name('data.pemilih');

Route::get('/data/agama', function () {
    return inertia('Data/Agama');
})->name('data.agama');

Route::get('/data/pendidikan', function () {
    return inertia('Data/Pendidikan');
})->name('data.pendidikan');

// Galeri & Download Routes
Route::get('/galeri', [HomeController::class, 'galeri'])->name('galeri');

Route::get('/download', function () {
    $downloads = \App\Models\Download::orderBy('created_at', 'desc')->get();
    return inertia('Download/Index', [
        'downloads' => $downloads
    ]);
})->name('download');

// Informasi Routes
Route::get('/informasi/berita', [HomeController::class, 'berita'])->name('informasi.berita');
Route::get('/informasi/berita/{slug}', [HomeController::class, 'beritaDetail'])->name('informasi.berita.show');

Route::get('/informasi/potensi', function () {
    $categories = \App\Models\Setting::where('key', 'potensi_categories')->first();
    $categories = $categories ? json_decode($categories->value, true) : ['Wisata Alam', 'UMKM & Produk', 'Pertanian', 'Seni Budaya', 'Kuliner'];

    return inertia('Informasi/Potensi', [
        'potensis' => \App\Models\Potensi::latest()->get(),
        'categories' => $categories
    ]);
})->name('informasi.potensi');

Route::get('/informasi/program', function () {
    return inertia('Informasi/Program', [
        'programs' => \App\Models\Program::latest()->get()
    ]);
})->name('informasi.program');

// Layanan Route
Route::get('/layanan', function () {
    return inertia('Layanan/Index', [
        'services' => \App\Models\Layanan::orderBy('order')->get()
    ]);
})->name('layanan');

// Pengaduan Route
Route::get('/pengaduan', [\App\Http\Controllers\PengaduanController::class, 'index'])->name('pengaduan');
Route::post('/pengaduan', [\App\Http\Controllers\PengaduanController::class, 'store'])->name('pengaduan.store');
Route::post('/pengaduan/track', [\App\Http\Controllers\PengaduanController::class, 'track'])->name('pengaduan.track');


// Home route needed for some redirects
Route::get('/home', function () {
    return redirect()->route('admin.dashboard');
})->name('home');

// Admin Routes protected by Auth
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/kontak', function () {
        $info_umum = \App\Models\Setting::where('key', 'info_umum')->first();
        $sosial_media = \App\Models\Setting::where('key', 'sosial_media')->first();

        return inertia('Admin/Kontak/Index', [
            'settings' => [
                'info_umum' => $info_umum ? json_decode($info_umum->value, true) : [],
                'sosial_media' => $sosial_media ? json_decode($sosial_media->value, true) : []
            ]
        ]);
    })->name('admin.kontak');

    Route::post('/kontak', [\App\Http\Controllers\Admin\SettingController::class, 'updateKontak'])->name('admin.kontak.update');

    // Struktur Organisasi
    Route::get('/struktur', [\App\Http\Controllers\Admin\StructureController::class, 'index'])->name('admin.struktur.index');
    Route::post('/struktur', [\App\Http\Controllers\Admin\StructureController::class, 'store'])->name('admin.struktur.store');
    Route::post('/struktur/{structure}', [\App\Http\Controllers\Admin\StructureController::class, 'update'])->name('admin.struktur.update');
    Route::delete('/struktur/{structure}', [\App\Http\Controllers\Admin\StructureController::class, 'destroy'])->name('admin.struktur.destroy');

    // Sambutan Lurah
    Route::get('/sambutan', [\App\Http\Controllers\Admin\SambutanController::class, 'index'])->name('admin.sambutan.index');
    Route::post('/sambutan', [\App\Http\Controllers\Admin\SambutanController::class, 'store'])->name('admin.sambutan.store');

    // Visi Misi
    Route::get('/visi-misi', [\App\Http\Controllers\Admin\VisiMisiController::class, 'index'])->name('admin.visimisi.index');
    Route::post('/visi-misi', [\App\Http\Controllers\Admin\VisiMisiController::class, 'store'])->name('admin.visimisi.store');

    // Sejarah
    Route::get('/sejarah', [\App\Http\Controllers\Admin\SejarahController::class, 'index'])->name('admin.sejarah.index');
    Route::post('/sejarah/intro', [\App\Http\Controllers\Admin\SejarahController::class, 'updateIntro'])->name('admin.sejarah.intro');
    Route::post('/sejarah/timeline', [\App\Http\Controllers\Admin\SejarahController::class, 'storeTimeline'])->name('admin.sejarah.timeline.store');
    Route::post('/sejarah/timeline/{timeline}', [\App\Http\Controllers\Admin\SejarahController::class, 'updateTimeline'])->name('admin.sejarah.timeline.update');
    Route::delete('/sejarah/timeline/{timeline}', [\App\Http\Controllers\Admin\SejarahController::class, 'destroyTimeline'])->name('admin.sejarah.timeline.destroy');

    // Kondisi Kelurahan
    Route::get('/kondisi', [\App\Http\Controllers\Admin\KondisiController::class, 'index'])->name('admin.kondisi.index');
    Route::post('/kondisi', [\App\Http\Controllers\Admin\KondisiController::class, 'store'])->name('admin.kondisi.store');

    // Berita
    Route::resource('berita', \App\Http\Controllers\Admin\BeritaController::class)->names([
        'index' => 'admin.berita.index',
        'create' => 'admin.berita.create',
        'store' => 'admin.berita.store',
        'edit' => 'admin.berita.edit',
        'update' => 'admin.berita.update',
        'destroy' => 'admin.berita.destroy',
    ]);
    // Galeri
    Route::resource('galeri', \App\Http\Controllers\Admin\GaleriController::class)->names([
        'index' => 'admin.galeri.index',
        'create' => 'admin.galeri.create',
        'store' => 'admin.galeri.store',
        'edit' => 'admin.galeri.edit',
        'update' => 'admin.galeri.update',
        'destroy' => 'admin.galeri.destroy',
    ]);

    // Anggaran
    Route::resource('anggaran', \App\Http\Controllers\Admin\AnggaranController::class)->names([
        'index' => 'admin.anggaran.index',
        'store' => 'admin.anggaran.store',
        'update' => 'admin.anggaran.update',
        'destroy' => 'admin.anggaran.destroy',
    ])->except(['create', 'edit', 'show']);

    // Download
    Route::resource('download', \App\Http\Controllers\Admin\DownloadController::class)->names([
        'index' => 'admin.download.index',
        'create' => 'admin.download.create',
        'store' => 'admin.download.store',
        'edit' => 'admin.download.edit',
        'update' => 'admin.download.update',
        'destroy' => 'admin.download.destroy',
    ]);

    // Pengaduan
    Route::resource('pengaduan', \App\Http\Controllers\Admin\PengaduanController::class)->names([
        'index' => 'admin.pengaduan.index',
        'update' => 'admin.pengaduan.update',
        'destroy' => 'admin.pengaduan.destroy',
    ])->only(['index', 'update', 'destroy']);

    // Layanan
    Route::post('/layanan/order', [\App\Http\Controllers\Admin\LayananController::class, 'updateOrder'])->name('admin.layanan.order');
    Route::resource('layanan', \App\Http\Controllers\Admin\LayananController::class)->names([
        'index' => 'admin.layanan.index',
        'store' => 'admin.layanan.store',
        'update' => 'admin.layanan.update',
        'destroy' => 'admin.layanan.destroy',
    ])->except(['create', 'edit', 'show']);


    // Potensi Desa
    Route::post('/potensi/categories', [\App\Http\Controllers\Admin\SettingController::class, 'updatePotensiCategories'])->name('admin.potensi.categories.update');
    Route::resource('potensi', \App\Http\Controllers\Admin\PotensiController::class)->names([
        'index' => 'admin.potensi.index',
        'store' => 'admin.potensi.store',
        'update' => 'admin.potensi.update',
        'destroy' => 'admin.potensi.destroy',
    ])->except(['create', 'edit', 'show']);

    // Program Kerja
    Route::resource('program', \App\Http\Controllers\Admin\ProgramController::class)->names([
        'index' => 'admin.program.index',
        'store' => 'admin.program.store',
        'update' => 'admin.program.update',
        'destroy' => 'admin.program.destroy',
    ])->except(['create', 'edit', 'show']);

    // Lembaga Kelurahan Routes
    Route::resource('rukun-warga', \App\Http\Controllers\Admin\RukunWargaController::class)->names([
        'index' => 'admin.rukun-warga.index',
        'store' => 'admin.rukun-warga.store',
        'update' => 'admin.rukun-warga.update',
        'destroy' => 'admin.rukun-warga.destroy',
    ])->except(['create', 'edit', 'show']);

    Route::resource('rukun-tetangga', \App\Http\Controllers\Admin\RukunTetanggaController::class)->names([
        'index' => 'admin.rukun-tetangga.index',
        'store' => 'admin.rukun-tetangga.store',
        'update' => 'admin.rukun-tetangga.update',
        'destroy' => 'admin.rukun-tetangga.destroy',
    ])->except(['create', 'edit', 'show']);

    Route::put('pkk/profile', [\App\Http\Controllers\Admin\PkkController::class, 'updateProfile'])->name('admin.pkk.profile.update');
    Route::resource('pkk', \App\Http\Controllers\Admin\PkkController::class)->names([
        'index' => 'admin.pkk.index',
        'store' => 'admin.pkk.store',
        'update' => 'admin.pkk.update',
        'destroy' => 'admin.pkk.destroy',
    ])->except(['create', 'edit', 'show']);

    Route::put('karang-taruna/profile', [\App\Http\Controllers\Admin\KarangTarunaController::class, 'updateProfile'])->name('admin.karang-taruna.profile.update');
    Route::resource('karang-taruna', \App\Http\Controllers\Admin\KarangTarunaController::class)->names([
        'index' => 'admin.karang-taruna.index',
        'store' => 'admin.karang-taruna.store',
        'update' => 'admin.karang-taruna.update',
        'destroy' => 'admin.karang-taruna.destroy',
    ])->except(['create', 'edit', 'show']);

    Route::put('lpmk/profile', [\App\Http\Controllers\Admin\LpmkController::class, 'updateProfile'])->name('admin.lpmk.profile.update');
    Route::resource('lpmk', \App\Http\Controllers\Admin\LpmkController::class)->names([
        'index' => 'admin.lpmk.index',
        'store' => 'admin.lpmk.store',
        'update' => 'admin.lpmk.update',
        'destroy' => 'admin.lpmk.destroy',
    ])->except(['create', 'edit', 'show']);

    Route::put('majelis-taklim/profile', [\App\Http\Controllers\Admin\MajelisTaklimController::class, 'updateProfile'])->name('admin.majelis-taklim.profile.update');
    Route::resource('majelis-taklim', \App\Http\Controllers\Admin\MajelisTaklimController::class)->names([
        'index' => 'admin.majelis-taklim.index',
        'store' => 'admin.majelis-taklim.store',
        'update' => 'admin.majelis-taklim.update',
        'destroy' => 'admin.majelis-taklim.destroy',
    ])->except(['create', 'edit', 'show']);

    // Statistik Penduduk (Kependudukan)
    Route::get('/kependudukan', [\App\Http\Controllers\Admin\StatistikController::class, 'index'])->name('admin.kependudukan.index');
    Route::post('/statistik', [\App\Http\Controllers\Admin\StatistikController::class, 'update'])->name('admin.statistik.update');

    // Profile Settings
    Route::get('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('admin.profile.index');
    Route::post('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('admin.profile.update');

    // Konfigurasi Web
    Route::get('/konfigurasi', function () {
        return inertia('Admin/Konfigurasi/Index', [
            'settings' => \App\Models\Setting::all()->pluck('value', 'key')->map(function ($value, $key) {
                if (
                    in_array($key, [
                        'statistik_umum',
                        'statistik_agama',
                        'statistik_pendidikan',
                        'statistik_umur',
                        'statistik_pemilih',
                        'module_status',
                        'info_umum',
                        'sosial_media',
                        'hero_slider'
                    ])
                ) {
                    return json_decode($value, true);
                }
                return $value;
            })
        ]);
    })->name('admin.konfigurasi');

    Route::post('/konfigurasi', [\App\Http\Controllers\Admin\SettingController::class, 'updateKonfigurasi'])->name('admin.konfigurasi.update');
    Route::post('/konfigurasi/modules', [\App\Http\Controllers\Admin\SettingController::class, 'updateModules'])->name('admin.konfigurasi.modules.update');
    Route::post('/konfigurasi/appearance', [\App\Http\Controllers\Admin\SettingController::class, 'updateAppearance'])->name('admin.konfigurasi.appearance.update');
});
