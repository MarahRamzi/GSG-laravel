<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Stripe\StripeClient;

class PaymentsController extends Controller
{
    public function store(Request $request  ) //store route must include subscription_id
    {

        $subscription = Subscription::findOrFail($request->subscription_id);
        
        $stripe = new StripeClient(config('services.stripe.secret_key'));
        try {
            // Create a PaymentIntent with amount and currency
            $paymentIntent = $stripe->paymentIntents->create([
                'amount' => $subscription->price * 100 ,
                'currency' => 'aed',
                // In the latest version of the API, specifying the `automatic_payment_methods` parameter is optional because Stripe enables its functionality by default.
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            return [
                'clientSecret' => $paymentIntent->client_secret,
            ];

        } catch (Error $e) {
           return Response::json([
            'error' => $e->getMessage()
            ], 500);
        }
    }

    public function create(Subscription $subscription)
    {
        return view('checkout' , [
            'subscription' => $subscription,
        ]);
    }

    public function success(Request $request)
    {
        // return $request->all();
        $stripe = new \Stripe\StripeClient("{{config('services.stripe.secret_key}}");
        $payment_intent = $stripe->paymentIntents->retrieve(
        $request->input('payment_intent'),
        []
);
dd($payment_intent); 
    }

    public function cancel(Request $request)
    {
        return $request->all();

    }
}