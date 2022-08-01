<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserHasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $sub_module_id)
    {        
        $as_user_id = session('accounting_system_user_id');
        $permission = \App\Models\Settings\Users\Permission::where('accounting_system_user_id', $as_user_id)
            ->where('sub_module_id', $sub_module_id)
            ->count();

        if($permission == 0) {
            abort(403, 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
