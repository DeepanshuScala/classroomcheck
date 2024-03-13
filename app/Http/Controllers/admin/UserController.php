<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User,Product,OrderItem,Order};
use Illuminate\Support\Facades\{
    Auth,
    Crypt,
    Mail,
    Redirect,
    Session,
    Storage,
    DB
};

class UserController extends Controller {

    /** + 
     * used to get buyers list
     * @param Request $request - request type get
     * @return type
     */
    public function getBuyers(Request $request) {
        $users = User::with(['getUserSettings'])->where('role_id', 1)->orderBy('id', 'DESC')->get();
        return view('admin.pages.users.list', compact('users'));
    }

    /** + 
     * used to get sellers list
     * @param Request $request - request type get
     * @return type
     */
    public function getSellers(Request $request) {
        if(isset($request['id']) && isset($request['make_admin'])){
            User::where('id',$request['id'])->update(['is_admin_relative'=>2]);
        }
        elseif(isset($request['id']) && isset($request['remove_admin'])){
            User::where('id',$request['id'])->update(['is_admin_relative'=>0]);
        }
        $users = User::where('process_completion',3)->where('role_id', 2)->orderBy('id', 'DESC')->get();
        return view('admin.pages.users.list', compact('users'));
    }

    public function getUserInfo(Request $request, $user_id) {
        $uid = base64_decode($user_id);

        $users = User::with(['store'])->find($uid);
        if ($users == null) {
            return redirect()->back()->with('error', "User not valid");
        } else {
            $total_sales = Order::with(['orderProduct'])->where('user_id',$uid)->where('status',1)->orderBy('id','DESC')->get();
            //$total_sales = [];
            return view('admin.pages.users.user_details', compact(['users','total_sales']));
        }
    }

    /** + 
     * 
     * used to activate/deactivate user account
     * @param type $user_id - id of user
     * @param type $status - account status of user(0 - deactive, 1 - active)
     * @return type
     */
    public function activateDeactivateUserAccount($user_id, $status) {
        try {
            // $userinfo = User::where('id', $user_id)->first();
            // echo "<pre>";
            // print_r($userinfo->role_id);
            // print_r($status);
            // echo "</pre>";
            // die();
            $userData = User::where('id', $user_id)->first();
            if ($userData == null) {
                return redirect()->back()->with('error', "User not valid");
            }
            $msgTxt = ($status == 0) ? 'deactivated' : 'activated';
            if ($userData->status == $status) {
                return redirect()->back()->with('error', "User account already $msgTxt");
            }
            User::where('id', $user_id)->update([
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            
            //Activate product
            $userinfo = User::where('id', $user_id)->first();
            if($status == 1 && $userinfo->role_id == 2){
                $up = Product::where('user_id',$user_id)->update(['status'=>1]);
            }
            elseif($userinfo->role_id == 1){
                $up = Product::where('user_id',$user_id)->update(['status'=>0]);   
            }
            
            return redirect()->back()->with('success', "User account $msgTxt successfully");
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    /** + 
     * 
     * used to delete user account
     * @param type $user_id - id of user
     * @return type
     */
    public function deleteUserAccount($user_id) {
        try {
            $userData = User::where('id', $user_id)->first();
            if ($userData == null) {
                return Redirect::to('admin/member-management')->with('error', "User not valid");
            }
            if ($userData->is_deleted == 1) {
                return Redirect::to('admin/member-management')->with('error', "User account already deleted");
            }
            User::where('email', $userData->email)->update([
                'status'    =>0,
                'is_deleted' => 1,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            //Deactive product if any
            $seller = User::where('email',$userData->email)->where('role_id',2)->first();
            $up = Product::where('user_id',$seller->id)->update(['status'=>0]);

            User::where('email', $userData->email)->update([
                'email'    =>$userData->email.time(),
            ]);

            return Redirect::to('admin/member-management')->with('success', "Account deleted successfully");
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/member-management')->with('error', $exception);
        }
    }

}