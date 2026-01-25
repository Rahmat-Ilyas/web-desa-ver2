<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MajelisTaklim;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class MajelisTaklimController extends Controller
{
    public function index()
    {
        $activities = Setting::where('key', 'kegiatan_majelis_taklim')->first()?->value;
        $activitiesArray = json_decode($activities, true);
        if (!is_array($activitiesArray)) {
            $activitiesArray = [];
        }

        // Normalize activities to objects {name, icon}
        $activitiesArray = array_map(function ($item, $index) {
            if (is_array($item))
                return $item;
            $icons = ['fa-quran', 'fa-mosque', 'fa-hand-holding-heart', 'fa-pray', 'fa-book-open', 'fa-users'];
            return [
                'name' => $item,
                'icon' => $icons[$index % count($icons)]
            ];
        }, $activitiesArray, array_keys($activitiesArray));

        return Inertia::render('Admin/Lembaga/MajelisTaklim/Index', [
            'members' => MajelisTaklim::orderBy('urutan', 'asc')->get(),
            'profile' => Setting::where('key', 'profil_majelis_taklim')->first()?->value,
            'activities' => $activitiesArray
        ]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'profil_majelis_taklim' => 'required|string',
            'kegiatan_majelis_taklim' => 'required|array',
            'kegiatan_majelis_taklim.*.name' => 'required|string',
            'kegiatan_majelis_taklim.*.icon' => 'required|string'
        ]);

        Setting::updateOrCreate(
            ['key' => 'profil_majelis_taklim'],
            ['value' => $request->profil_majelis_taklim]
        );

        Setting::updateOrCreate(
            ['key' => 'kegiatan_majelis_taklim'],
            ['value' => json_encode($request->kegiatan_majelis_taklim)]
        );

        return Redirect::back()->with('success', 'Profil dan Kegiatan Majelis Taklim berhasil diperbarui');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:1024',
            'urutan' => 'nullable|integer',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('majelis-taklim', 'public');
        }

        MajelisTaklim::create($data);

        return Redirect::back()->with('success', 'Data pengurus Majelis Taklim berhasil ditambahkan');
    }

    public function update(Request $request, MajelisTaklim $majelis_taklim)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:1024',
            'urutan' => 'nullable|integer',
        ]);

        if ($request->hasFile('foto')) {
            if ($majelis_taklim->foto) {
                Storage::disk('public')->delete($majelis_taklim->foto);
            }
            $data['foto'] = $request->file('foto')->store('majelis-taklim', 'public');
        } else {
            unset($data['foto']);
        }

        $majelis_taklim->update($data);

        return Redirect::back()->with('success', 'Data pengurus Majelis Taklim berhasil diperbarui');
    }

    public function destroy(MajelisTaklim $majelis_taklim)
    {
        if ($majelis_taklim->foto) {
            Storage::disk('public')->delete($majelis_taklim->foto);
        }

        $majelis_taklim->delete();

        return Redirect::back()->with('success', 'Data pengurus Majelis Taklim berhasil dihapus');
    }
}
