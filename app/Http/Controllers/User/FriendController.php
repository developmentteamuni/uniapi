<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function followUser($userID)
    {
        $check = Friend::where('user_id', Auth::id())->where('follower_id', $userID)->first();
        if ($check) {
            $follow = Friend::where('user_id', Auth::id())->where('follower_id', $userID)->delete();

            if ($follow) {
                return response([
                    'message' => 'UnFollowed'
                ], 200);
            }
        }

        Friend::create([
            'user_id' => Auth::id(),
            'follower_id' => $userID,
        ]);

        return response([
            'message' => 'Followed'
        ], 201);
    }

    public function checkIfFreinds($userID)
    {
        $check = Friend::where('user_id', Auth::id())->where('follower_id', $userID)->first();
        if ($check) {
            return response([
                'message' => true
            ], 200);
        } else {
            return response([
                'message' => false
            ], 200);
        }
    }
}
