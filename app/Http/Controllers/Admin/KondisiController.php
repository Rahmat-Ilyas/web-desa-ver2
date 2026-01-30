<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KondisiController extends Controller
{
    public function index()
    {
        $settings = Setting::whereIn('key', [
            'kondisi_deskripsi',
            'kondisi_umum',
            'kondisi_batas',
            'kondisi_iklim'
        ])->get()->pluck('value', 'key');

        return Inertia::render('Admin/Kondisi/Index', [
            'page_settings' => [
                'deskripsi' => $settings['kondisi_deskripsi'] ?? '',
                'umum' => json_decode($settings['kondisi_umum'] ?? '{}', true),
                'batas' => json_decode($settings['kondisi_batas'] ?? '{}', true),
                'iklim' => json_decode($settings['kondisi_iklim'] ?? '{}', true),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'deskripsi' => 'required|string',
            'umum' => 'required|array',
            'batas' => 'required|array',
            'iklim' => 'required|array',
        ]);

        $settings = [
            'kondisi_deskripsi' => $request->deskripsi,
            'kondisi_umum' => json_encode($request->umum),
            'kondisi_batas' => json_encode($request->batas),
            'kondisi_iklim' => json_encode($request->iklim),
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('success', 'Kondisi Kelurahan berhasil diperbarui');
    }
}
