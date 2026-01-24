<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class KarangTarunaController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Lembaga/KarangTaruna/Index', [
            'members' => []
        ]);
    }
}
