<?php

namespace App\Http\Controllers\Subscription;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SummaryController extends Controller
{
    public function index()
    {
        $subQuery = DB::table('accounting_systems')
            ->select('subscription_id as id', DB::raw('COUNT(subscription_id) as count'))
            ->groupBy('subscription_id');
        
        $subscriptions = SubscriptionUser::where('subscription_users.user_id', auth()->id())
            ->select('subscriptions.*', 't.count')
            ->leftJoin('subscriptions', 'subscriptions.id', '=', 'subscription_users.subscription_id')
            // left join get accounting systems count of subscriptions
            ->leftJoinSub($subQuery, 't', function($join){
                $join->on('t.id', '=', 'subscriptions.id');
            })
            ->where('subscription_users.role', '!=', 'member')
            ->where('subscription_users.role', '!=', 'moderator')
            ->get();

        // return $subscriptions;

        // $subscriptions = auth()->user()->subscriptions;
        // foreach($subscriptions as $subscription) {
        //     $subscription->accountingSystems;
        // }

        return view('subscription.index', [
            'subscriptions' => $subscriptions,
        ]);
    }
}
