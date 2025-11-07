<?php

namespace App\Http\Resources;

use App\Models\PostUserInteraction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (string)$this->id,
            'attributes' => [
                'content' => $this->content,
                'image_urls' => $this->images ? collect(explode('|', $this->images))->map(fn($img) => asset('images/' . $img)) : [],
                'upvote' => $this->upvote,
                'downvote' => $this->downvote,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'total_bookmarked' => PostUserInteraction::where('post_id' , $this->id)
                    ->where('isBookmarked' , true)
                    ->count(),
            ],
            'relationships' => [
                'id' => (string)$this->user->id,
                'user_name' => $this->user->username,
                'user_email' => $this->user->email,
                'profile_picture' => $this->user->profilePictures
                    ->sortByDesc('created_at')  // Sort by newest first
                    ->first()?->image           // Get the "image" field (null-safe)
                    ? asset('images/' . $this->user->profilePictures->sortByDesc('created_at')->first()->image)
                    : null,
            ],
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'userInteractions' => PostUserInteractionResource::collection($this->whenLoaded('postUserInteractions')),
        ];
    }
}
