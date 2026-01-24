<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RukunWarga extends Model
{
    protected $fillable = [
        'no_rw',
        'nama_ketua',
        'no_hp',
        'foto_ketua'
    ];
}
