<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostsResource;
use App\Models\Comment;
use App\Models\Post;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        return CommentResource::collection(
//          Comment::where('user_id', Auth::user()->id)->get()
//        );

        $comments = Comment::with(['user', 'user.latestProfilePicture', 'post'])->get();

        return CommentResource::collection($comments);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request)
    {
        $validated = $request->validated();

        $comment = Comment::create($validated);

        $comment = Comment::with(['user', 'post'])->find($comment->id);

        return $this->success(new CommentResource($comment), 'Comment posted successfully.', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comment = Comment::with(['user', 'post'])->find($id);

        if(!$comment){
            return $this->error('','Comment not found', 404);
        }

        return $this->success(new CommentResource($comment), 'Comment retrieved successfully.', 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentRequest $request, string $id)
    {
        $validated = $request->validated();
        $comment = Comment::findOrFail($id);
        $comment->update($validated);

        return $this->success(new CommentResource($comment), 'Comment updated successfully.', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = Comment::find($id);
        if(!$comment){
            return $this->error('', 'Comment not found', 404);
        }
        $comment->delete();
        return $this->success(null, 'Comment deleted successfully.', 200);
    }
}
