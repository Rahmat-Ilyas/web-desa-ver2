<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $fillable = [
        'title',
        'description',
        'icon',
        'color',
        'requirements',
        'order'
    ];

    protected $casts = [
        'requirements' => 'array'
    ];
}
