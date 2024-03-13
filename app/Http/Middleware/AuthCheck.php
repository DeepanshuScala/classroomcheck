<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Redirect ,Route};
use Jenssegers\Agent\Agent;

class AuthCheck {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next) {
        $crawlersfb = 'facebookexternalhit/1.1'; 
        $crawlersfb1 = 'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)'; 
        $crawlersfb2 = 'Facebot'; 
        $crawlerstwt = 'Twitterbot/1.0'; 
        $crawlerstwt1 = 'Mozilla/5.0 (compatible; Twitterbot/1.0)'; 
        $crawlerstwt2 = 'Mozilla/5.0 (Twitterbot/0.1)'; 
        $crawlerspin = 'Pinterest/0.2';

        $userAgent = $request->header('User-Agent');

        $agent = new Agent();
        if ($agent->isRobot() || str_contains($crawlerstwt, $userAgent)|| str_contains($crawlerstwt1, $userAgent)|| str_contains($crawlerstwt2, $userAgent)) {
            return $next($request);
        }


        $cur_route = Route::currentRouteName();

        if(!auth()->user() && $cur_route != 'storeDashboard.aboutSelling'){
//            return Redirect::route('view.login');
            return \Illuminate\Support\Facades\Redirect::to(route('classroom.index'));
        }
        return $next($request);
    }
}
