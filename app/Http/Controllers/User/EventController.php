<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Http\Resources\TicketResource;
use App\Models\Event;
use App\Models\EventImages;
use App\Models\Friend;
use App\Models\PaidUser;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EventController extends Controller
{
    public function store(Request $request)
    {
        try {
            $rand = rand(0, 5000000);
            $image_qr = $rand . 'qrcode.svg';
            QrCode::format('svg')->generate($request->event_title, '../public/public/qrImages/' . $image_qr);

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
                'available' => $request->ticket_count,
                'recommended_donation_box' => $request->recommended_donation_box,
                'ticket_price' => $request->ticket_price,
                'qr_codes' => $image_qr,
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
            'events' => EventResource::collection($events)
        ], 200);
    }


    public function buyTicket($event_id)
    {
        try {
            $event = Event::find($event_id);
            if ($event->available == 0) {
                return response([
                    'message' => 'Event has been sold out'
                ], 400);
            }
            $paid = PaidUser::create([
                'user_id' => auth()->id(),
                'event_id' => $event_id,
                'paid' => 1,
                'price' => $event->ticket_price
            ]);

            if ($paid) {
                $available = (int) $event->ticket_count - 1;
                $buyEvent = Event::whereId($event_id)->update(['available' => $available]);
                if ($buyEvent) {
                    $rand = rand(0, 5000000);
                    $image_qr = $rand . 'qrcode.svg';
                    QrCode::format('svg')->generate("Event ID: " . $event_id . " " . "User ID" . " " . auth()->id(), '../public/public/qrImages/' . $image_qr);
                    Ticket::create([
                        'user_id' => auth()->id(),
                        'date_purchased' => Carbon::now(),
                        'ticket_number' => "UNI" . rand(0, 100),
                        'qr_code' => $image_qr,
                        'event_id' => $event_id,
                    ]);

                    return response([
                        'message' => 'success',
                    ], 200);
                } else {
                    return response([
                        'message' => 'Error',
                    ], 500);
                }
            } else {
                return response([
                    'message' => 'Error',
                ], 500);
            }
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function qrCodeList($event_id)
    {
        try {
            $ticket = Ticket::whereUserId(auth()->id())->whereEventId($event_id)->get();
            return response([
                'ticket' => TicketResource::collection($ticket)
            ], 200);
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage()
            ], 500);
        }
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
        $events = Event::where('user_id', '!=', Auth::id())->latest()->get();

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
