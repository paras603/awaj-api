<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class ConnectionController extends Controller
{
    use HttpResponses;
    public function follow(Request $request, $user_id)
    {
        $user = auth()->user();

        if($user->id == $user_id){
            return $this->error(null, "You can't follow yourself.", 422);
        }

        $user->following()->syncWithoutDetaching([$user_id]);

        return $this->success(['user' => $user_id, 'follows' => $user->id], "Followed.", 200);
    }

    public function unfollow(Request $request, $user_id)
    {
        $user = auth()->user();

        $user->following()->detach([$user_id]);

        return $this->success(null, "Unfollowed.", 200);
    }

    public function followToggle(Request $request, $user_id)
    {
        $auth_user = auth()->user();

        $isFollowing = $auth_user->following()->whereKey($user_id)->exists();

        if ($auth_user->id == $user_id) {
            return $this->error(null, 'You cannot follow yourself.', 422);
        }

        // Toggle follow status (returns array of attached/detached IDs)
        // need to verify which is effective this toggle or with different methods
        $result = $auth_user->following()->toggle($user_id);

        if (!empty($result['attached'])) {
            // User is now followed
            return $this->success([
                'user' => $user_id,
                'isFollowing' => $isFollowing,
                'follows' => true,
            ], "Followed.", 200);
        }

        if (!empty($result['detached'])) {
            // User is now unfollowed
            return $this->success([
                'user' => $user_id,
                'isFollowing' => $isFollowing,
                'follows' => false,
            ], "Unfollowed.", 200);
        }
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

    public function checkFollow($user_id)
    {
        $authUser = auth()->user();

        $isFollowing = $authUser->following()->whereKey($user_id)->exists();

        return $this->success($isFollowing, "following", 200);
    }
}
