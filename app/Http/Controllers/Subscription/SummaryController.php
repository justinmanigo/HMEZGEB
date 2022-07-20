<?php

namespace App\Http\Controllers\Subscription;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SummaryController extends Controller
{
    public function index()
    {
        $subscriptions = auth()->user()->subscriptions;
        foreach($subscriptions as $subscription) {
            $subscription->accountingSystems;
        }

        return view('subscription.index', [
            'subscriptions' => $subscriptions,
        ]);
    }
}
