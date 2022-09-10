<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function send($user_id, $receiver_id, Request $request)
    {
        $request->validate([
            'message' => 'required'
        ]);

        $data = [
            'user_id' => $user_id,
            'receiver_id' => $receiver_id,
            'message' => $request->message,
        ];

        $message = Message::create($data);

        return response([
            'message' => $message
        ], 201);

    }

    public function receive($user_id, $receiver_id)
    {
        $message = Message::where(['user_id' => $user_id, 'receiver_id' => $receiver_id])->with('user:id,firstname,lastname')->with('receiver:id,firstname,lastname')->get();

        return response([
            'message' => $message
        ]);
    }
}
