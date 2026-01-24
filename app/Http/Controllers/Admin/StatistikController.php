<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class StatistikController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Kependudukan/Index', [
            'settings' => Setting::all()->pluck('value', 'key')->map(function ($value, $key) {
                if (in_array($key, ['statistik_umum', 'statistik_agama', 'statistik_pendidikan', 'statistik_umur', 'statistik_pemilih'])) {
                    return json_decode($value, true);
                }
                return $value;
            })
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'statistik_umum' => 'nullable|array',
            'statistik_agama' => 'nullable|array',
            'statistik_pendidikan' => 'nullable|array',
            'statistik_umur' => 'nullable|array',
            'statistik_pemilih' => 'nullable|array',
        ]);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => json_encode($value)]
            );
        }

        return Redirect::back()->with('success', 'Data statistik penduduk berhasil diperbarui');
    }
}
