<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ProgramController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Program/Index', [
            'programs' => Program::latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'deskripsi' => 'required|string',
            'status' => 'required|string',
            'progress' => 'required|integer|min:0|max:100',
            'icon' => 'required|string',
            'color' => 'required|string',
            'waktu_pelaksanaan' => 'nullable|string',
        ]);

        Program::create($data);

        return Redirect::back()->with('success', 'Program kerja berhasil ditambahkan');
    }

    public function update(Request $request, Program $program)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'deskripsi' => 'required|string',
            'status' => 'required|string',
            'progress' => 'required|integer|min:0|max:100',
            'icon' => 'required|string',
            'color' => 'required|string',
            'waktu_pelaksanaan' => 'nullable|string',
        ]);

        $program->update($data);

        return Redirect::back()->with('success', 'Program kerja berhasil diperbarui');
    }

    public function destroy(Program $program)
    {
        $program->delete();
        return Redirect::back()->with('success', 'Program kerja berhasil dihapus');
    }
}
