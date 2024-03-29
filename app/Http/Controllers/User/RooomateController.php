<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomateRequest;
use App\Http\Resources\RoomResource;
use App\Models\Applied;
use App\Models\Roomate;
use App\Models\RoomImage;
use Illuminate\Http\Request;

class RooomateController extends Controller
{


    public function index()
    {
        $rooms = Roomate::latest()->get();

        return response([
            'rooms' => RoomResource::collection($rooms)
        ], 200);
    }


    public function store(RoomateRequest $roomateRequest)
    {
        $roomateRequest->validated();

        $roomData = [
            'user_id' => auth()->id(),
            'title' => $roomateRequest->title,
            'location' => $roomateRequest->location,
            'description' => $roomateRequest->description,
            'clean' => $roomateRequest->clean,
            'sleep_schdeule' => $roomateRequest->sleep_schdeule,
            'noise_level' => $roomateRequest->noise_level,
            'lots_of_time_in_room' => $roomateRequest->lots_of_time_in_room,
            'company' => $roomateRequest->company,
            'social' => $roomateRequest->social,
            'study_location' => $roomateRequest->study_location,
            'requirements' => $roomateRequest->requirements,
            'campus' => $roomateRequest->campus,
            'time_to_campus' => $roomateRequest->time_to_campus,
            'sublease' => $roomateRequest->sublease,
        ];

        $room = Roomate::create($roomData);

        if ($room) {

            if ($roomateRequest->hasFile('image')) {
                foreach ($roomateRequest->file('image') as $image) {

                    $imageName =
                        $image->getClientOriginalName();
                    $image->move(public_path('public/roomImages'), $imageName);
                    $imageDB = new RoomImage();
                    $imageDB->room_id = $room->id;
                    $imageDB->image = $imageName;
                    $saveImage = $imageDB->save();
                }
                if ($saveImage) {
                    return response([
                        'message' => 'success',
                    ], 201);
                } else {
                    return response([
                        'message' => 'error',
                    ], 400);
                }
            } else {
                return response([
                    'message' => 'Two or more image needed',
                ], 400);
            }
        } else {
            return response([
                'message' => 'Error creating room',
            ], 400);
        }
    }

    public function view($room_id)
    {

        $room = Roomate::with('roomImage')->whereId($room_id)->first();

        return response([
            'room' => $room,
        ], 200);
    }

    public function applyToRoom($room_id)
    {
        try {
            $room = Roomate::find($room_id);
            if ($room) {
                $check_applied = Applied::where('user_id', auth()->id())->where('room_id', $room_id)->get();
                if (count($check_applied) < 1) {
                    Applied::create([
                        'user_id' => auth()->id(),
                        'room_id' => $room_id,
                        'owner_id' => $room->id
                    ]);
                    return response([
                        'message' => 'success'
                    ], 200);
                } else {
                    return response([
                        'message' => 'Already applied'
                    ], 400);
                }
            } else {
                return response([
                    'message' => 'Room not found'
                ], 404);
            }
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ]);
        }
    }
}
