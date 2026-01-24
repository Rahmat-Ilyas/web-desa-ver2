<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $fillable = [
        'nama',
        'phone',
        'kategori',
        'pesan',
        'photos',
        'status'
    ];

    protected $casts = [
        'photos' => 'array'
    ];

    protected $appends = ['kode'];

    public function getKodeAttribute()
    {
        return 'ADU-' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }
}
