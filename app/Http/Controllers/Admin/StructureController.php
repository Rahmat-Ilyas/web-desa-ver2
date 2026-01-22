<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Structure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class StructureController extends Controller
{
    public function index()
    {
        $structures = Structure::with('parent')->orderBy('level')->orderBy('order')->get();
        $parents = Structure::where('level', '<', 4)->get(); // Limit parents to non-staff levels for simplicity

        return Inertia::render('Admin/Structure/Index', [
            'structures' => $structures,
            'parents' => $parents
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'level' => 'required|integer|min:1|max:4',
            'parent_id' => 'nullable|exists:structures,id',
            'order' => 'integer',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Check for unique Lurah/Sekretaris
        $level = (int) $request->level;
        if (in_array($level, [1, 2])) {
            if (Structure::where('level', $level)->exists()) {
                $role = $level == 1 ? 'Lurah' : 'Sekretaris';

                return redirect()->back()->withErrors([
                    'level' => "Jabatan $role sudah terisi. Hanya boleh ada satu data untuk jabatan ini."
                ])->withInput();
            }
        }

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('structures', 'public');
        }

        Structure::create($data);

        return back()->with('success', 'Anggota struktur berhasil ditambahkan');
    }

    public function update(Request $request, Structure $structure)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'level' => 'required|integer|min:1|max:4',
            'parent_id' => 'nullable|exists:structures,id',
            'order' => 'integer',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Check for unique Lurah/Sekretaris
        $level = (int) $request->level;
        if (in_array($level, [1, 2])) {
            if (Structure::where('level', $level)->where('id', '!=', $structure->id)->exists()) {
                $role = $level == 1 ? 'Lurah' : 'Sekretaris';

                return redirect()->back()->withErrors([
                    'level' => "Jabatan $role sudah terisi. Hanya boleh ada satu data untuk jabatan ini."
                ])->withInput();
            }
        }

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            if ($structure->photo) {
                Storage::disk('public')->delete($structure->photo);
            }
            $data['photo'] = $request->file('photo')->store('structures', 'public');
        }

        $structure->update($data);

        return back()->with('success', 'Anggota struktur berhasil diperbarui');
    }

    public function destroy(Structure $structure)
    {
        if ($structure->photo) {
            Storage::disk('public')->delete($structure->photo);
        }
        $structure->delete();

        return back()->with('success', 'Anggota struktur berhasil dihapus');
    }
}
