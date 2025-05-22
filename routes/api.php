<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

//protected routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::resource('/posts', PostsController::class);
    Route::get('/allPosts', [PostsController::class, 'allPosts']);
});