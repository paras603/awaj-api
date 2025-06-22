<?php

namespace App\Http\Resources;

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
                'upvote' => $this->upvote,
                'downvote' => $this->downvote,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
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
