<?php

namespace App\Http\Controllers\Subscription;

use App\Http\Controllers\Controller;
use App\Models\AccountingSystemUser;
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
            ->select('subscriptions.*', 't.count', 'subscription_users.id as subscription_user_id', 'subscription_users.is_accepted')
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

    public function ajaxAcceptInvitation(Request $request)
    {
        $subscriptionUser = SubscriptionUser::find($request->id);
        $subscriptionUser->is_accepted = true;
        $subscriptionUser->save();

        return response()->json([
            'success' => true,
        ]);
    }

    public function ajaxRejectInvitation(Request $request)
    {
        $subscriptionUser = SubscriptionUser::find($request->id);

        $as_user = AccountingSystemUser::where('subscription_user_id', $subscriptionUser->id)->get();
        for($i = 0; $i < count($as_user); $i++) {
            $as_user[$i]->permissions()->delete();
            $as_user[$i]->delete();
        }

        $subscriptionUser->delete();

        return response()->json([
            'success' => true,
        ]);
    }

    // TODO: Add non-ajax call to the 2 buttons above.
}
