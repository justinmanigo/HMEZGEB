<?php

namespace App\Http\Controllers\Subscription;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subscription\ManageAccountingSystems\SelectSubscriptionRequest;
use App\Models\AccountingSystemUser;
use App\Models\Subscription;
use App\Models\SubscriptionUser;
use App\Models\User;
use Illuminate\Http\Request;

class ManageAccountingSystemsController extends Controller
{
    public function index()
    {
        // Get accounting systems where the current user has access with
        $subscription_access = SubscriptionUser::where('user_id', auth()->id())->get();
        // return $subscription_access;

        $result = [];

        for($i = 0; $i < count($subscription_access); $i++)
        {
            $result[$i]['subscription'] = Subscription::find($subscription_access[$i]->subscription_id);

            // Show all accounting systems if the authenticated user is the owner
            if(auth()->id() == $result[$i]['subscription']->user_id) {
                $result[$i]['accounting_systems'] = $result[$i]['subscription']->accountingSystems;
            }
            // Else, show only the accounting systems that he has access at the moment
            else {
                $result[$i]['accounting_systems'] = AccountingSystemUser::select('accounting_systems.*')
                    ->where('subscription_user_id', $subscription_access[$i]->id)
                    ->leftJoin('accounting_systems', 'accounting_system_users.accounting_system_id', '=', 'accounting_systems.id')
                    ->get();
            }
        }

        // return $result;


        // Get accounting systems of current subscription
        // $user = User::find(auth()->id());
        // $user->subscriptions;

        // $total_accts = 0;
        // $total_acct_limit = 0;
        // for($i = 0; $i < count($user->subscriptions); $i++) {
        //     $user->subscriptions[$i]->accountingSystems;
        //     $total_accts += $user->subscriptions[$i]->accountingSystems->count();
        //     $total_acct_limit += $user->subscriptions[$i]->account_limit;
        // }

        return view('subscription.accounting_system.index', [
            'result' => $result,
        ]);
    }

    public function ajaxSelectSubscription(SelectSubscriptionRequest $request)
    {
        $this->request->session()->put('subscription_id', $request->subscription_id);
        return response()->json(['success' => true]);
    }
}
