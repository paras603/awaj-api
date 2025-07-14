<?php

namespace App\Http\Resources;

use App\Models\PostUserInteraction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostUserInteractionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'post_id' => (string)$this->post_id,
            'user_id' => (string)$this->user_id,
            'attributes' => [
                'vote_status' => (string)$this->voteStatus,
                'is_bookmarked' => $this->isBookmarked,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
//                'total_bookmarked' => PostUserInteraction::where('post_id' , $this->post_id)
//                    ->where('isBookmarked' , true)
//                    ->count(),
            ]
        ];
    }
}
