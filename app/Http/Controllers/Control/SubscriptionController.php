<?php

namespace App\Http\Controllers\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\Control\ActivateSubscriptionRequest;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::select(
                'subscriptions.id',
                'subscriptions.account_limit',
                'subscriptions.account_type',
                'subscriptions.date_from',
                'subscriptions.date_to',
                'subscriptions.status',
                // 'subscriptions.user_id',
                'users.firstName',
                'users.lastName',
            )
            ->leftJoin('users', 'users.id', '=', 'subscriptions.user_id')
            ->get();

        // return $subscriptions;

        return view('control_panel.subscriptions.index', [
            'subscriptions' => $subscriptions
        ]);
    }

    public function activate(ActivateSubscriptionRequest $request)
    {
        // $subscription->activate();
        // return redirect()->route('control.subscriptions.index');
    }


    public function suspend(Subscription $subscription)
    {

    }

    public function reinstate(Subscription $subscription)
    {

    }
}
