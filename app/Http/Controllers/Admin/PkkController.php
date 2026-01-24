<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pkk;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PkkController extends Controller
{
    public function index()
    {
        $programs = Setting::where('key', 'program_pkk')->first()?->value;
        $programsArray = json_decode($programs, true);
        if (!is_array($programsArray)) {
            $programsArray = [];
        }

        return Inertia::render('Admin/Lembaga/PKK/Index', [
            'members' => Pkk::orderBy('urutan', 'asc')->get(),
            'profile' => Setting::where('key', 'profil_pkk')->first()?->value,
            'programs' => $programsArray
        ]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'profil_pkk' => 'required|string',
            'program_pkk' => 'required|array',
            'program_pkk.*' => 'required|string'
        ]);

        Setting::updateOrCreate(
            ['key' => 'profil_pkk'],
            ['value' => $request->profil_pkk]
        );

        Setting::updateOrCreate(
            ['key' => 'program_pkk'],
            ['value' => json_encode($request->program_pkk)]
        );

        return Redirect::back()->with('success', 'Profil dan Program PKK berhasil diperbarui');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'pokja' => 'required|string',
            'no_hp' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:1024',
            'urutan' => 'required|integer',
        ]);

        $data = $request->only(['nama', 'jabatan', 'pokja', 'no_hp', 'urutan']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('pkk', 'public');
        }

        Pkk::create($data);

        return Redirect::back()->with('success', 'Data pengurus PKK berhasil ditambahkan');
    }

    public function update(Request $request, Pkk $pkk)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'pokja' => 'required|string',
            'no_hp' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:1024',
            'urutan' => 'required|integer',
        ]);

        $data = $request->only(['nama', 'jabatan', 'pokja', 'no_hp', 'urutan']);

        if ($request->hasFile('foto')) {
            if ($pkk->foto) {
                Storage::disk('public')->delete($pkk->foto);
            }
            $data['foto'] = $request->file('foto')->store('pkk', 'public');
        }

        $pkk->update($data);

        return Redirect::back()->with('success', 'Data pengurus PKK berhasil diperbarui');
    }

    public function destroy(Pkk $pkk)
    {
        if ($pkk->foto) {
            Storage::disk('public')->delete($pkk->foto);
        }
        $pkk->delete();

        return Redirect::back()->with('success', 'Data pengurus PKK berhasil dihapus');
    }
}
