<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\AccountingSystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SelectAccountingSystem
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // If current session does not have a selected accounting system.
        if($request->session()->get('accounting_system_id') == null) {
            return redirect('/switch');
        }

        // Retrieve accounting system info.
        $accountingSystem = AccountingSystem::find($request->session()->get('accounting_system_id'));

        // Check if the accounting system queried actually exists.
        if(!$accountingSystem) {
            $request->session()->forget('accounting_system_id');
            return redirect('/switch')->with('danger', 'The accounting system you selected no longer exists.');
        }
        
        // If exists, check if the user is allowed to access the accounting system.
        $subscription = $accountingSystem->subscription;
        $subscriptionUser = $subscription->subscriptionUsers()->where('user_id', Auth::id())->first();

        if(!$subscriptionUser) {
            $request->session()->forget('accounting_system_id');
            return redirect('/switch')->with('danger', 'You are not allowed to access this accounting system.');
        }
        else if($subscription->date_to < now()->format('Y-m-d')) {
            $request->session()->forget('accounting_system_id');
            return redirect('/switch')->with('danger', 'The subscription that the current accounting system you accessed is already expired.');
        }
        else if($subscription->status == 'suspended') {
            $request->session()->forget('accounting_system_id');
            return redirect('/switch')->with('danger', 'The subscription that the current accounting system you accessed has been suspended.');
        }

        return $next($request);
    }
}
