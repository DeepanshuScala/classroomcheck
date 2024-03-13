<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    Auth,
    Crypt,
    Mail,
    Redirect,
    Session
};
use App\Models\{
    User,
    VerifyUser,
    UserCard,
    GiftCards,
    CartItem,
    Cartgiftcard,
    PromoDetails,
    PromoUsed,
    hostsale,
    Product
};
use Exception;
use Validator;
use \App\Http\Helper\Web;

class GiftCouponController extends Controller {

    /** + 
     * used to show gift card page
     * @param Request $request - request type get
     * @return type
     */
    public function giftCard(Request $request, $id ='') {
        if ($request->isMethod('post')) {
            $giftCardArr = [
                'from_name' => $request->from_name,
                'recipient_user_id' => $request->recipient_user_id,
                'recipient_email' => $request->recipient_email,
                'gift_amount' => $request->amount,
                'message' => $request->message,
                'recipient_role' => $request->recipient_role,
            ];
            if($request->gift_card_edit_id){
                $giftid = Crypt::decrypt($request->gift_card_edit_id); 

                Cartgiftcard::where('id',$giftid)->update($giftCardArr);
            }
            else{

                $cartgiftcard = Cartgiftcard::create([
                    'from_name' => $request->from_name,
                    'recipient_user_id' => $request->recipient_user_id,
                    'recipient_email' => $request->recipient_email,
                    'gift_amount' => $request->amount,
                    'message' => $request->message,
                    'recipient_role' => $request->recipient_role,
                ]);

                $r = CartItem::create([
                    'user_id' => auth()->user()->id,
                    'product_id' => $cartgiftcard->id,
                    'type' => 'gift',
                    'quantity' => 1,
                ]);
            }
            //session()->put('giftCardData', $giftCardArr);
            return Redirect::to('/account-dashboard/my-cart');
        } else {
            
            //session()->forget('giftCardData');
            $data = [];
            if(!empty($id)){
                $gift_card_id = Crypt::decrypt($id);
                $check_card_exist = Cartgiftcard::where('id',$gift_card_id)->first();
                if(is_null($check_card_exist)){
                    return Redirect::to('/gift-card');
                }
                $data['from_name'] = $check_card_exist->from_name;
                $data['recipient_user_id'] = $check_card_exist->recipient_user_id;
                $data['recipient_email'] = $check_card_exist->recipient_email;
                $data['gift_amount'] = $check_card_exist->gift_amount;
                $data['message'] = $check_card_exist->message;
                $data['recipient_role'] = $check_card_exist->recipient_role;
                $data['gift_card_edit_id'] = $id;
             }
            $data['title'] = 'Gift Card';
            $data['home'] = 'Home';
            if (Auth::check()) {
                if (auth()->user()->role_id == 1) {
                    $data['breadcrumb1'] = 'Account Dashboard';
                    $data['breadcrumb1_link'] = route('account.dashboard');
                }
                if (auth()->user()->role_id == 2) {
                    $data['breadcrumb1'] = 'Store Dashboard';
                    $data['breadcrumb1_link'] = route('store.dashboard');
                }
                $data['breadcrumb2'] = 'Gift Card';
                $data['breadcrumb3'] = false;
            } else {
                $data['breadcrumb1'] = 'Gift Card';
                $data['breadcrumb2'] = false;
                $data['breadcrumb3'] = false;
            }
            return view('gift_card.gift_card', compact('data'));
        }
    }

    /** + 
     * used to show payment page for gift card
     * @param Request $request - request type get
     * @return type
     */
    public function giftCardPaymentPage(Request $request) {
        if (session()->has('giftCardData')) {
            $data = [];
            $data['title'] = 'Gift Card';
            $data['home'] = 'Home';
            $data['breadcrumb1'] = 'Gift Card';
            $data['breadcrumb2'] = false;
            $data['breadcrumb3'] = false;
            $data['giftCardData'] = Session::get('giftCardData');
            $cardRes = UserCard::where('user_id', auth()->user()->id)->where('is_deleted', 0)->get();
            $data['result'] = $cardRes;

            return view('gift_card.gift_card_payment', compact('data'));
        } else {
            session()->forget('giftCardData');
            return Redirect::to(route('gift.card'));
        }
    }

