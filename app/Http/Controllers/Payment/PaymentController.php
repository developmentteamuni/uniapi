<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
    }

    public function pay()
    {
        $checkout_session = \Stripe\Checkout\Session::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Event',
                        ],
                        'unit_amount' => 500
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => 'http://127.0.0.1:8000/api/event/success',
            'cancel_url' => 'http://127.0.0.1:8000/cancel.html',
        ]);

        print_r($checkout_session);
    }

    public function success()
    {
        dd(auth()->id());
    }
}
