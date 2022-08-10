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

    public function activate(Subscription $subscription, ActivateSubscriptionRequest $request)
    {
        $subscription->status = 'active';
        $subscription->date_to = $request->expiration_date;
        $subscription->save();

        return response()->json([
            'success' => true,
            'message' => 'Subscription activated successfully.',
        ]);
    }

    public function suspend(Subscription $subscription)
    {
        $subscription->status = 'suspended';
        $subscription->save();

        return response()->json([
            'success' => true,
            'message' => 'Subscription suspended successfully.',
        ]);
    }

    public function reinstate(Subscription $subscription)
    {
        $subscription->status = 'active';
        $subscription->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Subscription reinstated successfully.',
        ]);
    }
}
