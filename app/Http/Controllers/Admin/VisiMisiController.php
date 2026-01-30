<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VisiMisiController extends Controller
{
    public function index()
    {
        $settings = Setting::whereIn('key', [
            'visi',
            'misi'
        ])->get()->pluck('value', 'key');

        $misi = $settings['misi'] ?? '[]';
        // Attempt to decode, fallback to empty array if fail (or if it was a plan string previously)
        $misiArray = json_decode($misi, true);
        if (!is_array($misiArray)) {
            // If existing data was a string (CKEditor HTML), we might want to discard it or wrap it.
            // For simplicity in this migration, let's start fresh or wrap in array if not empty
            $misiArray = $misi ? [$misi] : [];
            // Actually, since we are moving away from HTML, better to start fresh or try to strip tags?
            // Let's just return empty [] if not valid json to avoid breaking the new UI
            $misiArray = [];
        }

        return Inertia::render('Admin/VisiMisi/Index', [
            'page_settings' => [
                'visi' => $settings['visi'] ?? '',
                'misi' => $misiArray
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'visi' => 'required|string',
            'misi' => 'required|array',
            'misi.*' => 'required|string',
        ]);

        $data = $request->only(['visi', 'misi']);
        $data['misi'] = json_encode($data['misi']);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('success', 'Visi & Misi berhasil diperbarui');
    }
}
