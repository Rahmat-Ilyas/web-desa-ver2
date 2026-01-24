<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PengaduanController extends Controller
{
    public function index()
    {
        return Inertia::render('Pengaduan/Index');
    }

    public function track(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
        ]);

        $pengaduans = Pengaduan::where('phone', $request->phone)
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'kode' => $item->kode,
                    'kategori' => $item->kategori,
                    'pesan' => $item->pesan,
                    'status' => $item->status,
                    'created_at' => $item->created_at->format('d M Y H:i'),
                ];
            });

        return response()->json($pengaduans);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'kategori' => 'required|string',
            'pesan' => 'required|string',
            'photos' => 'nullable|array|max:3',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $photoPaths = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('pengaduan', 'public');
                $photoPaths[] = $path;
            }
        }

        Pengaduan::create([
            'nama' => $request->nama,
            'phone' => $request->phone,
            'kategori' => $request->kategori,
            'pesan' => $request->pesan,
            'photos' => $photoPaths,
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Aduan Anda telah berhasil dikirim. Kami akan segera menindaklanjutinya.');
    }
}
