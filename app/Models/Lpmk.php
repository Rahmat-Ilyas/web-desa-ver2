<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lpmk extends Model
{
    protected $fillable = [
        'nama',
        'jabatan',
        'foto',
        'no_hp',
        'urutan',
    ];
}
