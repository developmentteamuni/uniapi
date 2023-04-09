<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\FriendsResource;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function followUser($userID)
    {
        $check = Friend::where('follower_id', Auth::id())->where('user_id', $userID)->first();

        if ($userID == auth()->id()) {
            return response([
                'message' => 'You cant follow yourself'
            ], 200);
        }

        if ($check) {
            $follow = Friend::where('follower_id', Auth::id())->where('user_id', $userID)->delete();

            if ($follow) {
                return response([
                    'message' => 'UnFollowed'
                ], 200);
            }
        }

        Friend::create([
            'user_id' => $userID,
            'follower_id' => Auth::id(),
        ]);

        return response([
            'message' => 'Followed'
        ], 201);
    }

    public function checkIfFreinds($userID)
    {
        $check = Friend::where('follower_id', Auth::id())->where('user_id', $userID)->first();
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

    public function getMyFriends()
    {
        $friends = User::where('id', auth()->id())->with('followers.follower')->get();

        return response([
            'friends' => FriendsResource::collection($friends)
        ], 200);
    }
}
