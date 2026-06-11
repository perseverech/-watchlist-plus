<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaItem extends Model
{
    protected $fillable = [
        'title',
        'type',
        'genre',
        'year',
        'description',
        'rating',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public static function getTrending()
    {
        return self::latest()->take(6)->get();
    }
}