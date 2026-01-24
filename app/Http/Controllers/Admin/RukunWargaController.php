<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RukunWarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class RukunWargaController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Lembaga/RukunWarga/Index', [
            'members' => RukunWarga::orderBy('no_rw', 'asc')->get()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'no_rw' => 'required|string|max:5|unique:rukun_wargas,no_rw',
            'nama_ketua' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'foto_ketua' => 'nullable|image|max:1024', // 1MB Max
        ]);

        if ($request->hasFile('foto_ketua')) {
            $data['foto_ketua'] = $request->file('foto_ketua')->store('rukun-warga', 'public');
        }

        RukunWarga::create($data);

        return Redirect::back()->with('success', 'Data RW berhasil ditambahkan');
    }

    public function update(Request $request, RukunWarga $rukunWarga)
    {
        $data = $request->validate([
            'no_rw' => 'required|string|max:5|unique:rukun_wargas,no_rw,' . $rukunWarga->id,
            'nama_ketua' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'foto_ketua' => 'nullable|image|max:1024',
        ]);

        if ($request->hasFile('foto_ketua')) {
            // Delete old photo
            if ($rukunWarga->foto_ketua) {
                Storage::disk('public')->delete($rukunWarga->foto_ketua);
            }
            $data['foto_ketua'] = $request->file('foto_ketua')->store('rukun-warga', 'public');
        }

        $rukunWarga->update($data);

        return Redirect::back()->with('success', 'Data RW berhasil diperbarui');
    }

    public function destroy(RukunWarga $rukunWarga)
    {
        if ($rukunWarga->foto_ketua) {
            Storage::disk('public')->delete($rukunWarga->foto_ketua);
        }

        $rukunWarga->delete();

        return Redirect::back()->with('success', 'Data RW berhasil dihapus');
    }
}
