<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Jenssegers\Agent\Agent;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
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
        if(! $request->expectsJson()) {
            //            return route('login');
            return route('classroom.index');
        }
    }
}
