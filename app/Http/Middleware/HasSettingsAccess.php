<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HasSettingsAccess
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
        if(session('subscription_user_role') == 'member') {
            return abort(403, 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
