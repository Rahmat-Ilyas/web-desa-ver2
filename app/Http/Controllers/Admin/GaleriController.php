<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galeris = Galeri::latest()->paginate(10);
        return inertia('Admin/Galeri/Index', [
            'galeris' => $galeris
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:Kegiatan,Pembangunan,Sosial,Keagamaan',
            'image' => 'required|image|max:2048', // Max 2MB
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('galeri', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        Galeri::create($validated);

        return redirect()->back()->with('success', 'Foto berhasil ditambahkan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Galeri $galeri)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:Kegiatan,Pembangunan,Sosial,Keagamaan',
            'image' => 'nullable|image|max:2048',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            $oldPath = str_replace('/storage/', '', $galeri->image);
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($oldPath)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('image')->store('galeri', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        $galeri->update($validated);

        return redirect()->back()->with('success', 'Foto berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Galeri $galeri)
    {
        // Delete image
        $oldPath = str_replace('/storage/', '', $galeri->image);
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($oldPath)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
        }

        $galeri->delete();

        return redirect()->back()->with('success', 'Foto berhasil dihapus');
    }
}
