<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class PkkController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Lembaga/PKK/Index', [
            'members' => []
        ]);
    }
}
