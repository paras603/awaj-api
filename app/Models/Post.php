<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'content', 'upvote', 'downvote'
    ];

    //default values for these attributes
    protected $attributes = [
        'upvote' => 0,
        'downvote' => 0
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
