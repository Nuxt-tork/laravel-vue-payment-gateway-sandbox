<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        $request->validate([
            'course_id' => 'required',
            'course_name' => 'required',
            'course_price' => 'required|numeric',
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $request->course_name,
                    ],
                    'unit_amount' => intval($request->course_price * 100),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success'),
            'cancel_url' => route('checkout'),
        ]);

        return response()->json(['id' => $session->id, 'session' => $session]);
    }

    public function handleWebhook(Request $request)
    {
        // Optional: Implement webhook handler for Stripe events
    }
}
