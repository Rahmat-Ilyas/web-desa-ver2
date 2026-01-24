<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tahun = request('tahun', date('Y'));
        $anggaran = \App\Models\Anggaran::where('tahun', $tahun)->get();
        // Get available years for filter
        $years = \App\Models\Anggaran::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun')->toArray();

        // Add current year if not present
        if (!in_array(date('Y'), $years)) {
            $years[] = date('Y');
        }

        // Ensure unique and sorted ascending
        $years = array_unique($years);
        sort($years);

        return inertia('Admin/Anggaran/Index', [
            'anggaran' => $anggaran,
            'tahun' => $tahun,
            'years' => array_values($years)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'required|digits:4|integer',
            'kategori' => 'required|in:pendapatan,belanja',
            'nama' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
        ]);

        \App\Models\Anggaran::create($validated);

        return back()->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'tahun' => 'required|digits:4|integer',
            'kategori' => 'required|in:pendapatan,belanja',
            'nama' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
        ]);

        $anggaran = \App\Models\Anggaran::findOrFail($id);
        $anggaran->update($validated);

        return back()->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $anggaran = \App\Models\Anggaran::findOrFail($id);
        $anggaran->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}
