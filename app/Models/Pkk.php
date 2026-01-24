<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pkk extends Model
{
    protected $fillable = [
        'nama',
        'jabatan',
        'pokja',
        'foto',
        'no_hp',
        'urutan'
    ];
}
