<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'errors' => function () use ($request) {
                return $request->session()->get('errors')
                    ? $request->session()->get('errors')->getBag('default')->getMessages()
                    : (object) [];
            },
            'flash' => [
                'success' => $request->session()->get('success'),
                'error' => $request->session()->get('error'),
            ],
            'auth' => [
                'user' => $request->user() ? [
                    'id' => $request->user()->id,
                    'name' => $request->user()->name,
                    'email' => $request->user()->email,
                    'updated_at' => $request->user()->updated_at,
                ] : null,
            ],
            'footerGaleris' => \App\Models\Galeri::latest()
                ->select('id', 'judul', 'image')
                ->take(6)
                ->get(),
            'pendingPengaduanCount' => $request->user()
                ? \App\Models\Pengaduan::where('status', 'pending')->count()
                : 0,
            'settings' => \App\Models\Setting::all()->pluck('value', 'key')->map(function ($value, $key) {
                if (in_array($key, ['info_umum', 'sosial_media', 'statistik_umum', 'statistik_agama', 'statistik_pendidikan', 'statistik_umur', 'statistik_pemilih'])) {
                    return json_decode($value, true);
                }
                return $value;
            }),
        ]);
    }
}
