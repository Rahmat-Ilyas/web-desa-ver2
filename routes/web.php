<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('landing');

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
    return inertia('Lembaga/RT');
})->name('lembaga.rt');

Route::get('/lembaga/rw', function () {
    return inertia('Lembaga/RW');
})->name('lembaga.rw');

Route::get('/lembaga/pkk', function () {
    return inertia('Lembaga/PKK');
})->name('lembaga.pkk');

Route::get('/lembaga/karang-taruna', function () {
    return inertia('Lembaga/KarangTaruna');
})->name('lembaga.karang-taruna');

Route::get('/lembaga/lpmk', function () {
    return inertia('Lembaga/LPMK');
})->name('lembaga.lpmk');

Route::get('/lembaga/majelis-taklim', function () {
    return inertia('Lembaga/MajelisTaklim');
})->name('lembaga.majelis-taklim');

// Pemerintahan Routes
Route::get('/pemerintahan/aparatur', [HomeController::class, 'aparatur'])->name('pemerintahan.aparatur');

Route::get('/pemerintahan/anggaran', function () {
    return inertia('Pemerintahan/Anggaran');
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
    return inertia('Download/Index');
})->name('download');

// Informasi Routes
Route::get('/informasi/berita', [HomeController::class, 'berita'])->name('informasi.berita');
Route::get('/informasi/berita/{slug}', [HomeController::class, 'beritaDetail'])->name('informasi.berita.show');

Route::get('/informasi/potensi', function () {
    return inertia('Informasi/Potensi');
})->name('informasi.potensi');

Route::get('/informasi/program', function () {
    return inertia('Informasi/Program');
})->name('informasi.program');

// Layanan Route
Route::get('/layanan', function () {
    return inertia('Layanan/Index');
})->name('layanan');

// Pengaduan Route
Route::get('/pengaduan', function () {
    return inertia('Pengaduan/Index');
})->name('pengaduan');

// Home route needed for some redirects
Route::get('/home', function () {
    return redirect()->route('admin.dashboard');
})->name('home');

// Admin Routes protected by Auth
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', function () {
        return inertia('Admin/Dashboard');
    })->name('admin.dashboard');

    Route::get('/kontak', function () {
        return inertia('Admin/Kontak/Index');
    })->name('admin.kontak');

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
});
