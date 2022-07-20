<?php

namespace App\Http\Controllers\Subscription;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subscription\ManageAccountingSystems\SelectSubscriptionRequest;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;

class ManageAccountingSystemsController extends Controller
{
    public function index()
    {
        // Get accounting systems of current subscription
        $user = User::find(auth()->id());
        $user->subscriptions;

        $total_accts = 0;
        $total_acct_limit = 0;
        for($i = 0; $i < count($user->subscriptions); $i++) {
            $user->subscriptions[$i]->accountingSystems;
            $total_accts += $user->subscriptions[$i]->accountingSystems->count();
            $total_acct_limit += $user->subscriptions[$i]->account_limit;
        }

        return view('subscription.accounting_system.index', [
            'user' => $user,
            'total_accts' => $total_accts,
            'total_acct_limit' => $total_acct_limit,
        ]);
    }

    public function ajaxSelectSubscription(SelectSubscriptionRequest $request)
    {
        $this->request->session()->put('subscription_id', $request->subscription_id);
        return response()->json(['success' => true]);
    }
}
