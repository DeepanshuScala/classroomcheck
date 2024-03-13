<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    DB,
    Session,
    Redirect,
    Auth
};
use \App\Models\{
    User,
    Follower
};
use \App\Http\Helper\Web;

class FollowController extends Controller {

    /** + 
     * used to follow/unfollow seller
     * @param Request $request - request typw post
     * @return type
     */
    public function followUnfollowSeller(Request $request) {
        $responseArray = ['success' => false, 'btnText' => '', 'message' => '', 'followerCount' => 0];
        try {
            $userId = auth()->user()->id;
            $followed_to = $request->followed_to;
            //get follower count
            $followerCount = Follower::where('followed_to', $followed_to)->count();
            $checkFollowedOrNot = Follower::where('followed_to', $followed_to)->where('followed_by', $userId)->first();
            if ($checkFollowedOrNot == null) {
                $followerAdded = Follower::create([
                            'followed_to' => $followed_to,
                            'followed_by' => $userId,
                ]);
                if ($followerAdded->id > 0) {
                    $followerCount = Follower::where('followed_to', $followed_to)->count();
                    $followerCount = Web::thousandsCurrencyFormat($followerCount);
                    $responseArray['success'] = true;
                    $responseArray['btnText'] = 'Unfollow';
                    $responseArray['followerCount'] = $followerCount;
                } else {
                    $followerCount = Follower::where('followed_to', $followed_to)->count();
                    $followerCount = Web::thousandsCurrencyFormat($followerCount);
                    $responseArray['success'] = false;
                    $responseArray['btnText'] = 'Follow';
                    $responseArray['followerCount'] = $followerCount;
                }
            } else {
                Follower::where('id', $checkFollowedOrNot->id)->delete();
                $followerCount = Follower::where('followed_to', $followed_to)->count();
                $followerCount = Web::thousandsCurrencyFormat($followerCount);
                $responseArray['success'] = true;
                $responseArray['btnText'] = 'Follow';
                $responseArray['followerCount'] = $followerCount;
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $responseArray['message'] = $message;
        }
        return response()->json($responseArray, 200);
    }

    public function notifyUpdate(Request $request){
        $responseArray = ['success' => false, 'message' => 'no data found'];
        if(isset($request->notify)){
            $notify = ($request->notify) == 1 ? 0 : 1;
            Follower::where('id',$request->id)->update(['notify'=>$notify]);
            $responseArray['data'] = $notify;
            $responseArray['success'] = true;
            $responseArray['message'] = 'Status Updated';
        }
        return response()->json($responseArray, 201);
    }
    /** + 
     * used to get followed seller details
     * @return type
     */
    public function accountDashPreferredSeller() {
        $data = [];
        $data['title'] = 'My Preferred Seller';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Account Dashboard';
        $data['breadcrumb1_link'] = route('account.dashboard');
        $data['breadcrumb2'] = 'My Preferred Seller';
        $data['breadcrumb3'] = false;

        $data['preferredSellers'] = Follower::with(['sellerDetails'])->where('followed_by', auth()->user()->id)->get();

        return view('account.account_dashboard_my_preferred_seller', compact('data'));
    }

}
