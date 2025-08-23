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
            Post::query()->where('user_id', Auth::user()->id)->get()
        );
    }

    public function allPosts()
    {
        $posts = Post::with(['user', 'comments.user', 'postUserInteractions'])->latest()->get();
        return PostsResource::collection($posts);
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

        $images = array();
        if($files = $request->file('images_')){
            foreach ($files as $file) {
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $originalExtension = $file->getClientOriginalExtension();
                $cleanName = preg_replace('/[^A-Za-z0-9\-]/', '_', $originalName);

                $imageName = $cleanName . '-' . time() . '.' . $originalExtension;
                $file->move(public_path('images'), $imageName);
                $images[] = $imageName;
            }
        }

        $post = Post::create([
            'user_id' => Auth::user()->id,
            'content' => $request->input("content"),
            'images' => implode("|", $images),
        ]);

        $post->load(['user', 'comments.user', 'postUserInteractions']);

        return new PostsResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load(['user', 'comments.user', 'postUserInteractions']);
        return new PostsResource($post);
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
