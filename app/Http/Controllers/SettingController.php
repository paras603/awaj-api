<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSettingRequest;
use App\Http\Resources\SettingResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function update(UpdateSettingRequest $request)
    {
        $user = Auth::user();
        $user->update($request->validated());

        return new SettingResource($user);
    }
}
