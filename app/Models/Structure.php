<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Structure extends Model
{
    protected $fillable = [
        'name',
        'nip',
        'position',
        'photo',
        'level',
        'parent_id',
        'order',
    ];

    public function children()
    {
        return $this->hasMany(Structure::class, 'parent_id')->orderBy('order');
    }

    public function parent()
    {
        return $this->belongsTo(Structure::class, 'parent_id');
    }
}
