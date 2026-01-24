<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Potensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PotensiController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Potensi/Index', [
            'potensis' => Potensi::latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'deskripsi' => 'required|string',
            'lokasi' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('potensi', 'public');
            $data['image'] = $path;
        }

        Potensi::create($data);

        return Redirect::back()->with('success', 'Potensi desa berhasil ditambahkan');
    }

    public function update(Request $request, Potensi $potensi)
    {
        $rules = [
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'deskripsi' => 'required|string',
            'lokasi' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];

        $data = $request->validate($rules);

        if ($request->hasFile('image')) {
            if ($potensi->image) {
                Storage::disk('public')->delete($potensi->image);
            }
            $path = $request->file('image')->store('potensi', 'public');
            $data['image'] = $path;
        } else {
            unset($data['image']);
        }

        $potensi->update($data);

        return Redirect::back()->with('success', 'Potensi desa berhasil diperbarui');
    }

    public function destroy(Potensi $potensi)
    {
        if ($potensi->image) {
            Storage::disk('public')->delete($potensi->image);
        }
        $potensi->delete();

        return Redirect::back()->with('success', 'Potensi desa berhasil dihapus');
    }
}
