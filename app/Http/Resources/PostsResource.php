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
                'image' =>$this->image,
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
            ],
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'userInteractions' => PostUserInteractionResource::collection($this->whenLoaded('postUserInteractions')),
        ];
    }
}
