<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
                'comment' => $this->comment,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'posts' => [
                'post_id' => $this->post->id,
//                'content' => $this->post->content,
            ],
            'user' => [
                'user_id' => $this->user->id,
                'user_name' => $this->user->username,
                'profile_picture' => $this->user->profile_picture_url,
            ],
        ];
    }
}
