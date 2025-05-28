<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ActivityTypes extends Model
{
    use HasFactory;

    protected $fillable = ['type'];

    public function activityFeeds(): HasOne{
        return $this->hasOne(ActivityFeeds::class);
    }
}
