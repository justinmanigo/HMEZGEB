<?php

namespace App\Http\Controllers\Subscription;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subscription\ManageAccountingSystems\SelectSubscriptionRequest;
use App\Models\AccountingSystem;
use App\Models\AccountingSystemUser;
use App\Models\Subscription;
use App\Models\SubscriptionUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageAccountingSystemsController extends Controller
{
    public function index()
    {
        // Get accounting systems where the current user has access with
        $subscription_access = SubscriptionUser::where('user_id', auth()->id())
            ->where('subscription_users.role', '!=', 'member')
            ->where('subscription_users.role', '!=', 'moderator')
            ->get();
        // return $subscription_access;

        $result = [];

        for($i = 0; $i < count($subscription_access); $i++)
        {
            $result[$i]['subscription'] = Subscription::find($subscription_access[$i]->subscription_id);

            $subQuery = DB::table('accounting_system_users')
                ->select('accounting_system_id as id', DB::raw('COUNT(accounting_system_id) as hasAccess'))
                ->where('subscription_user_id', $subscription_access[$i]->id)
                ->groupBy('accounting_system_id');

            $result[$i]['accounting_systems'] = AccountingSystem::select(
                    'accounting_systems.*',
                    DB::raw('IFNULL(t.hasAccess, 0) as hasAccess')
                )   
                ->where('subscription_id', $subscription_access[$i]->subscription_id)
                ->leftJoinSub($subQuery, 't', function($join){
                    $join->on('t.id', '=', 'accounting_systems.id');
                })
                ->get();
        }

        // return $result;

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
