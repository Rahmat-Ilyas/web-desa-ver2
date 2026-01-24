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
            'dpt_file' => 'nullable|file|mimes:pdf,xls,xlsx,doc,docx|max:10240', // Max 10MB
        ]);

        if ($request->hasFile('dpt_file')) {
            $file = $request->file('dpt_file');
            $path = $file->store('dpt', 'public');
            Setting::updateOrCreate(
                ['key' => 'dpt_file_path'],
                ['value' => '/storage/' . $path]
            );
        }

        unset($data['dpt_file']); // Don't try to json_encode the file object

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => json_encode($value)]
            );
        }

        return Redirect::back()->with('success', 'Data statistik penduduk berhasil diperbarui');
    }
}
