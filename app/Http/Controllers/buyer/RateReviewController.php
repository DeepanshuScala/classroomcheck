<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    Redirect,
    DB,
    Session,
    Validator,
    Crypt
};
use \App\Models\{
    User,
    RateReviews
};

class RateReviewController extends Controller {

    /** + 
     * used to rate & review
     * @param Request $request - request type post
     * @return type
     */
    public function index(Request $request) {
        $responseArray = ['success' => false, 'message' => ''];
        try {
            $userId = auth()->user()->id;
            $type = (int) $request->type;
            $rating_id = $request->rating_id;
            if ($rating_id > 0) {
                RateReviews::where('id', $rating_id)->update([
                    'rating' => (int) $request->rating,
                    'review' => $request->review
                ]);
                $msg = ($type == 1) ? 'Product' : 'Seller';
                $responseArray['success'] = true;
                $responseArray['message'] = $msg . " rated successfully";
            } else {
                $reviewAdded = RateReviews::create([
                            'type' => $type,
                            'order_id' => ($type == 1) ? $request->order_id : 0,
                            'product_id' => ($type == 1) ? Crypt::decrypt($request->product_id) : 0,
                            'seller_id' => ($type == 2) ? $request->seller_id : 0,
                            'user_id' => $userId,
                            'rating' => (int) $request->rating,
                            'review' => $request->review
                ]);
                if ($reviewAdded->id > 0) {
                    $msg = ($type == 1) ? 'Product' : 'Seller';
                    $responseArray['success'] = true;
                    $responseArray['message'] = $msg . " rated successfully";
                } else {
                    $responseArray['success'] = false;
                    $responseArray['message'] = "Something went wrong, Please try again later!";
                }
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $responseArray['message'] = $message;
        }
        return response()->json($responseArray, 200);
    }

    /** + 
     * used to fetch review data
     * @param Request $request - request type post
     * @return type
     */
    public function getReviewData(Request $request) {
        $responseArray = ['success' => false, 'message' => '', 'result' => ''];
        try {
            $userId = auth()->user()->id;
            $type = (int) $request->type;
            $order_id = ($type == 1) ? $request->order_id : 0;
            $product_id = ($type == 1) ? Crypt::decrypt($request->product_id) : 0;
            $seller_id = ($type == 2) ? $request->seller_id : 0;
            switch ($type):
                case 1:
                    $result = RateReviews::where([['user_id', '=', auth()->user()->id], ['type', '=', $type], ['order_id', '=', $order_id], ['product_id', '=', $product_id]])->first();
                    $responseArray['result'] = $result;
                    break;
                case 2:
                    $result = RateReviews::where([['user_id', '=', auth()->user()->id], ['type', '=', $type], ['seller_id', '=', $seller_id]])->first();
                    $responseArray['result'] = $result;
                    break;
                default :
                    $result = null;
            endswitch;
            $responseArray['success'] = true;
            $responseArray['result'] = $result;
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $responseArray['message'] = $message;
        }
        return response()->json($responseArray, 200);
    }

}
