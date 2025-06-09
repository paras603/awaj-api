<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NotificationType extends Model
{
    protected $fillable = [
        'type',
    ];

    public function notification(): HasMany
    {
        return $this->hasMany(Notification::class);
    }
}