    /** + 
     * used to send gift card
     * @param Request $request - request type post
     */
    public function sendGiftCard(Request $request) {
        $responseArray = ['success' => false, 'message' => ''];
        $cardRes = UserCard::where('id', $request->card_id)->first();
        $giftCode = Web::getAlphaNumericNumber(10);
        if ($cardRes == null) {
            $responseArray['message'] = "Card not valid";
        } else {
            $response = $this->chargeGiftCardPayment($request, $cardRes);
            if ($response['success'] == 0) {
                $responseArray['message'] = $response['message'];
                $responseArray['success'] = false;
            } else {
                $giftCard = GiftCards::create([
                            'sender_user_id' => auth()->user()->id,
                            'from_name' => $request->from_name,
                            'recipient_user_id' => $request->recipient_user_id,
                            'recipient_email' => $request->recipient_email,
                            'gift_code' => $giftCode,
                            'gift_amount' => $request->amount,
                            'message' => $request->message,
                            'sender_card_id' => $request->card_id,
                            'remaining_amount' => $request->amount,
                            'txn_raw' => json_encode($response['result'])
                ]);
                if ($giftCard->id > 0) {
                    $emailData = [
                        "first_name" => $request->from_name,
                        "subject" => 'Gift Card',
                        "giftCode" => $giftCode,
                        "content" => '',
                        'toEmail' => $request->recipient_email
                            //'toEmail' => "kirtik@scalacoders.com"
                    ];
                    try {
                        $send_mail = Mail::send('emails/gift_card_mail', $emailData, function ($message)use ($emailData) {
                                    $message->to($emailData['toEmail']);
                                    $message->cc('admin@classroomcopy.com');
                                    $message->subject($emailData['subject']);
                                });
                        $responseArray['success'] = true;
                    } catch (Exception $e) {
                        $responseArray['success'] = false;
                        $responseArray['message'] = $e->getMessage();
                    }
                } else {
                    $responseArray['message'] = "Something went wrong";
                    $responseArray['success'] = false;
                }
            }
        }
        return response()->json($responseArray, 200);
    }

    /** +
     * used to charge gift card payment
     * @param type $request - request params
     * @param type $stripe_card_id - stripe card id
     * @return type
     */
    public function chargeGiftCardPayment($request, $cardRes) {
        $user_info = auth()->user();
        $postData = $request->all();
        $stripe = new \Stripe\StripeClient([
            "api_key" => env('STRIPE_SECRET_KEY'),
        ]);
        $returnResponse = array('success' => 0, 'message' => '', 'result' => '');
        $customer_id = $user_info->stripe_customer_id;
        try {
            $result = $stripe->charges->create([
                'amount' => (100 * $request->amount),
                'currency' => env('CURRENCY'),
                'customer' => $customer_id,
                'source' => $cardRes->stripe_card_id
            ]);
            if (!($result->id)) {
                $returnResponse['success'] = 0;
                $returnResponse['message'] = "There is an issue with payment. Please try after sometime";
            } else {
                $returnResponse['success'] = 1;
                $returnResponse['result'] = $result;
            }
        } catch (\Stripe\Exception\CardException $e) {
            $returnResponse['success'] = 0;
            $returnResponse['message'] = $e->getMessage();
        } catch (\Stripe\Exception\RateLimitException $e) {
            $returnResponse['success'] = 0;
            $returnResponse['message'] = $e->getMessage();
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $returnResponse['success'] = 0;
            $returnResponse['message'] = $e->getMessage();
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $returnResponse['success'] = 0;
            $returnResponse['message'] = $e->getMessage();
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $returnResponse['success'] = 0;
            $returnResponse['message'] = $e->getMessage();
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $returnResponse['success'] = 0;
            $returnResponse['message'] = $e->getMessage();
        } catch (\Exception $e) {
            $returnResponse['success'] = 0;
            $returnResponse['message'] = $e->getMessage();
        }
        return $returnResponse;
    }

    /** + 
     * used to check email exist or not
     * @param Request $request - request type post
     * @return type
     */
    public function checkEmailExistOrNot(Request $request) {
        $email = $request->email;
        $recipient_role = $request->recipient_role;
        $userInfo = User::where('email', $email)->where('email', '!=', auth()->user()->email)->first();
        $responseArray = ['success' => false, 'message' => '', 'recipient_user_id' => ''];
        if (auth()->user()->email == $email) {
            $responseArray['success'] = false;
        } else {
            $responseArray['success'] = true;
            $responseArray['recipient_user_id'] = !empty($userInfo)?$userInfo->id:0;
        }
        return response()->json($responseArray, 200);
    }

    /** + 
     * used to check gift card balance by gift code
     * @param Request $request - request type post
     * @return type
     */
    public function checkGiftCardBalanceByCode(Request $request) {
        $gift_code = $request->gift_code;
        $giftCardRes = GiftCards::where('gift_code', $gift_code)->where('recipient_email', auth()->user()->email)->first();
        $responseArray = ['success' => false, 'message' => '', 'balance' => ''];
        if ($giftCardRes == null) {
            $responseArray['success'] = false;
            $responseArray['message'] = "Invalid Gift Code";
        } else {
            $responseArray['success'] = true;
            $responseArray['balance'] = $giftCardRes->remaining_amount;
        }
        return response()->json($responseArray, 200);
    }

