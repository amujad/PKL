<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if(Auth::user()->user_type =='admin'){
                    return redirect(route('dashboardAdmin'));
                }
                else if(Auth::user()->user_type == 'pos'){
                    return redirect(route('dashboardPos'));
                }
                else{
                    return redirect(route('mejaIII'));
                }
            }
        }

        return $next($request);
    }
}
