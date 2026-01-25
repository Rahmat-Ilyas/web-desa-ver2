<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lpmk;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class LpmkController extends Controller
{
    public function index()
    {
        $tasks = Setting::where('key', 'tugas_lpmk')->first()?->value;
        $tasksArray = json_decode($tasks, true);
        if (!is_array($tasksArray)) {
            $tasksArray = $tasks ? explode("\n", $tasks) : [];
        }

        return Inertia::render('Admin/Lembaga/LPMK/Index', [
            'members' => Lpmk::orderBy('urutan', 'asc')->get(),
            'profile' => Setting::where('key', 'profil_lpmk')->first()?->value,
            'tasks' => $tasksArray
        ]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'profil_lpmk' => 'required|string',
            'tugas_lpmk' => 'required|array',
            'tugas_lpmk.*' => 'required|string'
        ]);

        Setting::updateOrCreate(
            ['key' => 'profil_lpmk'],
            ['value' => $request->profil_lpmk]
        );

        Setting::updateOrCreate(
            ['key' => 'tugas_lpmk'],
            ['value' => json_encode($request->tugas_lpmk)]
        );

        return Redirect::back()->with('success', 'Profil dan Tugas LPMK berhasil diperbarui');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:1024',
            'urutan' => 'nullable|integer',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('lpmk', 'public');
        }

        Lpmk::create($data);

        return Redirect::back()->with('success', 'Data pengurus LPMK berhasil ditambahkan');
    }

    public function update(Request $request, Lpmk $lpmk)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:1024',
            'urutan' => 'nullable|integer',
        ]);

        if ($request->hasFile('foto')) {
            if ($lpmk->foto) {
                Storage::disk('public')->delete($lpmk->foto);
            }
            $data['foto'] = $request->file('foto')->store('lpmk', 'public');
        } else {
            unset($data['foto']);
        }

        $lpmk->update($data);

        return Redirect::back()->with('success', 'Data pengurus LPMK berhasil diperbarui');
    }

    public function destroy(Lpmk $lpmk)
    {
        if ($lpmk->foto) {
            Storage::disk('public')->delete($lpmk->foto);
        }

        $lpmk->delete();

        return Redirect::back()->with('success', 'Data pengurus LPMK berhasil dihapus');
    }
}
