<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaUser extends Model
{
    protected $fillable = [
        'user_id',
        'media_item_id',
        'status',
    ];

    public function mediaItem()
    {
        return $this->belongsTo(MediaItem::class);
    }
}