<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RukunTetangga;
use App\Models\RukunWarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class RukunTetanggaController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Lembaga/RukunTetangga/Index', [
            'members' => RukunTetangga::with('rukunWarga')->orderBy('no_rt', 'asc')->get(),
            'rws' => RukunWarga::orderBy('no_rw', 'asc')->get()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'rukun_warga_id' => 'required|exists:rukun_wargas,id',
            'no_rt' => 'required|string|max:5',
            'nama_ketua' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'foto_ketua' => 'nullable|image|max:1024',
        ]);

        if ($request->hasFile('foto_ketua')) {
            $data['foto_ketua'] = $request->file('foto_ketua')->store('rukun-tetangga', 'public');
        }

        RukunTetangga::create($data);

        return Redirect::back()->with('success', 'Data RT berhasil ditambahkan');
    }

    public function update(Request $request, RukunTetangga $rukunTetangga)
    {
        $data = $request->validate([
            'rukun_warga_id' => 'required|exists:rukun_wargas,id',
            'no_rt' => 'required|string|max:5',
            'nama_ketua' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'foto_ketua' => 'nullable|image|max:1024',
        ]);

        if ($request->hasFile('foto_ketua')) {
            if ($rukunTetangga->foto_ketua) {
                Storage::disk('public')->delete($rukunTetangga->foto_ketua);
            }
            $data['foto_ketua'] = $request->file('foto_ketua')->store('rukun-tetangga', 'public');
        }

        $rukunTetangga->update($data);

        return Redirect::back()->with('success', 'Data RT berhasil diperbarui');
    }

    public function destroy(RukunTetangga $rukunTetangga)
    {
        if ($rukunTetangga->foto_ketua) {
            Storage::disk('public')->delete($rukunTetangga->foto_ketua);
        }

        $rukunTetangga->delete();

        return Redirect::back()->with('success', 'Data RT berhasil dihapus');
    }
}
