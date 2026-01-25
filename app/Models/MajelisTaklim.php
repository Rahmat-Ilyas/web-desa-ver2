<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MajelisTaklim extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jabatan',
        'kategori',
        'no_hp',
        'foto',
        'urutan',
    ];
}
