<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostUserInteractionRequest;
use App\Http\Requests\UpdatePostUserInteractionRequest;
use App\Http\Resources\PostUserInteractionResource;
use App\Models\Post;
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

//    public function savedPosts()
//    {
//        $interaction = PostUserInteraction::where('isBookmarked', true)
//            ->with('user')
//            ->get();
//
//        return $this->success(
//            PostUserInteractionResource::collection($interaction),
//            'Saved posts retrieved successfully.'
//        );
//    }

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

        //update vote count in posts table
        $post = Post::find($validated['post_id']);
        if($post){
            $post->updateVoteCounts();
        }

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

        //TODO: insted of this i can use updateOrCreate
        $validated = $request->validated();

        $interaction = PostUserInteraction::where('user_id', $userid)
            ->where('post_id', $postid)
            ->first();

        if(!$interaction){
            $interaction = PostUserInteraction::create(
                [
                    'post_id' => $postid,
                    'user_id' => $userid,
                    'voteStatus' => $validated['voteStatus'] ?? 0,
                    'isBookmarked' => $validated['isBookmarked'] ?? false
                ]
            );

            //update vote count in posts table
            $post = Post::find($postid);
            if($post){
                $post->updateVoteCounts();
            }

            return $this->success(
                new PostUserInteractionResource($interaction),
                'Interaction created successfully.',
                201
            );
        }


//        $interaction = PostUserInteraction::updateOrCreate(
//            ['user_id' => $userid, 'post_id' => $postid],
//            [
//                'voteStatus' => $validated['voteStatus'] ?? 0,
//                'isBookmarked' => $validated['isBookmarked'] ?? false
//            ]
//        );

        PostUserInteraction::where('user_id', $userid)
        ->where('post_id', $postid)
        ->update([
            'voteStatus' => $validated['voteStatus'] ?? $interaction->voteStatus,
            'isBookmarked' => $validated['isBookmarked'] ?? $interaction->isBookmarked,
        ]);

        $post = Post::find($postid);
        if($post){
            $post->updateVoteCounts();
        }

        // Re-fetch the updated model
        $interaction = PostUserInteraction::where('user_id', $userid)
            ->where('post_id', $postid)
            ->first();

        return $this->success(
            new PostUserInteractionResource($interaction),
//            $interaction->wasRecentlyCreated
//                ? 'Interaction created successfully.' :
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
