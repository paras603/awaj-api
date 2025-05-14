<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(Request $request){
        return 'this is login method';
    }

    public function register(Request $request){
        return response()->json('register method: message returned using json response.');
    }

    public function logout(Request $request){
        return response()->json('this is logout method');
    }
}
