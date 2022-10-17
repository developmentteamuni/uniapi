<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Friend;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'event_title' => 'required',
            'location' => 'required',
            'date' => 'required',
            'time' => 'required',
            'description' => 'required',
            'ticket_count' => 'required',
            'recommended_donation_box' => 'required',
            'ticket_price' => 'required',
            'image' => 'image',
            'invited_users' => 'required'
        ]);

        $dataToCreate = [
            'hoster_id' => $request->hoster_id,
            'event_title' => $request->event_title,
            'location' => $request->location,
            'date' => $request->date,
            'time' => $request->time,
            'description' => $request->description,
            'ticket_count' => $request->ticket_count,
            'recommended_donation_box' => $request->recommended_donation_box,
            'ticket_price' => $request->ticket_price,
            'image' => $request->image,
            'user_id' => $request->invited_users,
        ];

        $image = $request->file('image');
        $imageName = date('YmdHi') . $image->getClientOriginalName();
        $image->move(public_path('public/eventImages'), $imageName);
        $dataToCreate['image'] = $imageName;

        $event = Event::create($dataToCreate);

        if ($event) {
            return response([
                'message' => 'success'
            ], 201);
        }
    }

    public function getFriendsToInvite()
    {
        $friends = Friend::where('user_id', auth()->id())->pluck('follower_id');

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
            'events' => $events
        ], 200);
    }
}
