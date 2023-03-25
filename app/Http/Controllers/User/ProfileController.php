<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileController as ResourcesProfileController;
use App\Http\Resources\UserProfileResource;
use App\Models\Feed;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ProfileController extends Controller
{
    public function index($id)
    {
        $user = User::with('profile')->find($id);

        if ($user)
            return response([
                'user' => new UserProfileResource($user)
            ], 200);

        return response([
            'message' => 'User not found'
        ], 200);
    }

    public function getRecentPosts()
    {
        $feeds = Feed::where('user_id', auth()->id())->latest()->get();

        if ($feeds)
            return response([
                'feeds' => ResourcesProfileController::collection($feeds)
            ], 200);

        return response([
            'message' => 'Error fetching data'
        ], 500);
    }

    public function updateProfile(Request $request)
    {
        $getuserprofile = Profile::where('user_id', auth()->id())->first();
        $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'age' => 'required',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'year' => 'required',
        ]);

        // user data to update {user table}
        $userdata = [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
        ];

        // update user
        User::where('id', auth()->id())->update($userdata);

        // profile update {profile table}

        $profiledata = [
            'user_id' => auth()->id(),
            'age' => $request->age,
            'year' => $request->year,
            'profileImg' => 'https://ui-avatars.com/api/?name=' . $request->firstname . '+' . $request->lastname,
            'minor' => auth()->user()->profile->minor ?? [],
            'major' => auth()->user()->profile->major ?? [],
            'hobbies' => auth()->user()->profile->hobbies ?? [],
            'interests' => auth()->user()->profile->interests ?? [],
        ];
        // get profile
        $getprofile = Profile::where('user_id', auth()->id())->first();
        if ($getprofile) {
            $profile = Profile::where('user_id', auth()->id())->update($profiledata);
            if (!$profile) {
                return response([
                    'message' => 'Error updating profile'
                ], 500);
            } else {
                return response([
                    'user' => User::with('profile')->find(auth()->id()),
                ], 201);
            }
        } else {
            $profile = Profile::create($profiledata);
            if (!$profile) {
                return response([
                    'message' => 'Error updating profile'
                ], 500);
            } else {
                return response([
                    'user' => User::with('profile')->find(auth()->id()),
                ], 201);
            }
        }
    }

    public function otherProfileData(Request $request)
    {

        $getprofile = Profile::where('user_id', auth()->id())->first();
        if ($getprofile) {

            Profile::where('user_id', auth()->id())->update([
                'major' => json_encode($request->major),
                'minor' => json_encode($request->minor),
                'hobbies' => json_encode($request->hobbies),
                'interests' => json_encode($request->interests),
            ]);

            return response([
                'message' => 'success'
            ], 201);
        } else {
            Profile::create([
                'age' => '',
                'year' => '',
                'profileImg' => 'https://ui-avatars.com/api/?name=' . $request->firstname . '+' . $request->lastname,
                'major' => json_encode($request->major),
                'minor' => json_encode($request->minor),
                'hobbies' => json_encode($request->hobbies),
                'interests' => json_encode($request->interests),
                'user_id' => auth()->id(),
            ]);

            return response([
                'message' => 'success'
            ], 201);
        }
    }

    public function updateImage(Request $request)
    {

        $request->validate([
            'profileImg' => 'required|url'
        ]);

        // print_r($request->all());

        $image =  $request->profileImg;

        $profiledata = [];
        // $image = $request->file('profileImg');
        // $imageName = date('YmdHi') . $image->getClientOriginalName();
        // $image->move(public_path('public/profileImages'), $imageName);
        $profiledata['profileImg'] = $image;

        $profile = Profile::where('user_id', auth()->id())->first();
        if ($profile) {
            $save_profile = Profile::where('user_id', auth()->id())->update($profiledata);
            if (!$save_profile) {
                return response([
                    'message' => 'Error updating profile'
                ], 500);
            } else {
                return response([
                    'message' => 'profile updated'
                ], 201);
            }
        } else {
            $create_profile = Profile::create([
                'age' => '',
                'year' => '',
                'profileImg' => $request->profileImg,
                'major' => [],
                'minor' => [],
                'hobbies' => [],
                'interests' => [],
                'user_id' => auth()->id(),
            ]);
            if (!$create_profile) {
                return response([
                    'message' => 'Error updating profile'
                ], 500);
            } else {
                return response([
                    'message' => 'profile updated'
                ], 201);
            }
        }
    }
}
