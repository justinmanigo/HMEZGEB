<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HasSubscriptionMiddleware
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
        $subscription_admin_count = \App\Models\SubscriptionUser::where('user_id', auth()->id())->count();

        if($subscription_admin_count == 0) {
            return abort(403);
        }

        return $next($request);
    }
}
