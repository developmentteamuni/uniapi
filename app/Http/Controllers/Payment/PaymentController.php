<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\PaidUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{

    public function __construct()
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
    }

    public function pay($event_id)
    {

        $event = Event::whereId($event_id)->first();
        if (!$event) {
            return response([
                'message' => 'No such event'
            ], 500);
        }

        PaidUser::create([
            'user_id' => auth()->id(),
            'event_id' => $event_id,
            'price' => $event->ticket_price,
        ]);

        $checkout_session = \Stripe\Checkout\Session::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $event->event_title,
                        ],
                        'unit_amount' => $event->ticket_price
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => 'http://127.0.0.1:8000/event/success/' . auth()->id(),
            'cancel_url' => 'http://127.0.0.1:8000/cancel.html',
        ]);

        return response([
            'url' => $checkout_session['url'],
            'user_id' => auth()->id(),
        ]);
    }

    public function success($id)
    {
        $paid = PaidUser::whereUserId($id)->update([
            'paid' => true,
        ]);

        if ($paid) {
            return response([
                'message' => 'success',
            ], 200);
        } else {
            return response([
                'message' => 'Error',
            ], 400);
        }
    }
}
