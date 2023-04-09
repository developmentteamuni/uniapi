<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\EventImages;
use App\Models\Friend;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'event_title' => 'required',
                'location' => 'required',
                'date' => 'required',
                'time' => 'required',
                'description' => 'required',
                'ticket_count' => 'required',
                'ticket_price' => 'required',
                // 'image' => 'required',
                // 'invited_users' => 'required'
            ]);

            $dataToCreate = [
                'hoster_id' => auth()->id(),
                'event_title' => $request->event_title,
                'location' => $request->location,
                'date' => $request->date,
                'time' => $request->time,
                'description' => $request->description,
                'ticket_count' => $request->ticket_count,
                'recommended_donation_box' => $request->recommended_donation_box,
                'ticket_price' => $request->ticket_price,
                'user_id' => [],
            ];


            // old
            // $image = $request->file('image');
            // $imageName = date('YmdHi') . $image->getClientOriginalName();
            // $image->move(public_path('public/eventImages'), $imageName);
            // $dataToCreate['image'] = $imageName;

            $event = Event::create($dataToCreate);

            if ($event) {
                if ($request->hasFile('image')) {
                    $im = $request->file('image');
                    for ($i = 0; $i < count($im); $i++) {
                        $imageName = date('YmdHi') . $im[$i]->getClientOriginalName();
                        $im[$i]->move(public_path('public/eventImages'), $imageName);
                        $imageDB = new EventImages();
                        $imageDB->event_id = $event->id;
                        $imageDB->image_name = $imageName;
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
                    'message' => 'Error creating Event',
                ], 400);
            }
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getFriendsToInvite()
    {
        $getIds = Friend::where('user_id', auth()->id())->pluck('follower_id')->toArray();
        $friends = User::whereIn('id', $getIds)->get();

        return response([
            'friends' => $friends
        ], 200);
    }

    public function getUserEvents()
    {
        $events = Event::where('hoster_id', auth()->id())
            ->orWhereIn('user_id', User::all()->pluck('id')->toArray())
            ->get();

        return response([
            'events' => $events
        ], 200);
    }

    public function scanTicket($event_id)
    {
        $event = Event::find($event_id)->get();
        $ticket = Ticket::count();

        Ticket::create([
            'user_id' => auth()->id(),
            'ticket_number' => str_pad($ticket + 1, 3, '0', STR_PAD_LEFT),
            'date_purchased' => Carbon::now(),
        ]);

        return response([
            'message' => 'success'
        ], 201);
    }

    public function getAttendance($event_id)
    {
        $attendances = Ticket::with('user.profile')->latest()->get();

        return response([
            'attendances' => $attendances
        ], 200);
    }

    public function explore()
    {
        $events = Event::latest()->get();

        return response([
            'events' => EventResource::collection($events),
        ], 200);
    }

    public function getEvent($id)
    {
        $event = Event::whereId($id)->first();

        return response([
            'events' => new EventResource($event),
        ], 200);
    }
}
