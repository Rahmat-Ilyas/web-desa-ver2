<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SettingController extends Controller
{
    public function updateKonfigurasi(Request $request)
    {
        if ($request->reset_logo) {
            Setting::where('key', 'logo')->delete();
            return Redirect::back()->with('success', 'Logo dikembalikan ke default');
        }

        $data = $request->validate([
            'web_name' => 'nullable|string',
            'web_description' => 'nullable|string',
            'web_keywords' => 'nullable|string',
            'sebutan_wilayah' => 'nullable|string',
            'nama_wilayah' => 'nullable|string',
            'sebutan_kepala' => 'nullable|string',
            'nama_kabupaten' => 'nullable|string',
            'website_url' => 'nullable|url',
            'logo' => 'nullable|image|max:2048',
        ]);

        foreach ($data as $key => $value) {
            if ($key === 'logo') {
                if ($request->hasFile($key)) {
                    $path = $request->file($key)->store('settings', 'public');
                    Setting::updateOrCreate(
                        ['key' => $key],
                        ['value' => '/storage/' . $path]
                    );
                }
                continue;
            }

            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return Redirect::back()->with('success', 'Konfigurasi web berhasil diperbarui');
    }

    public function updateKontak(Request $request)
    {
        $request->validate([
            'alamat' => 'nullable|string',
            'email' => 'nullable|string',
            'telepon' => 'nullable|string',
            'whatsapp' => 'nullable|string',
            'instagram' => 'nullable|string',
            'facebook' => 'nullable|string',
            'twitter' => 'nullable|string',
            'youtube' => 'nullable|string',
        ]);

        Setting::updateOrCreate(
            ['key' => 'info_umum'],
            ['value' => json_encode($request->only(['alamat', 'email', 'telepon', 'whatsapp']))]
        );

        Setting::updateOrCreate(
            ['key' => 'sosial_media'],
            ['value' => json_encode($request->only(['instagram', 'facebook', 'twitter', 'youtube']))]
        );

        return Redirect::back()->with('success', 'Informasi kontak berhasil diperbarui');
    }

    public function updateModules(Request $request)
    {
        $modules = $request->validate([
            'modul_berita' => 'boolean',
            'modul_galeri' => 'boolean',
            'modul_download' => 'boolean',
            'modul_layanan' => 'boolean',
            'modul_pengaduan' => 'boolean',
            'modul_statistik' => 'boolean',
            'modul_potensi' => 'boolean',
            'modul_program' => 'boolean',
            'modul_lembaga_rt_rw' => 'boolean',
            'modul_lembaga_pkk' => 'boolean',
            'modul_lembaga_karang_taruna' => 'boolean',
            'modul_lembaga_lpmk' => 'boolean',
            'modul_lembaga_majelis_taklim' => 'boolean',
            
            // Profil
            'modul_profil_sambutan' => 'boolean',
            'modul_profil_visimisi' => 'boolean',
            'modul_profil_sejarah' => 'boolean',
            'modul_profil_kondisi' => 'boolean',
            'modul_profil_lokasi' => 'boolean',
            'modul_profil_peta' => 'boolean',

            // Data
            'modul_data_penduduk' => 'boolean',
            'modul_data_umur' => 'boolean',
            'modul_data_agama' => 'boolean',
            'modul_data_pendidikan' => 'boolean',
            'modul_data_pemilih' => 'boolean',

            // Pemerintahan
            'modul_pemerintahan_aparatur' => 'boolean',
            'modul_pemerintahan_anggaran' => 'boolean',
        ]);

        Setting::updateOrCreate(
            ['key' => 'module_status'],
            ['value' => json_encode($modules)]
        );

        return Redirect::back()->with('success', 'Konfigurasi modul berhasil diperbarui');
    }

    public function updateAppearance(Request $request)
    {
        // Handle Resets
        if ($request->reset_bg) {
            Setting::whereIn('key', ['hero_video', 'hero_slider'])->delete();
            Setting::updateOrCreate(['key' => 'hero_bg_type'], ['value' => 'video']);
            return Redirect::back()->with('success', 'Latar belakang dikembalikan ke default');
        }

        if ($request->reset_covers) {
            Setting::whereIn('key', ['cover_pkk', 'cover_karang_taruna', 'cover_majelis_taklim'])->delete();
            return Redirect::back()->with('success', 'Gambar sampul lembaga dikembalikan ke default');
        }

        $validated = $request->validate([
            'hero_title' => 'nullable|string|max:100',
            'hero_subtitle' => 'nullable|string|max:150',
            'hero_description' => 'nullable|string|max:255',
            'hero_bg_type' => 'required|in:video,slider',
            'hero_video' => 'nullable|file|mimes:mp4,webm,ogg|max:20480', // Max 20MB
            'hero_slider' => 'nullable|array',
            'hero_slider.*' => 'image|max:2048',
            'cover_pkk' => 'nullable|image|max:2048',
            'cover_karang_taruna' => 'nullable|image|max:2048',
            'cover_majelis_taklim' => 'nullable|image|max:2048',
        ]);

        // Text settings
        $textSettings = ['hero_title', 'hero_subtitle', 'hero_description', 'hero_bg_type'];
        foreach ($textSettings as $key) {
            if ($request->has($key)) {
                Setting::updateOrCreate(['key' => $key], ['value' => $request->get($key)]);
            }
        }

        // Handle Video
        if ($request->hasFile('hero_video')) {
            $path = $request->file('hero_video')->store('appearance', 'public');
            Setting::updateOrCreate(['key' => 'hero_video'], ['value' => '/storage/' . $path]);
        }

        // Handle Slider Images
        if ($request->hasFile('hero_slider')) {
            $paths = [];
            $files = $request->file('hero_slider');
            // Ensure $files is an array (multi-upload normally is)
            if (!is_array($files)) {
                $files = [$files];
            }
            foreach ($files as $file) {
                $path = $file->store('appearance', 'public');
                $paths[] = '/storage/' . $path;
            }
            Setting::updateOrCreate(['key' => 'hero_slider'], ['value' => json_encode($paths)]);
        }

        // Handle Lembaga Covers
        $covers = ['cover_pkk', 'cover_karang_taruna', 'cover_majelis_taklim'];
        foreach ($covers as $key) {
            if ($request->hasFile($key)) {
                $path = $request->file($key)->store('appearance', 'public');
                Setting::updateOrCreate(['key' => $key], ['value' => '/storage/' . $path]);
            }
        }

        return Redirect::back()->with('success', 'Pengaturan tampilan berhasil diperbarui');
    }

    public function updatePotensiCategories(Request $request)
    {
        $request->validate([
            'categories' => 'required|array',
            'categories.*' => 'required|string|max:50',
        ]);

        Setting::updateOrCreate(
            ['key' => 'potensi_categories'],
            ['value' => json_encode($request->categories)]
        );

        return Redirect::back()->with('success', 'Kategori potensi berhasil diperbarui');
    }
}
