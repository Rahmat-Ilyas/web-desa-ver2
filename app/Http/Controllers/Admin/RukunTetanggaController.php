<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class RukunTetanggaController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Lembaga/RukunTetangga/Index', [
            'members' => [] // Nanti diisi data DB
        ]);
    }
}