    /** + 
     * used to apply gift coupon to cart
     * @param Request $request - request type post
     * @return type
     */
    public function applyGiftCouponToCart(Request $request) {
        $gift_coupon = $request->gift_coupon;
        $userId = auth()->user()->id;
        $giftCardRes = GiftCards::where('gift_code', $gift_coupon)->first();
        $responseArray = ['success' => false, 'message' => '', 'cartAmt' => ''];
        if ($giftCardRes == null) {
            $responseArray['success'] = false;
            $responseArray['message'] = "Invalid Gift Coupon";
        } else {
            $totalCartPrice = User::with('cartsWithProductPrice')->find($userId);
            $cartPriceArr = $totalCartPrice->cartsWithProductPrice->pluck('price')->toArray();
            $totalAmount = 0;
            $giftamount = 0;
            // foreach ($cartPriceArr as $price) {
            //     $totalAmount += $price;
            // }
            
            $cartItems = CartItem::where('user_id', $userId)->with('product')->get();
            foreach($cartItems as $cartItem){
                if($cartItem->type == 'gift'){
                    $cr = Cartgiftcard::where('id', $cartItem->product_id)->first();
                    if(!empty($cr)){
                        $totalAmount += $cr->gift_amount;
                        $giftamount += $cr->gift_amount;
                    }
                }
                else{
                    $pr = Product::where('id',$cartItem->product_id)->first();
                    if(!empty($pr)){
                        
                        //check if sale is going for product
                        $responsearray = Web::getsingleprice($cartItem->product_id,$pr->user_id,$pr->single_license,0);
                        if($cartItem->quantity > 1){
                            $responsearray = Web::getsingleprice($cartItem->product_id,$pr->user_id,(!empty($pr->multiple_license))?$pr->multiple_license:$pr->single_license,0);
                        }
                        $price = $responsearray['price']*$cartItem->quantity;
                        
                        $totalAmount += $price;
                    }
                }
            }
           
            $cartAmount = ($totalAmount < $giftCardRes->remaining_amount) ? 0 : $totalAmount - $giftCardRes->remaining_amount;
            $buyer_tax = 0;
            if(auth()->user()->country == 'Australia'){
              $buyer_tax = ($cartAmount>0)?($cartAmount-$giftamount)*0.1:0.00;
            }
            $responseArray['success'] = true;
            $responseArray['buyer_tax'] = number_format($buyer_tax, 2);
            $responseArray['cartAmt'] = number_format($cartAmount, 2);
            /*
            if ($totalAmount == $giftCardRes->remaining_amount) {
                $responseArray['success'] = false;
                $responseArray['message'] = "Gift coupon does not apply to this amount";
            } else {
                $cartAmount = ($totalAmount < $giftCardRes->remaining_amount) ? 0 : $totalAmount - $giftCardRes->remaining_amount;
                $responseArray['success'] = true;
                $responseArray['cartAmt'] = number_format($cartAmount, 2);
            }
            */
        }
        return response()->json($responseArray, 200);
    }

