<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class LayananController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Layanan/Index', [
            'layanans' => Layanan::orderBy('order')->latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string',
            'color' => 'required|string',
            'requirements' => 'required|array',
            'requirements.*' => 'required|string',
        ]);

        Layanan::create($data);

        return Redirect::back()->with('success', 'Layanan berhasil ditambahkan');
    }

    public function update(Request $request, Layanan $layanan)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string',
            'color' => 'required|string',
            'requirements' => 'required|array',
            'requirements.*' => 'required|string',
        ]);

        $layanan->update($data);

        return Redirect::back()->with('success', 'Layanan berhasil diperbarui');
    }

    public function destroy(Layanan $layanan)
    {
        $layanan->delete();

        return Redirect::back()->with('success', 'Layanan berhasil dihapus');
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:layanans,id'
        ]);

        foreach ($request->ids as $index => $id) {
            Layanan::where('id', $id)->update(['order' => $index]);
        }

        return Redirect::back()->with('success', 'Urutan layanan diperbarui');
    }
}
