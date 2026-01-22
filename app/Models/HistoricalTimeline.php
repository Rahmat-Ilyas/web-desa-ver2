<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoricalTimeline extends Model
{
    protected $fillable = ['year', 'title', 'content', 'order', 'image'];
}
