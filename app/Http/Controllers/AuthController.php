<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(LoginUserRequest $request){
        $request->validated($request->all());

        if(!Auth::attempt($request->only('email','password'))){
            return $this->error('', 'Credentials do not match', 401);
        }

        $user = User::with('latestProfilePicture')
            ->where('email', $request->email)
            ->first();

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('Api Token of ' . $user->username)->plainTextToken
        ], 'Successfully logged in');
    }

    public function register(StoreUserRequest $request){
        $request->validated($request->all());

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API token of ' . $user->username)->plainTextToken
        ], 'successfully regisered');
    }

    public function logout(Request $request){
        Auth::user()->currentAccessToken()->delete();
        return $this->success(null, 'Successfully logged out');
    }

    public function user(Request $request){
        $user = Auth::user()->load('latestProfilePicture','profilePictures');

        if($user->latestProfilePicture){
            $user->latestProfilePicture->image = asset('images/' . $user->latestProfilePicture->image);
        }

        if($user->profilePictures){
           foreach ($user->profilePictures as $picture){
               $picture->image = asset('images/' . $picture->image);
           }
        }

        return $this->success($user, "Successfully retrieved the user's profile");
    }
}
