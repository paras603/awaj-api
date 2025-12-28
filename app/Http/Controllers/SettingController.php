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
        $file = $request['latest_profile_picture'];

        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $originalExtension = $file->getClientOriginalExtension();
        $cleanName = preg_replace('/[^A-Za-z0-9\-]/', '_', $originalName);

        $imageName = $cleanName . '-' . time() . '.' . $originalExtension;
        $file->move(public_path('images'), $imageName);


        $user = Auth::user();
        $user->update($request->validated());

        $user->profilePictures()->create([
            'image' => $imageName,
        ]);

        $user->save();

        return new SettingResource($user);
    }

    public function show(){
        $user = Auth::user();
        return new SettingResource($user);
    }
}
