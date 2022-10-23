<?php

namespace App\Http\Controllers\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\Control\ActivateSubscriptionRequest;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

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
                DB::raw('CONCAT(referrers.firstName, " ", referrers.lastName) as referred_by')
            )
            ->leftJoin('users', 'users.id', '=', 'subscriptions.user_id')
            ->leftJoin('referrals', 'referrals.id', '=', 'subscriptions.referral_id')
            ->leftJoin('users as referrers', 'users.id', '=', 'referrals.user_id')
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

        // Get owner of subscription
        $owner = $subscription->user;

        Mail::to($owner->email)->queue(new \App\Mail\Control\Subscription\ActivateSubscription($owner, $subscription));

        return response()->json([
            'success' => true,
            'message' => 'Subscription activated successfully.',
        ]);
    }

    public function suspend(Subscription $subscription)
    {
        $subscription->status = 'suspended';
        $subscription->save();

        // Get owner of subscription
        $owner = $subscription->user;
        Mail::to($owner->email)->queue(new \App\Mail\Control\Subscription\SuspendSubscription($owner, $subscription));

        return response()->json([
            'success' => true,
            'message' => 'Subscription suspended successfully.',
        ]);
    }

    public function reinstate(Subscription $subscription)
    {
        $subscription->status = 'active';
        $subscription->save();

        // Get owner of subscription
        $owner = $subscription->user;

        Mail::to($owner->email)->queue(new \App\Mail\Control\Subscription\ReinstateSubscription($owner, $subscription));

        return response()->json([
            'success' => true,
            'message' => 'Subscription reinstated successfully.',
        ]);
    }
}