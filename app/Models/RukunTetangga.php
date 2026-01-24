<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RukunTetangga extends Model
{
    protected $fillable = [
        'rukun_warga_id',
        'no_rt',
        'nama_ketua',
        'no_hp',
        'foto_ketua'
    ];

    public function rukunWarga()
    {
        return $this->belongsTo(RukunWarga::class);
    }
}
