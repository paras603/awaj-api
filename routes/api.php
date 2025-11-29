<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\PostUserInteractionController;
use App\Http\Controllers\ConnectionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

//protected routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/auth-user', [AuthController::class, 'user']);

    Route::get('/users/{user}', [UserController::class, 'show']);

    Route::resource('/posts', PostsController::class);
    Route::get('/allPosts', [PostsController::class, 'allPosts']);
    Route::get('/allPosts/{userId}', [PostsController::class, 'userPosts']);

    Route::resource('/comments', CommentController::class);

    Route::apiResource('interactions', PostUserInteractionController::class)
        ->only(['index', 'store']);
    Route::get('interactions/{user_id}/{post_id}', [PostUserInteractionController::class, 'show']);
    Route::patch('interactions/{user_id}/{post_id}', [PostUserInteractionController::class, 'update']);
    Route::delete('interactions/{user_id}/{post_id}', [PostUserInteractionController::class, 'destroy']);

    Route::get('/allProfilePictures', [\App\Http\Controllers\ProfilePicture::class, 'index']);

    //connections
    Route::post('/follow/{userId}', [ConnectionController::class, 'follow']);
    Route::delete('/unfollow/{userId}', [ConnectionController::class, 'unfollow']);
    Route::post('/follow-toggle/{userId}', [ConnectionController::class, 'followToggle']);
    Route::get('/followers', [ConnectionController::class, 'followers']);
    Route::get('/following', [ConnectionController::class, 'following']);
});