    public function removegiftcard(Request $request){
        $responseArray = ['success' => true, 'message' => '', 'cartAmt' => ''];
        $userId = auth()->user()->id;
        //$totalCartPrice = User::with('cartsWithProductPrice')->find($userId);
        //$cartPriceArr = $totalCartPrice->cartsWithProductPrice->pluck('price')->toArray();
        $totalAmount = 0;
        $giftamount  = 0;
        // foreach ($cartPriceArr as $price) {
        //     $totalAmount += $price;
        // }
        
        $cartItems = CartItem::where('user_id', $userId)->with('product')->get();
        foreach($cartItems as $cartItem){
            if($cartItem->type == 'gift'){
                $cr = Cartgiftcard::where('id', $cartItem->product_id)->first();
                if(!empty($cr)){
                    $totalAmount += $cr->gift_amount;
                    $giftamount += $cr->gift_amount;
                }
            }
            else{
                $pr = Product::where('id',$cartItem->product_id)->first();
                if(!empty($pr)){
                    //check if sale is going for product
                    $responsearray = Web::getsingleprice($cartItem->product_id,$pr->user_id,$pr->single_license,0);
                    if($cartItem->quantity > 1){
                        $responsearray = Web::getsingleprice($cartItem->product_id,$pr->user_id,(!empty($pr->multiple_license))?$pr->multiple_license:$pr->single_license,0);
                    }
                    $price = $responsearray['price']*$cartItem->quantity;
                    $totalAmount += $price;
                }
            }
        }
        $buyer_tax = 0;
        if(auth()->user()->country == 'Australia'){
          $buyer_tax = ($totalAmount-$giftamount)*0.1;
        }
        $responseArray['buyer_tax'] = number_format($buyer_tax, 2);
        $responseArray['cartAmt'] = $totalAmount;
        return $responseArray;
    }
    public function applyPromotionalCouponToCart(Request $request){
        $promotional_coupon = $request->promotional_coupon;
        $userId = auth()->user()->id;
        $startDate = date('Y-m-d');
        $promotionalCardRes = PromoDetails::where('promo_code', $promotional_coupon)->whereDate('start_at','<=',$startDate)
        ->whereDate('end_at','>=',$startDate)->where('status',1)->first();
        $responseArray = ['success' => false, 'message' => '', 'cartAmt' => ''];

        if ($promotionalCardRes == null) {
            $responseArray['success'] = false;
            $responseArray['message'] = "Invalid Promotional Coupon";
        } else {
            $check_already_used = PromoUsed::where('user_id', $userId)->where('promocodeid',$promotionalCardRes->id)->first();
            if(!is_null($check_already_used)){
                $responseArray['success'] = false;
                $responseArray['message'] = "Promotional Coupon Already Used";
            }
            else{
                // $totalCartPrice = User::with('cartsWithProductPrice')->find($userId);
                // $cartPriceArr = $totalCartPrice->cartsWithProductPrice->pluck('price')->toArray();
                $totalAmount = 0;
                $giftamount  = 0;
                // foreach ($cartPriceArr as $price) {
                //     $totalAmount += $price;
                // }
                
                $cartItems = CartItem::where('user_id', $userId)->with('product')->get();
                foreach($cartItems as $cartItem){
                    if($cartItem->type == 'gift'){
                        $cr = Cartgiftcard::where('id', $cartItem->product_id)->first();
                        if(!empty($cr)){
                            $totalAmount += $cr->gift_amount;
                            $giftamount += $cr->gift_amount;
                        }
                    }
                    else{
                        $pr = Product::where('id',$cartItem->product_id)->first();
                        if(!empty($pr)){
                        //check if sale is going for product
                        $responsearray = Web::getsingleprice($cartItem->product_id,$pr->user_id,$pr->single_license,0);
                        if($cartItem->quantity > 1){
                            $p = (!empty($pr->multiple_license))?$pr->multiple_license:$pr->single_license;
                            $responsearray = Web::getsingleprice($cartItem->product_id,$pr->user_id,$p,0);
                        }
                        $price = $responsearray['price']*$cartItem->quantity;
                        $totalAmount += $price;
                        }
                    }
                }
                if($promotionalCardRes->discount_in == 1){

                    $cartAmount = ($totalAmount < $promotionalCardRes->amount) ? 0 : $totalAmount - $promotionalCardRes->amount; 
                    $buyer_tax = 0;
                    if(auth()->user()->country == 'Australia'){
                      $buyer_tax = ($cartAmount>0)?($cartAmount-$giftamount)*0.1:0.00;
                    }
                        $responseArray['success'] = true;
                        $responseArray['cartAmt'] = $cartAmount;
                        $responseArray['buyer_tax'] = number_format($buyer_tax, 2);
                    /*
                    if ($totalAmount == $promotionalCardRes->amount) {
                        $responseArray['success'] = false;
                        $responseArray['message'] = "Promotional coupon does not apply to this amount";
                    }
                    else{
                        $cartAmount = ($totalAmount < $promotionalCardRes->amount) ? $promotionalCardRes->amount - $totalAmount : $totalAmount - $promotionalCardRes->amount; 
                        $responseArray['success'] = true;
                        $responseArray['cartAmt'] = $cartAmount;
                    } 
                    */
                }
                else{
                    $cartAmount = $totalAmount - ($totalAmount * ($promotionalCardRes->amount/100));
                    $buyer_tax = 0;
                    if(auth()->user()->country == 'Australia'){
                      $buyer_tax = ($cartAmount>0)?($cartAmount-$giftamount)*0.1:0.00;
                    }
                    $responseArray['success'] = true;
                    $responseArray['cartAmt'] = number_format($cartAmount,2);
                    $responseArray['buyer_tax'] = number_format($buyer_tax, 2);
                }
            }
            
        }
        return response()->json($responseArray, 200);
    }

}
