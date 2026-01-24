<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PengaduanController extends Controller
{
    public function index()
    {
        $pengaduans = Pengaduan::latest()->paginate(10);

        return Inertia::render('Admin/Pengaduan/Index', [
            'pengaduans' => $pengaduans
        ]);
    }

    public function update(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'status' => 'required|in:pending,proses,selesai,ditolak'
        ]);

        $pengaduan->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status aduan berhasil diperbarui.');
    }

    public function destroy(Pengaduan $pengaduan)
    {
        $pengaduan->delete();
        return redirect()->back()->with('success', 'Aduan berhasil dihapus.');
    }
}
