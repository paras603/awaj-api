<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityFeed extends Model
{
    use HasFactory;

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
        return $this->belongsTo(ActivityType::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

}
