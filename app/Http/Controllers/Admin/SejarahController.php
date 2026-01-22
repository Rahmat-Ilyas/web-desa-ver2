<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\HistoricalTimeline;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SejarahController extends Controller
{
    public function index()
    {
        $intro = Setting::where('key', 'sejarah_singkat')->first();
        $timelines = HistoricalTimeline::orderBy('order')->orderBy('year')->get();

        return Inertia::render('Admin/Sejarah/Index', [
            'intro' => $intro ? $intro->value : '',
            'timelines' => $timelines
        ]);
    }

    public function updateIntro(Request $request)
    {
        $request->validate([
            'intro' => 'required|string',
        ]);

        Setting::updateOrCreate(
            ['key' => 'sejarah_singkat'],
            ['value' => $request->intro]
        );

        return back()->with('success', 'Sejarah singkat berhasil diperbarui');
    }

    public function storeTimeline(Request $request)
    {
        $request->validate([
            'year' => 'required|string',
            'title' => 'required|string',
            'content' => 'required|string',
            'order' => 'nullable|integer',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('timelines', 'public');
        }

        HistoricalTimeline::create($data);

        return back()->with('success', 'Timeline berhasil ditambahkan');
    }

    public function updateTimeline(Request $request, HistoricalTimeline $timeline)
    {
        $request->validate([
            'year' => 'required|string',
            'title' => 'required|string',
            'content' => 'required|string',
            'order' => 'nullable|integer',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            if ($timeline->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($timeline->image);
            }
            $data['image'] = $request->file('image')->store('timelines', 'public');
        }

        $timeline->update($data);

        return back()->with('success', 'Timeline berhasil diperbarui');
    }

    public function destroyTimeline(HistoricalTimeline $timeline)
    {
        if ($timeline->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($timeline->image);
        }
        $timeline->delete();

        return back()->with('success', 'Timeline berhasil dihapus');
    }
}
