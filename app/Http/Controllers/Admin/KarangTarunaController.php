<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KarangTaruna;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class KarangTarunaController extends Controller
{
    public function index()
    {
        $tasks = Setting::where('key', 'tugas_karang_taruna')->first()?->value;
        $tasksArray = json_decode($tasks, true);
        if (!is_array($tasksArray)) {
            $tasksArray = $tasks ? explode("\n", $tasks) : [];
        }

        return Inertia::render('Admin/Lembaga/KarangTaruna/Index', [
            'members' => KarangTaruna::orderBy('urutan', 'asc')->get(),
            'profile' => Setting::where('key', 'profil_karang_taruna')->first()?->value,
            'tasks' => $tasksArray
        ]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'profil_karang_taruna' => 'required|string',
            'tugas_karang_taruna' => 'required|array',
            'tugas_karang_taruna.*' => 'required|string'
        ]);

        Setting::updateOrCreate(
            ['key' => 'profil_karang_taruna'],
            ['value' => $request->profil_karang_taruna]
        );

        Setting::updateOrCreate(
            ['key' => 'tugas_karang_taruna'],
            ['value' => json_encode($request->tugas_karang_taruna)]
        );

        return Redirect::back()->with('success', 'Profil dan Tugas Karang Taruna berhasil diperbarui');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'bidang' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:1024',
            'urutan' => 'nullable|integer',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('karang-taruna', 'public');
        }

        KarangTaruna::create($data);

        return Redirect::back()->with('success', 'Data pengurus Karang Taruna berhasil ditambahkan');
    }

    public function update(Request $request, KarangTaruna $karang_taruna)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'bidang' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:1024',
            'urutan' => 'nullable|integer',
        ]);

        if ($request->hasFile('foto')) {
            if ($karang_taruna->foto) {
                Storage::disk('public')->delete($karang_taruna->foto);
            }
            $data['foto'] = $request->file('foto')->store('karang-taruna', 'public');
        }

        $karang_taruna->update($data);

        return Redirect::back()->with('success', 'Data pengurus Karang Taruna berhasil diperbarui');
    }

    public function destroy(KarangTaruna $karang_taruna)
    {
        if ($karang_taruna->foto) {
            Storage::disk('public')->delete($karang_taruna->foto);
        }

        $karang_taruna->delete();

        return Redirect::back()->with('success', 'Data pengurus Karang Taruna berhasil dihapus');
    }
}
