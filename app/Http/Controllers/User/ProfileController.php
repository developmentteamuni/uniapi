<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Feed;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index($id)
    {
        $user = User::with('profile')->find($id);

        if($user)
            return response([
                'user' => $user
            ], 200);

        return response([
            'message' => 'User not found'
        ], 200);
    }

    public function getRecentPosts()
    {
        $feeds = Feed::where('user_id', auth()->id())->latest()->get();

        if($feeds)
            return response([
                'feeds' => $feeds
            ], 201);
        
        return response([
            'message' => 'Error fetching data'
        ], 500);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'age' => 'required',
            'email' => 'required|email|unique:users,email,' .auth()->id(),
            'year' => 'required',
            'major' => 'required',
            'minor' => 'required',
            'hobbies' => 'required',
            'interests' => 'required',
        ]);

        // user data to update {user table}
        $userdata = [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'major' => $request->major,
        ];

        // update user
        User::where('id', auth()->id())->update($userdata);

        // profile update {profile table}

        $profiledata = [
            'user_id' => auth()->id(),
            'age' => $request->age,
            'year' => $request->year,
            'minor' => $request->minor,
            'hobbies' => $request->hobbies,
            'interests' => $request->interests,
        ];

        // validate image
        if($request->file('profileImg')) {
            $request->validate([
                'profileImage' => 'image'
            ]);
            $image = $request->file('profileImg');
            $imageName = date('YmdHi').$image->getClientOriginalName();
            $image->move(public_path('public/profileImages'), $imageName);
            $profiledata['profileImg'] = $imageName;
            
            // update profile with Image
            $profile = Profile::updateOrCreate($profiledata);
            if(!$profile)
                return response([
                    'message' => 'Error updating profile'
                ], 500);
        }else{
            // update profile without Image
            $profile = Profile::updateOrCreate($profiledata);
            if(!$profile)
                return response([
                    'message' => 'Error updating profile'
                ], 500);
        }

        return response([
            'user' => User::with('profile')->find(auth()->id()),
        ], 201);

    }
}