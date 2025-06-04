<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityFeeds extends Model
{
    //fields that can be mass assigned
    protected $fillable = [
        'user_id',
        'activity_type_id',
        'post_id'
    ];

    //relationships

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function activityType(): BelongsTo
    {
        return $this->belongsTo(ActivityTypes::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

}
