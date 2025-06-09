<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ActivityType extends Model
{
    use HasFactory;

    protected $fillable = ['type'];

    public function activityFeeds(): HasMany{
        return $this->hasMany(ActivityFeed::class);
    }
}
