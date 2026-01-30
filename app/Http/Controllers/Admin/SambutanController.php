<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SambutanController extends Controller
{
    public function index()
    {
        $settings = Setting::whereIn('key', [
            'sambutan_quote',
            'sambutan_message'
        ])->get()->pluck('value', 'key');

        $lurah = \App\Models\Structure::where('level', 1)->first();

        return Inertia::render('Admin/Sambutan/Index', [
            'page_settings' => [
                'sambutan_quote' => $settings['sambutan_quote'] ?? '',
                'sambutan_message' => $settings['sambutan_message'] ?? ''
            ],
            'lurah' => $lurah
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'sambutan_quote' => 'required|string',
            'sambutan_message' => 'required|string',
        ]);

        $data = $request->only(['sambutan_quote', 'sambutan_message']);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('success', 'Sambutan berhasil diperbarui');
    }
}
