<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'plan_id' =>['required' , 'integer'],
            'period' => ['required' , 'integer' , 'min:1'],
        ]);

       $plan =  Plan::findOrFail($request->post('plan_id'));
        $months = $request->post('period');
        Subscription::forceCreate([
            'plan_id' => $plan->id ,//$request->post('plan_id')
            'user_id' => Auth::user()->id , //$request->user()->id
            'expires_at' => now()->addMonth($months),
            'price' => $plan->price * $months ,

        ]);

    }
}
