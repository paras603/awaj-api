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
        $user = User::findOrFail(57)->get();
        dd($user);

        if($user->id == $user_id){
            return $this->error(null, "You can't follow yourself.", 422);
        }

        $user->following()->syncWithoutDetaching([$user_id]);

        return $this->success(['user' => $user->id, 'follows' => $user_id], "Followed.", 200);
    }

    public function unfollow(Request $request, $user_id)
    {
        $user = auth()->user();

        $user->following()->detach([$user_id]);

        return $this->success(null, "Unfollowed.", 200);
    }

    public function followers()
    {
        $user = auth()->user();
        $followers = $user->following()->pluck('id');
        return $this->success($followers, "followers", 200);
    }
}
