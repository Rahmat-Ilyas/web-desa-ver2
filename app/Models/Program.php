<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'judul',
        'kategori',
        'deskripsi',
        'icon',
        'color',
        'status',
        'progress',
        'waktu_pelaksanaan'
    ];
}
