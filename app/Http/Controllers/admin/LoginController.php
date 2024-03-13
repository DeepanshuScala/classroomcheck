<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    DB,
    Auth,
    Validator,
    Hash,
    Mail,
    Session,
    Redirect
};
use App\Models\User;
use Exception;

class LoginController extends Controller {

    /** + 
     * 
     * used to login in admin
     * @param Request $request
     * @return type
     */
    public function login(Request $request) {
        try {
            if ($request->isMethod('post')) {
                $validator = Validator::make($request->all(), [
                            'email' => 'required|email',
                            'password' => 'required',
                ]);

                if ($validator->fails()) {
                    Session::flash('error', $validator->errors()->first());
                    return Redirect::to('login');
                }
                try {
                    $user = User::where('email', $request->email)->first();
                    if ($user == null) {
                        Session::flash('error', "Email is not associated with this website");
                        return Redirect::to('login');
                    }
                    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                        $user = Auth::user();
                        if ($user->status == 0 || $user->verified == 0) {
                            Auth::logout();
                            Session::flash('error', "Account not activated");
                            return Redirect::to('login');
                        }if ($user->role_id != 3) {
                            Auth::logout();
                            Session::flash('error', "Access Denied");
                            return Redirect::to('login');
                        }
                        return Redirect::to('admin/dashboard');
                    } else {
                        Session::flash('error', "Email/Password not valid");
                        return Redirect::to('login');
                    }
                } catch (Exception $ex) {
                    Session::flash('error', $ex->getMessage());
                    return Redirect::to('login');
                }
            } else {
                return view('admin.login');
            }
        } catch (NotFoundHttpException $exception) {
            Session::flash('error', $exception);
            return view('admin.login');
        }
    }

    /** + 
     * 
     * used to logout from admin
     * @param Request $request
     * @return type
     */
    public function logout(Request $request) {
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            return Redirect::to('login');
        } else {
            return redirect()->back()->with('error', 'Error in logout');
        }
    }

}
