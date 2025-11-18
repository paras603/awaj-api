<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use App\Models\User;
use App\Traits\HttpResponses;

class UserController extends Controller
{
    use HttpResponses;

    public function show(User $user)
    {
        $followerCount = Connection::where('user_id', $user->id)->count();
        $followingCount = Connection::where('follower_id', $user->id)->count();

        $user->load(['profilePictures']);

        if($user->profilePictures){
           foreach ($user->profilePictures as $picture){
               $picture->image = asset('images/' . $picture->image);
           }
        }

        return $this->success([
            'user' => $user,
            'followerCount' => $followerCount,
            'followingCount' => $followingCount
        ],"User Profile retrieved successfully");
    }
}
