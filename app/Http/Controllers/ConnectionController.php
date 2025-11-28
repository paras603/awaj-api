<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class ConnectionController extends Controller
{
    use HttpResponses;
//    public function follow(Request $request, $user_id)
//    {
//        $user = auth()->user();
//
//        if($user->id == $user_id){
//            return $this->error(null, "You can't follow yourself.", 422);
//        }
//
//        $user->following()->syncWithoutDetaching([$user_id]);
//
//        return $this->success(['user' => $user_id, 'follows' => $user->id], "Followed.", 200);
//    }
//
//    public function unfollow(Request $request, $user_id)
//    {
//        $user = auth()->user();
//
//        $user->following()->detach([$user_id]);
//
//        return $this->success(null, "Unfollowed.", 200);
//    }

    public function follow(Request $request, $user_id)
    {
        $auth_user = auth()->user();
        $following_id = $user_id;

        if($auth_user->id == $following_id) {
            return $this->error(null,'You cannot follow yourself.', 422);
        }

        $auth_user->following()->toggle($following_id);

        $auth_user->following()->toggle($following_id);

        $auth_user->following()->
// todo: follow and unfollow on toggle
    }
    public function followers()
    {
        $user = auth()->user();
        $followers = $user->followers()->get();

        return $this->success($followers, "followers", 200);
    }

    public function following()
    {
        $user = auth()->user();
        $following = $user->following()->get();

        return $this->success($following, "following", 200);
    }
}
