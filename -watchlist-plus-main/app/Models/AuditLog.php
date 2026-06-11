<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id', 
        'action', 
        'entity', 
        'entity_id', 
        'timestamp'
    ];

    protected function casts(): array
    {
        return [
            'timestamp' => 'datetime',
        ];
    }

    // Connects the log back to the Admin who did it
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}