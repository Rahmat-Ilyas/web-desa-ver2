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
}
