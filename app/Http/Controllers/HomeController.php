<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AccountingSystemUser;
use Illuminate\Support\Facades\Auth;
use App\Actions\GetLatestAccountingPeriod;
use App\Actions\GetLoggedAccountingSystemUserId;

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
        $user = User::find(Auth::id());
        $user->accountingSystemUsers;

        // If the number of accounting systems' is only one, skip ahead to dashboard.
        if(count($user->accountingSystemUsers) == 1) {
            $accounting_system_user = GetLoggedAccountingSystemUserId::run($user->accountingSystemUsers[0]->accounting_system_id, Auth::id());

            $latest_accounting_period = GetLatestAccountingPeriod::run($user->accountingSystemUsers[0]->accounting_system_id);
            
            $this->request->session()->put('accounting_system_id', $user->accountingSystemUsers[0]->accounting_system_id);
            $this->request->session()->put('accounting_system_user_id', $accounting_system_user->id);
            $this->request->session()->put('accounting_period_id', $latest_accounting_period->id);

            return redirect('/');
        }
        
        // Otherwise, let the authenticated user select which accounting system to manage.
        return view('view-accounting-systems', [
            'accountingSystems' => AccountingSystemUser::leftJoin('accounting_systems', 
                'accounting_systems.id', '=', 'accounting_system_users.accounting_system_id')
                ->where('user_id', Auth::id())
                ->get()
        ]);
    }

    public function switchAccountingSystem()
    {
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
        
        return redirect('/');
    }


   

}
