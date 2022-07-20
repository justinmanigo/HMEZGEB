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
        $subscriptions_count = \App\Models\Subscription::where('user_id', auth()->id())->count();

        if($subscriptions_count == 0) {
            return abort(403);
        }

        return $next($request);
    }
}
