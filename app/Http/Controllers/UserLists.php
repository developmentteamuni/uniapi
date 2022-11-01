<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserLists extends Controller
{
    public function index()
    {
        $users = User::inRandomOrder()->get();
        return response([
            'users' => $users
        ], 200);
    }
}
