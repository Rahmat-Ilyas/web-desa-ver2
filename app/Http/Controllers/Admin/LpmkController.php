<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class LpmkController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Lembaga/LPMK/Index', [
            'members' => []
        ]);
    }
}
