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
        $data = $request->validate([
            'web_name' => 'nullable|string',
            'web_description' => 'nullable|string',
            'web_keywords' => 'nullable|string',
            'footer_text' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|string',
        ]);

        foreach ($data as $key => $value) {
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
}
