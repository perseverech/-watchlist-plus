<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaItem extends Model
{
    protected $fillable = [
        'title',
        'type',
        'description',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}