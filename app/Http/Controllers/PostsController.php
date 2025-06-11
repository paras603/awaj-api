<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostsResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePostRequest;
use App\Traits\HttpResponses;

class PostsController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PostsResource::collection(
            Post::where('user_id', Auth::user()->id)->get()
        );
    }

    public function allPosts()
    {
        return PostsResource::collection(
            Post::latest()->take(5)->get()
        );
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
    public function store(StorePostRequest $request)
    {
        $request->validated($request->all());

        $post = Post::create([
            'user_id' => Auth::user()->id,
            'content' => $request->content,
        ]);

        return new PostsResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return $this->isNotAuthorized($post) ? $this->isNotAuthorized($post) : new PostsResource($post);
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
    public function update(Request $request, Post $post)
    {
        if(Auth::user()->id !== $post->user_id){
            return $this->error('', 'Your are not authorized to make this request', 403);
        }

        $post->update($request->all());

        return new PostsResource($post);

            //     return $this->isNotAuthorized($post)
            // ? $this->isNotAuthorized($post)
            // : new PostsResource($post->update($request->all()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        return $this->isNotAuthorized($post) ? $this->isNotAuthorized($post) : $post->delete();
    }

    private function isNotAuthorized($post){
        if(Auth::user()->id !== $post->user_id){
            return $this->error('', 'You are not authorized to make this request', 403);
        }
    }
}
