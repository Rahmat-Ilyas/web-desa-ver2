<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class MajelisTaklimController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Lembaga/MajelisTaklim/Index', [
            'members' => []
        ]);
    }
}
