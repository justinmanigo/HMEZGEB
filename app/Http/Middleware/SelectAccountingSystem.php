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
        
        // If exists, check if the accounting system user belongs to the accounting system.
        if(!$accountingSystem->accountingSystemUsers()->where('user_id', Auth::id())->count()) {
            $request->session()->forget('accounting_system_id');
            return redirect('/switch')->with('danger', "You don't have the privileges to access that accounting system.");
        }

        return $next($request);
    }
}
