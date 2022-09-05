<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(RegisterRequest $registerRequest)
    {
        // $otp = rand(1000,9999);
        $otp = 654321;
        $registerRequest->validated();
        $user = User::create([
            'firstname' => $registerRequest->firstname,
            'lastname' => $registerRequest->lastname,
            'major' => $registerRequest->major,
            'university' => $registerRequest->university,
            'otp' => str($otp),
            'email' => $registerRequest->email,
            'password' => Hash::make($registerRequest->password),
        ]);
        if($user) {
            $details = [
                'title' => 'Verify your email address',
                'body' => $otp
            ];

            Mail::to($registerRequest->email)->send(new OtpMail($details));
            return response([
                'message' => 'Verify OTP'
            ], 201);
        }else{
            return response([
                'message' => 'Error creating user'
            ], 400);
        }
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|integer'
        ]);

        $userverified = User::where('email', $request->email)->first();
        if($userverified->otp == 'verified')
        {
            return response([
                'message' => 'Account has already been verified'
            ]);
        }else{

        $user = User::where([['email', $request->email], ['otp', $request->otp]])->first();

        if($user) {
            auth()->login($user, true);
            $user = User::where('email', $request->email)->update(['otp' => 'verified']);
            $token = auth()->user()->createToken('authToken')->plainTextToken;

            return response([
                'user' => auth()->user(),
                'token' => $token
            ], 200);
        }else{
            return response([
                'message' => 'Incorrect Otp'
            ], 400);
        }
    }
    }

    public function login(LoginRequest $loginRequest)
    {
        $loginRequest->validated();

        // check user

        $user = User::where('email', $loginRequest->email)->first();
        if(!$user || !Hash::check($loginRequest->password, $user->password)) {
            return response([
                'message' => 'Incorrect credentials'
            ], 400);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ], 200);

    }

    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user)
            return response([
                'message' => 'User not found'
            ], 400);
        
        return response([
            'message' => 'success'
        ], 200);
        
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|same:new_password',
            'new_password' => 'required'
        ]);

        $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

        if(!$user)
            return response([
                'message' => 'Error changing password'
            ], 400);

        return response([
            'message' => 'success',
        ], 200);
    }
}
