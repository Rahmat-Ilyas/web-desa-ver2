<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Download::query();

        if ($request->has('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%')
                ->orWhere('kategori', 'like', '%' . $request->search . '%');
        }

        $downloads = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return inertia('Admin/Download/Index', [
            'downloads' => $downloads,
            'filters' => $request->only(['search'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Admin/Download/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'file' => 'required|file|max:10240', // Max 10MB
            'deskripsi' => 'nullable|string',
        ]);

        $file = $request->file('file');
        $path = $file->store('downloads', 'public');

        // Determine file type and size
        $type = strtoupper($file->getClientOriginalExtension());
        $sizeBytes = $file->getSize();

        // Format size
        if ($sizeBytes >= 1048576) {
            $size = number_format($sizeBytes / 1048576, 1) . ' MB';
        } elseif ($sizeBytes >= 1024) {
            $size = number_format($sizeBytes / 1024, 0) . ' KB';
        } else {
            $size = $sizeBytes . ' B';
        }

        Download::create([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'file_path' => $path,
            'type' => $type,
            'size' => $size,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.download.index')->with('success', 'Dokumen berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Download $download)
    {
        return inertia('Admin/Download/Edit', [
            'download' => $download
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Download $download)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'file' => 'nullable|file|max:10240', // Max 10MB
            'deskripsi' => 'nullable|string',
        ]);

        $data = [
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('file')) {
            // Delete old file if exists and not dummy
            if ($download->file_path && !str_starts_with($download->file_path, 'dummy/')) {
                Storage::disk('public')->delete($download->file_path);
            }

            $file = $request->file('file');
            $path = $file->store('downloads', 'public');

            $data['file_path'] = $path;
            $data['type'] = strtoupper($file->getClientOriginalExtension());

            $sizeBytes = $file->getSize();
            if ($sizeBytes >= 1048576) {
                $data['size'] = number_format($sizeBytes / 1048576, 1) . ' MB';
            } elseif ($sizeBytes >= 1024) {
                $data['size'] = number_format($sizeBytes / 1024, 0) . ' KB';
            } else {
                $data['size'] = $sizeBytes . ' B';
            }
        }

        $download->update($data);

        return redirect()->route('admin.download.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Download $download)
    {
        if ($download->file_path && !str_starts_with($download->file_path, 'dummy/')) {
            Storage::disk('public')->delete($download->file_path);
        }

        $download->delete();

        return redirect()->route('admin.download.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}
