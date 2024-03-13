<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
Use App\Models\User;
use Illuminate\Support\Facades\{Auth ,Route};

class RoleCheck {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $role) {
        
        $roles = [
            'account' => 1,
            'store' => 2
        ];

        $cur_route = Route::currentRouteName();
        $role_ids = $roles[$role] ?? [];

        if ($cur_route != 'storeDashboard.aboutSelling' && !in_array(auth()->user()->role_id, [$role_ids])) {
            
            $email = $email = auth()->user()->email;
            $userData = User::where('role_id', $role_ids)->where('email', $email)->first();
            if ($userData == null) {
                if(auth()->user()->role_id==3)
                   return \Illuminate\Support\Facades\Redirect::to(route('classroom.index')); 
                else
                    abort(403);
            } else {
                if (!Auth::loginUsingId($userData->id)) {
                    abort(403);
                }
            }
            //return \Illuminate\Support\Facades\Redirect::to(route('login'));
        }
        elseif(auth()->check() && auth()->user()->status == 0){
            
            $sellerinfo = User::where('email',auth()->user()->email)->where('role_id',2)->first();
            $buyerinfo = User::where('email',auth()->user()->email)->where('role_id',1)->first();
            
            //For adding error message when buyer clicked on add to cart and add to fav button 
            if($cur_route == 'addToFavourite' || $cur_route == 'addToCart' ){
                $msg = (auth()->user()->is_deleted == 1)?"Buyer Account is deleted.":"Buyer Account is deactivated. Please contact admin!";
                throw new Exception($msg);
            }
            if(auth()->user()->role_id == 2 && $buyerinfo->status == 1){
                if($sellerinfo->is_deleted == 1){
                    return \Illuminate\Support\Facades\Redirect::to(route('classroom.index'))->with('error','Seller Account is deleted.');
                }
                else{
                    return \Illuminate\Support\Facades\Redirect::to(route('classroom.index'))->with('error','Seller Account is deactivated. Please contact admin!');
                }
            }
            elseif(auth()->user()->role_id == 1 && $sellerinfo->status == 1){
                if($buyerinfo->is_deleted == 1){
                    return \Illuminate\Support\Facades\Redirect::to(route('classroom.index'))->with('error','Buyer Account is deleted.');
                }
                else{
                    return \Illuminate\Support\Facades\Redirect::to(route('classroom.index'))->with('error','Buyer Account is deactivated. Please contact admin!');
                }
            }
            else{
                Auth::logout();
            }
        }
        // elseif(auth()->check() && $role == 'store' && auth()->user()->status == 0 && $cur_route != 'storeDashboard.storeSetup' && $cur_route != 'storeDashboard.checkStoreNameAvailability'){
        //     $sellerinfo = User::where('email',auth()->user()->email)->where('role_id',2)->first();
        //     if($sellerinfo->process_completion != 3){
        //         return \Illuminate\Support\Facades\Redirect::to(route('classroom.index'));  
        //     }
        // }
        return $next($request);
    }

}