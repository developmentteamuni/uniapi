<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserProfileResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserLists extends Controller
{
    public function index()
    {
        $users = User::with('profile')->inRandomOrder()->get()->except(auth()->id());
        return response([
            'users' => UserProfileResource::collection($users)
        ], 200);
    }
}
