<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AccountingSystemUser;
use Illuminate\Support\Facades\Auth;
use App\Actions\GetLatestAccountingPeriod;
use App\Actions\GetLoggedAccountingSystemUserId;
use App\Models\SubscriptionUser;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function viewAccountingSystems()
    {
        // Retrieves the accounting systems' the authenticated user belongs.
        // $user = User::find(Auth::id());

        $acct_systems = SubscriptionUser::select(
                'accounting_systems.id as accounting_system_id', 
                'accounting_systems.name',
                'accounting_systems.accounting_year',
                'accounting_systems.calendar_type',
                'subscriptions.id as subscription_id',
                'users.firstName as user_first_name',
                'users.lastName as user_last_name',
            )
            ->where('subscription_users.user_id', Auth::id())
            ->rightJoin('accounting_system_users', 'subscription_users.id', '=', 'accounting_system_users.subscription_user_id')
            ->leftJoin('accounting_systems', 'accounting_system_users.accounting_system_id', '=', 'accounting_systems.id')
            ->leftJoin('subscriptions', 'subscription_users.subscription_id', '=', 'subscriptions.id')
            ->leftJoin('users', 'subscriptions.user_id', '=', 'users.id')
            ->where('subscription_users.is_accepted', true)
            ->get();

        $this->request->session()->put('acct_system_count', count($acct_systems));

        // If the number of accounting systems' is only one, skip ahead to dashboard.
        if(count($acct_systems) == 1) {
            $accounting_system_user = GetLoggedAccountingSystemUserId::run($acct_systems[0]->accounting_system_id, Auth::id());

            $latest_accounting_period = GetLatestAccountingPeriod::run($acct_systems[0]->accounting_system_id);
            
            $this->request->session()->put('accounting_system_id', $acct_systems[0]->accounting_system_id);
            $this->request->session()->put('accounting_system_user_id', $accounting_system_user->id);
            $this->request->session()->put('accounting_period_id', $latest_accounting_period->id);

            return redirect('/');
        }
        
        // Otherwise, let the authenticated user select which accounting system to manage.
        // return view('view-accounting-systems', [
        return view('switch', [
            'accountingSystems' => $acct_systems,
        ]);
    }

    /**
     * AJAX Call for /switch
     */
    public function switchAccountingSystem()
    {
        // return $this->request;
        // Get the accounting system user id.
        $accounting_system_user = GetLoggedAccountingSystemUserId::run($this->request->accounting_system_id, Auth::id());
        
        // If the result is null, redirect him back to the accounting system selection page.
        if(!$accounting_system_user) return redirect('/switch')->with('danger', "You are not a member of this accounting system.");

        $latest_accounting_period = GetLatestAccountingPeriod::run($this->request->accounting_system_id);

        // Otherwise, add accounting_system_id, accounting_system_user_id, and accounting_period_id to
        // current session
        $this->request->session()->put('accounting_system_id', $this->request->accounting_system_id);
        $this->request->session()->put('accounting_system_user_id', $accounting_system_user->id);
        $this->request->session()->put('accounting_period_id', $latest_accounting_period->id);
        
        // return redirect('/');
        return response()->json([
            'success' => true,
        ]);
    }
}
