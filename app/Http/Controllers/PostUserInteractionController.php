<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostUserInteractionRequest;
use App\Http\Requests\UpdatePostUserInteractionRequest;
use App\Http\Resources\PostUserInteractionResource;
use App\Models\PostUserInteraction;
use App\Traits\HttpResponses;

class PostUserInteractionController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $interactions = PostUserInteraction::all();
        return $this->success(
            PostUserInteractionResource::collection($interactions),
            'Interactions retrieved successfully.'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostUserInteractionRequest $request)
    {
        $validated = $request->validated();
        $interaction = PostUserInteraction::create(
          [
              'post_id' => $validated['post_id'],
              'user_id' => $validated['user_id'],
              'voteStatus' => $validated['voteStatus'] ?? 0,
              'isBookmarked' => $validated['isBookmarked'] ?? false
          ]
        );

        return $this->success(
            new PostUserInteractionResource($interaction),
            'Interaction created or updated successfully.',
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $userid, string $postid)
    {
        $interaction = PostUserInteraction::where('user_id', $userid)
            ->where('post_id', $postid)
            ->first();

        if(!$interaction){
            return $this->error(
                null,
                'Interaction not found.',
                404
            );
        }
        return $this->success(
            new PostUserInteractionResource($interaction),
            'Interaction retrieved successfully.'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostUserInteractionRequest $request, string $userid, string $postid)
    {
        $interaction = PostUserInteraction::where('user_id', $userid)
            ->where('post_id', $postid)
            ->first();

        if(!$interaction){
            return $this->error(
                null,
                'Interaction not found.',
                404
            );
        }

        $validated = $request->validated();

        PostUserInteraction::where('user_id', $userid)
        ->where('post_id', $postid)
        ->update([
            'voteStatus' => $validated['voteStatus'] ?? $interaction->voteStatus,
            'isBookmarked' => $validated['isBookmarked'] ?? $interaction->isBookmarked,
        ]);

        // Re-fetch the updated model
        $interaction = PostUserInteraction::where('user_id', $userid)
            ->where('post_id', $postid)
            ->first();

        return $this->success(
            new PostUserInteractionResource($interaction),
            'Interaction updated successfully.',
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $userid, string $postid)
    {
        $deleted = PostUserInteraction::where('user_id', $userid)
            ->where('post_id', $postid)
            ->delete();

        if ($deleted === 0) {
            return $this->error(null, 'Interaction not found.', 404);
        }

        return $this->success(null, 'Interaction deleted');

    }
}
