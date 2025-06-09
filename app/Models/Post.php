<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'upvote',
        'downvote',
    ];

    //default values for these attributes
    protected $attributes = [
        'upvote' => 0,
        'downvote' => 0
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function activityFeeds(): HasMany
    {
        return $this->hasMany(ActivityFeed::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
