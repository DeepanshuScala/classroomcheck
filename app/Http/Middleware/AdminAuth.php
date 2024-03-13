<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuth {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next) {
        if (Auth::user() && Auth::user()->role_id == 3) {
            if (auth()->user()->status == 0 || auth()->user()->verified == 0) {
                return \Illuminate\Support\Facades\Redirect::to('login')->with('error', 'Account not activated');
            } /* else if (auth()->user()->is_deleted == 1) {
              return \Illuminate\Support\Facades\Redirect::to('login')->with('error', 'Account Deleted');
              } */ else {
                return $next($request);
            }
        } else {
            return \Illuminate\Support\Facades\Redirect::to('login')->with('error', 'Access Denied');
        }
    }

}
