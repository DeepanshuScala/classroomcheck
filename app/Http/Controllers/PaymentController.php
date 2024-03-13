<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    Hash,
    Crypt,
    DB,
    Session,
    Redirect,
    Storage
};
use Exception;
use App\Models\{
    User,
    UserCard,
    Order,
    OrderItem,
    Transaction,
    CartItem,
    GiftCards,
    Cartgiftcard,
    PromoDetails,
    PromoUsed,
    hostsale,
    Product,
    Store
};
use Validator;
use Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\{
    StripeActionsService
};
use Carbon\Carbon;
use \App\Http\Helper\Web;

class PaymentController extends Controller {

    public $stripeActionService;

    public function __construct(StripeActionsService $stripeActionService) {
        $this->stripeActionService = $stripeActionService;
    }

    /** + 
     * used to show payment page
     * @param Request $request - request type any
     * @param type $id
     * @return type
     */
    public function checkoutPage(Request $request, $id) {
        $data = [];
        if($request->isMethod('post')){
            if($request->checkout_price == 0 && url()->previous() == route('accountDashboard.myCart') ){
              $gift_coupon = $request->gift_code;

              if ($gift_coupon != '') {

                  $giftCardRes = GiftCards::where('gift_code', $gift_coupon)->first();
                  if ($giftCardRes == null) {
                      return redirect()->route('accountDashboard.myCart')->with('error', "Gift coupon not valid");
                  }
              }

              $promotional_coupon = $request->promotional_code;

              if ($promotional_coupon != '') {

                  $promotionalRes = PromoDetails::where('promo_code', $promotional_coupon)->where('status',1)->first();
                  if ($promotionalRes == null) {
                      return redirect()->route('accountDashboard.myCart')->with('error', "Promotional coupon not valid");
                  }
              }

              $userId = auth()->user()->id;

              $cartItems = CartItem::where('user_id', $userId)->with('product')->get();
              $totalCartItem = 0;
                if($cartItems->isNotEmpty()){
                    foreach($cartItems as $itms){
                        $totalCartItem += $itms->quantity;
                    }
                } 

              //$totalCartPrice = User::with('cartsWithProductPrice')->find($userId);
              //$cartPriceArr = $totalCartPrice->cartsWithProductPrice->pluck('price')->toArray();
              $totalAmount = 0;
              // foreach ($cartPriceArr as $price) {
              //     $totalAmount += $price;
              // }
              foreach($cartItems as $cartItem){
                  if($cartItem->type == 'gift'){
                      $cr = Cartgiftcard::where('id', $cartItem->product_id)->first();
                      if(!empty($cr)){
                          $totalAmount += $cr->gift_amount;
                      }
                  }
                  else{
                      $pr = Product::where('id',$cartItem->product_id)->first();
                      if(!empty($pr)){
                          
                          //check if sale is going for product
                          $responsearray = Web::getsingleprice($pr->id,$pr->user_id,$pr->single_license,0);
                          if($cartItem->quantity > 1){
                            $responsearray = Web::getsingleprice($pr->id,$pr->user_id,(!empty($pr->multiple_license))?$pr->multiple_license:$pr->single_license,0);
                          }
                          
                          $price = $responsearray['price'] * $cartItem->quantity;

                          $totalAmount += $price;
                      }
                  }
              }
              $discount = 0;
              $coupon = '';
              $coupon_type = 0;
              if ($gift_coupon != '') {
                  $price = ($totalAmount < $giftCardRes->remaining_amount) ? 0 : $totalAmount - $giftCardRes->remaining_amount;
                  $discount = $totalAmount - $price;
                  $coupon = $gift_coupon;
                  $coupon_type = 1;
              }elseif($promotional_coupon != ''){
                  if($promotionalRes->discount_in == 1){
                    $price = ($totalAmount < $promotionalRes->amount) ? 0 : $totalAmount - $promotionalRes->amount;
                    $discount = $totalAmount - $price;
                  }
                  else{
                    $price = (int)$totalAmount * ((int)$promotionalRes->amount/100) ;
                    $discount = $totalAmount - $price;
                  }
                  
                  $coupon = $promotional_coupon;
                  $coupon_type = 2;
              }else {
                  $price = $totalAmount;
              }
              $paidUser = User::where('id', $userId)->first();
              $orderNumberCreate = 'CC' . time() . rand(10, 100);
              $orderData = [
                  'order_number' => $orderNumberCreate,
                  'user_id' => $userId,
                  'total_amount' => $totalAmount,
                  'total_quantity' => $totalCartItem,
                  'coupon_code' => $coupon,
                  'coupon_type' => $coupon_type,
                  'coupon_discount_amount' => $discount,
                  'status' => 1, //0=>"Pending", 1=>"In-progress", 2=>"Delivered",3=>"Cancelled"
                  'remark' => '',
                  'payment_type' => 'Card',
              ];
              $orderCreate = Order::create($orderData);
              $foremailproduct = [];
              $i = 0;
              $sales_tax_collected = 0;
              $sales_commission_collected = 0;
              $transaction_charge_collected = 0;
              $selleremail = [];
              foreach ($cartItems as $cartItem) {
                $purchasedin = 1;
                  if($cartItem->type == 'product'){
                    //$price = $cartItem->product->single_license;
                    $product_id = $cartItem->product->id;

                    //check if sale is going for product
                    $responsearray = Web::getsingleprice($cartItem->product->id,$cartItem->product->user_id,$cartItem->product->single_license,0);
                    if($cartItem->quantity > 1){
                        $responsearray = Web::getsingleprice($cartItem->product->id,$cartItem->product->user_id,(!empty($cartItem->product->multiple_license))?$cartItem->product->multiple_license:$cartItem->product->single_license,0);
                    }
                    
                    $price = $responsearray['price'];
                    $purchasedin = $responsearray['purchasedin'];
                    $productinfo = Product::where('id',$cartItem->product_id)->first();
                    $sellerinfo = User::where('id',$productinfo->user_id)->first();
                    $storeinfo = Store::where('user_id',$productinfo->user_id)->first();
                    $alldats = [
                      "productname" => $productinfo->product_title,
                      "productid" => $productinfo->product,
                      "productimage" => Storage::disk('s3')->url('products/'.$productinfo->main_image),
                      "subject" => "CONGRATULATIONS!",
                      "totalprice" => number_format((float) ($price * $cartItem->quantity), 2, '.', ''),
                      "email" => $sellerinfo->email,
                    ];
                    $selleremail[$alldats['email']][] = $alldats;
                    // Mail::send('emails/purchase_seller_info', $alldats, function ($message)use ($alldats) {
                    //     $message->to($alldats['email']);
                    //     $message->cc('admin@classroomcopy.com');
                    //     $message->subject($alldats['subject']);
                    // });
                  }
                  elseif( $cartItem->type == 'gift' ){
                    $crt = Cartgiftcard::where('id', $cartItem->product_id)->first();
                    $price = $crt->gift_amount;
                    $product_id = $cartItem->product_id;
                    $giftCode = Web::getAlphaNumericNumber(10);

                    $giftCard = GiftCards::create([
                                'sender_user_id' => auth()->user()->id,
                                'from_name' => $crt->from_name,
                                'recipient_user_id' => $crt->recipient_user_id,
                                'recipient_email' => $crt->recipient_email,
                                'gift_code' => $giftCode,
                                'gift_amount' => $crt->gift_amount,
                                'message' => $crt->message,
                                'sender_card_id' => $userId,
                                'remaining_amount' => $crt->gift_amount,
                                'txn_raw' => '',
                    ]);
                    
                    if ($giftCard->id > 0) {
                        $emailData = [
                            "first_name" => $crt->from_name,
                            "subject" => 'Gift Card',
                            "giftCode" => $giftCode,
                            'amount'   => $crt->gift_amount,
                            'sendername' =>$crt->from_name,
                            "content" => $crt->message,
                            'toEmail' => $crt->recipient_email
                                //'toEmail' => "kirtik@scalacoders.com"
                        ];
                        try {
                            $send_mail = Mail::send('emails/gift_card_mail', $emailData, function ($message)use ($emailData) {
                                        $message->to($emailData['toEmail']);
                                        $message->cc('admin@classroomcopy.com');
                                        $message->subject($emailData['subject']);
                                    });
                        } catch (Exception $e) {
                            $responseArray['success'] = false;
                            $responseArray['message'] = $e->getMessage();
                        }
                    }
                  }  
                
                  $orderItemsData = [
                      'order_id' => $orderCreate->id,
                      'user_id' => $userId,
                      'product_id' => $product_id,
                      'quantity' => $cartItem->quantity,
                      'downloads_left' => $cartItem->quantity,
                      'price' => $price,
                      'amount' => number_format((float) ($price * $cartItem->quantity), 2, '.', ''),
                      'payment_type' => 'Card',
                      'status' => 1,
                      'type'=> $cartItem->type,
                      'purchasedon'=>$purchasedin,
                  ];
                  $createOrderItems = OrderItem::create($orderItemsData);

                    $foremailproduct[$i]['id'] = ($cartItem->type == 'product')?$cartItem->product->id:'Gift Card';
                    $foremailproduct[$i]['seller'] = ($cartItem->type == 'product')?$storeinfo->store_name:'Gift Card';
                    $foremailproduct[$i]['name'] = ($cartItem->type == 'product')?$cartItem->product->product_title:'Gift Card';
                    $foremailproduct[$i]['price'] = number_format((float) ($price), 2, '.', '');
                    $foremailproduct[$i]['quantity'] = $cartItem->quantity;
                    $foremailproduct[$i]['amount'] = number_format((float) ($price * $cartItem->quantity), 2, '.', '');
                    $foremailproduct[$i]['image'] =($cartItem->type == 'product')?Storage::disk('s3')->url('products/'.$cartItem->product->main_image):url('/images/GIft-Card.jpg');

                    if($cartItem->type == 'product'){
                        //Tax Calculation
                        $transaction_charge = (!empty($paidUser) && $paidUser->country != 'Australia') ?(!empty($storeinfo->transactioncharge_other)?$storeinfo->transactioncharge_other:env('TRANSACTION_CHARGE_OTHER')):(!empty($storeinfo->transactioncharge_aus)?$storeinfo->transactioncharge_aus:env('TRANSACTION_CHARGE_AUS'));
                        $salescommission = !empty($storeinfo->sale_commission)?$storeinfo->sale_commission:env('SALE_COMMISION');
                        $salescommission = (new \App\Http\Helper\Web)->checkifsellerundermembership($paidUser->id,date("Y-m-d h:i:s"),$salescommission);
                        $salestax = !empty($storeinfo->salestax)?$storeinfo->salestax:env('SALE_TAX');
                        
                        $sales_commission_collected += $foremailproduct[$i]['amount'] *$salescommission;
                        $transaction_charge_collected += $foremailproduct[$i]['amount'] *$transaction_charge;
                        $sales_tax_collected += $foremailproduct[$i]['amount'] *$salestax;
                        //Tax Calculation

                        //Update tax over the order
                        OrderItem::where('id',$createOrderItems->id)->update([
                          'commission'=>$foremailproduct[$i]['amount'] *$salescommission,
                          'transaction_charges'=>$foremailproduct[$i]['amount'] *$transaction_charge,
                          'sales_tax'=>$foremailproduct[$i]['amount'] *$salestax,
                        ]);
                    }

                    $i++;
              }
              foreach($selleremail as $k => $sml){
                $loop = [];
                $loop['product'] = $sml;
                Mail::send('emails/purchase_seller_info', $loop, function ($message)use ($loop,$k) {
                  $message->to($k);
                  $message->cc('admin@classroomcopy.com');
                  $message->subject('CONGRATULATIONS!');
                });
              }
                $subject = "THANK YOU FOR YOUR PURCHASE";
                $alldats = [
                    "payee_name" => $paidUser->first_name.' '.$paidUser->surname,
                    "paid_email" => $paidUser->email,
                    "subject" => $subject,
                    "products" => $foremailproduct,
                    "buyeraddress" => $paidUser->address_line1.' '.$paidUser->address_line2.' '.$paidUser->city.' '.$paidUser->state_province_region.' '.$paidUser->postal_code.' '.$paidUser->country,
                    "buyerpaymethod" =>'Credit Card',
                    "coupon_type" => $coupon_type,
                    "couponcode" => $coupon,
                    "discount" => number_format((float) ($discount), 2, '.', ''),
                    "subtotal" =>'',
                    "sales_tax_collected" => number_format((float) ($sales_tax_collected), 2, '.', ''),
                    "sales_commission_collected" => number_format((float) ($sales_commission_collected), 2, '.', ''),
                    "transaction_charge_collected" =>number_format((float) ($transaction_charge_collected), 2, '.', ''),
                    "total" => number_format((float) ($totalAmount), 2, '.', ''),
                    "paid" =>number_format((float) ($totalAmount - $discount), 2, '.', ''),
                    "orderid" =>$orderNumberCreate,
                    'date'=>date('d/m/Y'),
                ];
                //generate invoice
                $pdf = Pdf::loadView('orderinvoice',$alldats);
                $fileName = $orderNumberCreate.'.pdf'; // Choose a desired file name
                $path = 'orderinvoice';

                // Store the PDF in the storage (e.g., S3) and get the file URL
                $pdfUrl = Storage::disk('s3')->put($path . '/' . $fileName, $pdf->output());
                //generate invoice
                $alldats['invoiceurl'] = Storage::disk('s3')->url('orderinvoice/' . $orderNumberCreate.'.pdf');
                Mail::send('emails/cart_checkout_payment', $alldats, function ($message)use ($alldats) {
                  $message->to($alldats['paid_email']);
                  $message->cc('admin@classroomcopy.com');
                  $message->subject($alldats['subject']);
              });
              if ($gift_coupon != '') {
                  //update gift coupon amount
                  
                  $remainingAmt = ($totalAmount < $giftCardRes->remaining_amount) ? $giftCardRes->remaining_amount - $totalAmount : 0;

                  GiftCards::where('id', $giftCardRes->id)->update(['remaining_amount' => $remainingAmt]);
              }
              if($promotional_coupon != ''){
                PromoUsed::create([
                            'user_id' => auth()->user()->id,
                            'promocodeid' => $promotionalRes->id,
                ]);
              }
              DB::commit();
              CartItem::where('user_id', $userId)->delete();
              $this->generate_orderinvoice('de');
              return redirect()->route('accountDashboard.myPurchaseHistory')->with('paysuccess',$orderNumberCreate);
            }
            else{
              $data['checkout_price'] = $request->checkout_price;
              $data['quantity'] = $request->quantity;
              $data['gift_code'] = $request->gift_code;
              $data['promotional_code'] = $request->promotional_code;
              $data['form_url'] = '/checkout/payment';
              $data['title'] = 'Payment';
              $data['home'] = 'Home';
              $data['breadcrumb1'] = 'My Cart';
              $data['breadcrumb1_link'] = route('accountDashboard.myCart');
              $data['breadcrumb2'] = "Payment";
              $data['breadcrumb3'] = false;
              $cardRes = UserCard::where('user_id', auth()->user()->id)->where('is_deleted', 0)->get();
              $data['cards'] = $cardRes;
              return view('payment.payment_form', ['data' => $data]);
            }
        }
        else{
            return redirect()->route('accountDashboard.myCart');
        }
    }

    public function cartPayment(Request $request) {
        $validation = Validator::make($request->all(), [
                    //'card_holder_name' => 'required',
                    //'card_number' => 'required|numeric|digits_between:13,16',
                    //'exp_month' => 'required|numeric|digits_between:2,2',
                    //'exp_year' => 'required|numeric|digits_between:4,4',
                    //'cvv' => 'required|numeric'
        ]);
        if ($validation->fails()) {
            Session::flash('error', $validator->errors()->first());
            return Redirect::back();
        }
        $cardRes = UserCard::where('user_id', auth()->user()->id)->where('id', $request->card_id)->where('is_deleted', 0)->first();
        if ($cardRes == null) {
            return Redirect::back()->with('error', "Card not valid");
        }
        $gift_coupon = $request->gift_code;

        if ($gift_coupon != '') {

            $giftCardRes = GiftCards::where('gift_code', $gift_coupon)->first();
            if ($giftCardRes == null) {
                return redirect()->route('accountDashboard.myCart')->with('error', "Gift coupon not valid");
            }
        }

        $promotional_coupon = $request->promotional_code;

        if ($promotional_coupon != '') {

            $promotionalRes = PromoDetails::where('promo_code', $promotional_coupon)->where('status',1)->first();
            if ($promotionalRes == null) {
                return redirect()->route('accountDashboard.myCart')->with('error', "Promotional coupon not valid");
            }
        }
        /* $card_number = $request->card_number;
          $save_for_future = (int) $request->save_for_future;
          $card_exp_month = $request->exp_month;
          $card_exp_year = $request->exp_year; */
        $card_cvc = $request->cvv;
        $userId = auth()->user()->id;

        $cartItems = CartItem::where('user_id', $userId)->with('product')->get();
        $totalCartItem = 0;
        if($cartItems->isNotEmpty()){
            foreach($cartItems as $itms){
                $totalCartItem += $itms->quantity;
            }
        } 

        //$totalCartPrice = User::with('cartsWithProductPrice')->find($userId);
        //$cartPriceArr = $totalCartPrice->cartsWithProductPrice->pluck('price')->toArray();
        $totalAmount = 0;
        $giftAmount = 0;
        // foreach ($cartPriceArr as $price) {
        //     $totalAmount += $price;
        // }
        foreach($cartItems as $cartItem){
            if($cartItem->type == 'gift'){
                $cr = Cartgiftcard::where('id', $cartItem->product_id)->first();
                if(!empty($cr)){
                    $totalAmount += $cr->gift_amount;
                    $giftAmount += $cr->gift_amount;
                }
            }
            else{
                $pr = Product::where('id',$cartItem->product_id)->first();
                if(!empty($pr)){
                    //check if sale is going for product
                    $responsearray = Web::getsingleprice($pr->id,$pr->user_id,$pr->single_license,0);
                    if($cartItem->quantity > 1){
                        $p = (!empty($pr->multiple_license))?$pr->multiple_license:$pr->single_license;
                        $responsearray = Web::getsingleprice($pr->id,$pr->user_id,$p,0);
                    }
                    $price = $responsearray['price'] * $cartItem->quantity;
                    $totalAmount += $price;
                }
            }
        }
        $discount = 0;
        $coupon = '';
        $coupon_type = 0;
        if ($gift_coupon != '') {
            $price = ($totalAmount < $giftCardRes->remaining_amount) ? 0 : $totalAmount - $giftCardRes->remaining_amount;
            $discount = $totalAmount - $price;
            $coupon = $gift_coupon;
            $coupon_type = 1;
        }elseif($promotional_coupon != ''){
            if($promotionalRes->discount_in == 1){
              $price = ($totalAmount < $promotionalRes->amount) ? 0 : $totalAmount - $promotionalRes->amount;
              $discount = $totalAmount - $price;
            }
            else{
              $price = (int)$totalAmount - ((int)$totalAmount * ((int)$promotionalRes->amount/100));
              $discount = $totalAmount - $price;
            }
            
            $coupon = $promotional_coupon;
            $coupon_type = 2;
        }else {
            $price = $totalAmount;
        }
        $user_info = auth()->user();

        //Buyer Tax 
        $buyer_tax = 0;
        if($user_info->country == 'Australia'){
          $buyer_tax = (int)($price-$giftAmount)*0.1;
        }

        $price = number_format((float) $price, 2, '.', '');
        $stripe = new \Stripe\StripeClient([
            "api_key" => env('STRIPE_SECRET_KEY'),
        ]);

        $customer_id = $user_info->stripe_customer_id;
        try {
            $orderNumberCreate = 'CC' . time() . rand(10, 100);
            $charge = $stripe->charges->create([
                'amount' => (100 * ($price+$buyer_tax)),
                'currency' => env('CURRENCY'),
                'customer' => $customer_id,
                'source' => $cardRes->stripe_card_id,
                'description'=>$orderNumberCreate,
                // 'metadata' => ['tax'=>2],
            ]);
            if (!($charge->id)) {
                return Redirect::back()->with('error', "There is an issue with payment. Please try after sometime");
            } else {
                DB::beginTransaction();
                try {
                    $paidUser = User::where('id', $userId)->first();
                    //Saving all information data into database:
                    //Create order:
                    $orderData = [
                        'order_number' => $orderNumberCreate,
                        'user_id' => $userId,
                        'total_amount' => $totalAmount,
                        'total_quantity' => $totalCartItem,
                        'coupon_code' => $coupon,
                        'coupon_type' => $coupon_type,
                        'coupon_discount_amount' => $discount,
                        'buyer_tax' => $buyer_tax,
                        'status' => 0, //0=>"Pending", 1=>"In-progress", 2=>"Delivered",3=>"Cancelled"
                        'remark' => '',
                        'payment_type' => 'Card',
                    ];
                    $orderCreate = Order::create($orderData);
                    //Transaction Create:
                    $txnData = [
                        'user_id' => $userId,
                        'order_id' => $orderCreate->id,
                        'txn_ref' => $charge->id,
                        'balance_transaction' => $charge->balance_transaction,
                        'txn_raw' => json_encode($charge),
                        'amount' => $price,
                        'status' => $charge->status == 'succeeded' ? 'success' : 'failed',
                        'card_id' => $cardRes->id,
                        'created_at' => now(),
                        'payment_type' => 'Card',
                    ];

                    $trnxCreate = Transaction::create($txnData);
                    $foremailproduct = [];
                    $i = 0;
                    $sales_tax_collected = 0;
                    $sales_commission_collected = 0;
                    $transaction_charge_collected = 0;
                    $selleremail = [];
                    foreach ($cartItems as $cartItem) {
                        $purchasedin = 1;
                        if($cartItem->type == 'product'){
                          $price = $cartItem->product->single_license;
                          $product_id = $cartItem->product->id;

                          //check if sale is going for product
                          $responsearray = Web::getsingleprice($product_id,$cartItem->product->user_id,$price,0);
                          if($cartItem->quantity > 1){
                            $p = (!empty($cartItem->product->multiple_license))?$cartItem->product->multiple_license:$cartItem->product->single_license;
                            $responsearray = Web::getsingleprice($product_id,$cartItem->product->user_id,$p,0);
                          }
                          
                          $price = $responsearray['price'];
                          $purchasedin = $responsearray['purchasedin'];
                          $productinfo = Product::where('id',$product_id)->first();
                          $sellerinfo = User::where('id',$productinfo->user_id)->first();
                          $storeinfo = Store::where('user_id',$productinfo->user_id)->first();
                          $alldats = [
                            "productname" => $productinfo->product_title,
                            "productid" => $productinfo->id,
                            "productimage" => Storage::disk('s3')->url('products/'.$productinfo->main_image),
                            "subject" => "CONGRATULATIONS!",
                            "totalprice" => number_format((float) ($price * $cartItem->quantity), 2, '.', ''),
                            "email" => $sellerinfo->email,
                          ];

                          $selleremail[$alldats['email']][] = $alldats;
                          // Mail::send('emails/purchase_seller_info', $alldats, function ($message)use ($alldats) {
                          //   $message->to($alldats['email']);
                          //   $message->cc('admin@classroomcopy.com');
                          //   $message->subject($alldats['subject']);
                          // });
                        }
                        elseif( $cartItem->type == 'gift' ){
                          $crt = Cartgiftcard::where('id', $cartItem->product_id)->first();
                          $price = $crt->gift_amount;
                          $product_id = $cartItem->product_id;
                          $giftCode = Web::getAlphaNumericNumber(10);

                          $giftCard = GiftCards::create([
                                      'sender_user_id' => auth()->user()->id,
                                      'from_name' => $crt->from_name,
                                      'recipient_user_id' => $crt->recipient_user_id,
                                      'recipient_email' => $crt->recipient_email,
                                      'gift_code' => $giftCode,
                                      'gift_amount' => $crt->gift_amount,
                                      'message' => $crt->message,
                                      'sender_card_id' => $cardRes->id,
                                      'remaining_amount' => $crt->gift_amount,
                                      'txn_raw' => $trnxCreate->txn_raw
                          ]);
                          
                          if ($giftCard->id > 0) {
                              $emailData = [
                                  "first_name" => $crt->from_name,
                                  "subject" => 'Gift Card',
                                  "giftCode" => $giftCode,
                                  'amount'   => $crt->gift_amount,
                                  'sendername' => auth()->user()->first_name.' '.auth()->user()->surname,
                                  "content" => $crt->message,
                                  'toEmail' => $crt->recipient_email
                                      //'toEmail' => "kirtik@scalacoders.com"
                              ];
                              try {
                                  $send_mail = Mail::send('emails/gift_card_mail', $emailData, function ($message)use ($emailData) {
                                              $message->to($emailData['toEmail']);
                                              $message->cc('admin@classroomcopy.com');
                                              $message->subject($emailData['subject']);
                                          });
                              } catch (Exception $e) {
                                  $responseArray['success'] = false;
                                  $responseArray['message'] = $e->getMessage();
                              }
                          }
                        }
                       
                        $orderItemsData = [
                            'order_id' => $orderCreate->id,
                            'user_id' => $userId,
                            'product_id' => $product_id,
                            'quantity' => $cartItem->quantity,
                            'downloads_left' => $cartItem->quantity,
                            'price' => $price,
                            'amount' => number_format((float) ($price * $cartItem->quantity), 2, '.', ''),
                            'payment_type' => 'Card',
                            'status' => 0,
                            'type'=> $cartItem->type,
                            'purchasedon'=>$purchasedin,

                        ];
                        $createOrderItems = OrderItem::create($orderItemsData);
                        
                        $foremailproduct[$i]['id'] = ($cartItem->type == 'product')?$cartItem->product->id:'Gift Card';
                        $foremailproduct[$i]['seller'] = ($cartItem->type == 'product')?$storeinfo->store_name:'Gift Card';
                        $foremailproduct[$i]['name'] = ($cartItem->type == 'product')?$cartItem->product->product_title:'Gift Card';
                        $foremailproduct[$i]['price'] = number_format((float) ($price), 2, '.', '');
                        $foremailproduct[$i]['quantity'] = $cartItem->quantity;
                        $foremailproduct[$i]['amount'] = number_format((float) ($price * $cartItem->quantity), 2, '.', '');
                        $foremailproduct[$i]['image'] =($cartItem->type == 'product')?Storage::disk('s3')->url('products/'.$cartItem->product->main_image):url('/images/GIft-Card.jpg');
                        
                        if($cartItem->type == 'product'){
                            //Tax Calculation
                            $transaction_charge = (!empty($paidUser) && $paidUser->country != 'Australia') ?(!empty($storeinfo->transactioncharge_other)?$storeinfo->transactioncharge_other:env('TRANSACTION_CHARGE_OTHER')):(!empty($storeinfo->transactioncharge_aus)?$storeinfo->transactioncharge_aus:env('TRANSACTION_CHARGE_AUS'));
                            $salescommission = !empty($storeinfo->sale_commission)?$storeinfo->sale_commission:env('SALE_COMMISION');
                            $salescommission = (new \App\Http\Helper\Web)->checkifsellerundermembership($paidUser->id,date("Y-m-d h:i:s"),$salescommission);
                            $salestax = !empty($storeinfo->salestax)?$storeinfo->salestax:env('SALE_TAX');
                            
                            $sales_commission_collected += $foremailproduct[$i]['amount'] *$salescommission;
                            $transaction_charge_collected += $foremailproduct[$i]['amount'] *$transaction_charge;
                            $sales_tax_collected += $foremailproduct[$i]['amount'] *$salestax;
                            //Tax Calculation

                            //Update tax over the order
                            OrderItem::where('id',$createOrderItems->id)->update([
                              'commission'=>$foremailproduct[$i]['amount'] *$salescommission,
                              'transaction_charges'=>$foremailproduct[$i]['amount'] *$transaction_charge,
                              'sales_tax'=>$foremailproduct[$i]['amount'] *$salestax,
                            ]);
                        }
                        $i++;
                    }

                    //Seller Email 
                    foreach($selleremail as $k => $sml){
                      $loop = [];
                      $loop['product'] = $sml;
                      Mail::send('emails/purchase_seller_info', $loop, function ($message)use ($loop,$k) {
                        $message->to($k);
                        $message->cc('admin@classroomcopy.com');
                        $message->subject('CONGRATULATIONS!');
                      });
                    }

                    if ($trnxCreate->status == 'success') {
                        $orderCreate = Order::where('id', $trnxCreate->order_id)->update(['status' => 1]);
                        $createOrderItems = OrderItem::where('order_id', $trnxCreate->order_id)->update(['status' => 1]);
                        //                $sellerHistory      =   SellerHistory::where('order_id', $trnxCreate->order_id)->update(['status' => 'Delivered']);
                    } else {
                        throw new Exception("Something went wrong");
                    }


                    //Send email:
                    $subject = "THANK YOU FOR YOUR PURCHASE";
                    $alldats = [
                        "payee_name" => $paidUser->first_name.' '.$paidUser->surname,
                        "paid_email" => $paidUser->email,
                        "subject" => $subject,
                        "products" => $foremailproduct,
                        "buyeraddress" => $paidUser->address_line1.' '.$paidUser->address_line2.' '.$paidUser->city.' '.$paidUser->state_province_region.' '.$paidUser->postal_code.' '.$paidUser->country,
                        "buyerpaymethod" =>'Credit Card',
                        "couponcode" => $coupon,
                        "coupon_type" => $coupon_type,
                        "discount" => number_format((float) ($discount), 2, '.', ''),
                        "subtotal" =>'',
                        "sales_tax_collected" => number_format((float) ($sales_tax_collected), 2, '.', ''),
                        "sales_commission_collected" => number_format((float) ($sales_commission_collected), 2, '.', ''),
                        "transaction_charge_collected" =>number_format((float) ($transaction_charge_collected), 2, '.', ''),
                        "total" => number_format((float) ($totalAmount), 2, '.', ''),
                        "paid" =>number_format((float) ($totalAmount - $discount), 2, '.', ''),
                        "orderid" =>$orderNumberCreate,
                        'date'=>date('d/m/Y'),
                        'buyer_tax'=>number_format((float) ($buyer_tax), 2, '.', ''),
                    ];
                    //Add meta data to stripe
                    $stripe->charges->update(
                      $charge->id,
                      ['metadata' => [
                          'Buyer Tax' => '$'.number_format((float) ($buyer_tax), 2, '.', ''),
                        ]
                      ]
                    );

                    //generate invoice
                    $pdf = Pdf::loadView('orderinvoice',$alldats);
                    $fileName = $orderNumberCreate.'.pdf'; // Choose a desired file name
                    $path = 'orderinvoice';

                    // Store the PDF in the storage (e.g., S3) and get the file URL
                    $pdfUrl = Storage::disk('s3')->put($path . '/' . $fileName, $pdf->output());
                    //generate invoice

                    $alldats['invoiceurl'] = Storage::disk('s3')->url('orderinvoice/' . $orderNumberCreate.'.pdf');
          
                    try{
                        Mail::send('emails/cart_checkout_payment', $alldats, function ($message)use ($alldats) {
                            $message->to($alldats['paid_email']);
                            $message->cc('admin@classroomcopy.com');
                            $message->subject($alldats['subject']);
                        });
                    }catch(Exception $e){
                        DB::rollBack();
                        return redirect()->route('accountDashboard.myCart')->with('error', $e->getMessage());
                    }
                   
                    // ==================================================================== //
                    $payment_status = true;
                    if ($payment_status) {
                       
                        if ($gift_coupon != '') {
                            //update gift coupon amount
                            
                            $remainingAmt = ($totalAmount < $giftCardRes->remaining_amount) ? $giftCardRes->remaining_amount - $totalAmount : 0;

                            GiftCards::where('id', $giftCardRes->id)->update(['remaining_amount' => $remainingAmt]);
                        }
                        if($promotional_coupon != ''){
                          PromoUsed::create([
                                      'user_id' => auth()->user()->id,
                                      'promocodeid' => $promotionalRes->id,
                          ]);
                        }
                        DB::commit();
                        CartItem::where('user_id', $userId)->delete();
                        return redirect()->route('accountDashboard.myPurchaseHistory')->with('paysuccess',$orderNumberCreate);
                    } else {
                        return redirect()->route('accountDashboard.myCart')->with('error', 'Something went wrong!. But payment successfully done!');
                    }
                } catch (Exception $ex) {
                    DB::rollBack();
                    return redirect()->route('accountDashboard.myCart')->with('error', 'Something went wrong');
                }
            }  
        } catch (\Stripe\Exception\CardException $e) {
            return Redirect::back()->with('error', $e->getMessage());
        } catch (\Stripe\Exception\RateLimitException $e) {
            return Redirect::back()->with('error', $e->getMessage());
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            return Redirect::back()->with('error', $e->getMessage());
        } catch (\Stripe\Exception\AuthenticationException $e) {
            return Redirect::back()->with('error', $e->getMessage());
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            return Redirect::back()->with('error', $e->getMessage());
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return Redirect::back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return Redirect::back()->with('error', $e->getMessage());
        }

        /* try {
          // ===================== create token for stripe ====================== //
          $resultData = $this->stripeActionService->createStripeCardToken(
          $card_number, $card_exp_month, $card_exp_year, $card_cvc
          );
          // ==================================================================== //
          if (isset($resultData['error'])) {
          return Redirect::back()->with('error', $resultData['error']['code']);
          } else {
          $stripeToken = $resultData['id'];
          }
          try {
          //Create customer:
          $customer = $this->stripeActionService->createCustomerId($stripeToken, auth()->user()->email);
          try {
          //Charge Payment:
          $charge = $this->stripeActionService->chargePayment($price, env('CURRENCY'), $customer->id);

          if (!($charge->id)) {
          return redirect()->back()->with('error', 'Something went wrong with your payment');
          }
          //        dd($charge);
          DB::beginTransaction();
          try {
          $paidUser = User::where('id', $userId)->first();

          //Saving all information data into database:
          //Create order:
          $orderNumberCreate = 'order-' . time() . rand(1, 100) . '-' . $this->generateRandomString($length = 25);
          $orderData = [
          'order_number' => $orderNumberCreate,
          'user_id' => $userId,
          'total_amount' => $price,
          'total_quantity' => $totalCartItem,
          'coupon_code' => '',
          'coupon_discount_amount' => '',
          'status' => 0, //0=>"Pending", 1=>"In-progress", 2=>"Delivered",3=>"Cancelled"
          'remark' => '',
          'payment_type' => 'Card',
          ];
          $orderCreate = Order::create($orderData);
          //Transaction Create:
          $txnData = [
          'user_id' => $userId,
          'order_id' => $orderCreate->id,
          'txn_ref' => $charge->id,
          'balance_transaction' => $charge->balance_transaction,
          'txn_raw' => json_encode($charge),
          'amount' => $price,
          'status' => $charge->status == 'succeeded' ? 'success' : 'failed',
          'card_id' => '',
          //                                    'payment_date'          => now(),
          'created_at' => now(),
          'payment_type' => 'Card',
          ];
          $trnxCreate = Transaction::create($txnData);
          foreach ($cartItems as $cartItem) {
          $orderItemsData = [
          'order_id' => $orderCreate->id,
          'user_id' => $userId,
          'product_id' => $cartItem->product->id,
          'quantity' => $cartItem->quantity,
          'price' => $cartItem->product->single_license,
          'amount' => number_format((float) ($cartItem->product->single_license * $cartItem->quantity), 2, '.', ''),
          'payment_type' => 'Card',
          'status' => 0,
          ];
          $createOrderItems = OrderItem::create($orderItemsData);
          }



          if ($trnxCreate->status == 'success') {
          $orderCreate = Order::where('id', $trnxCreate->order_id)->update(['status' => 1]);
          $createOrderItems = OrderItem::where('order_id', $trnxCreate->order_id)->update(['status' => 1]);
          //                $sellerHistory      =   SellerHistory::where('order_id', $trnxCreate->order_id)->update(['status' => 'Delivered']);
          } else {
          throw new Exception("Something went wrong");
          }

          //Send email:
          $subject = "Cart checkout/Purchase successfully";
          $alldats = [
          "payee_name" => $paidUser->first_name . ' ' . $paidUser->surname,
          "paid_email" => $paidUser->email,
          "subject" => $subject,
          "email_content" => $orderNumberCreate,
          ];

          Mail::send('emails/cart_checkout_payment', $alldats, function ($message)use ($alldats) {
          $message->to($alldats['paid_email']);
          $message->subject($alldats['subject']);
          });
          // ==================================================================== //
          $payment_status = true;
          //            if ($save_for_future === 1) {
          //                    $payment_status = $this->stripeActionService->addCard($request);
          //            }
          if ($payment_status) {
          DB::commit();
          CartItem::where('user_id', $userId)->delete();
          return redirect()->route('accountDashboard.myPurchaseHistory')->with('success', 'Payment successfully done!');
          } else {
          return redirect()->route('accountDashboard.myCart')->with('error', 'Something went wrong!. But payment successfully done!');
          }
          } catch (Exception $ex) {
          DB::rollBack();
          dd($ex);
          return redirect()->route('accountDashboard.myCart')->with('error', 'Something went wrong');
          }
          } catch (\Stripe\Exception\CardException $e) {
          Session::flash('error', $e->getMessage());
          return Redirect::back();
          } catch (\Stripe\Exception\RateLimitException $e) {
          Session::flash('error', $e->getMessage());
          return Redirect::back();
          } catch (\Stripe\Exception\InvalidRequestException $e) {
          Session::flash('error', $e->getMessage());
          return Redirect::back();
          } catch (\Stripe\Exception\AuthenticationException $e) {
          Session::flash('error', $e->getMessage());
          return Redirect::back();
          } catch (\Stripe\Exception\ApiConnectionException $e) {
          Session::flash('error', $e->getMessage());
          return Redirect::back();
          } catch (\Stripe\Exception\ApiErrorException $e) {
          Session::flash('error', $e->getMessage());
          return Redirect::back();
          } catch (\Exception $e) {
          Session::flash('error', $e->getMessage());
          return Redirect::back();
          }
          } catch (\Stripe\Exception\CardException $e) {
          Session::flash('error', $e->getMessage());
          return Redirect::back();
          } catch (\Stripe\Exception\RateLimitException $e) {
          Session::flash('error', $e->getMessage());
          return Redirect::back();
          } catch (\Stripe\Exception\InvalidRequestException $e) {
          Session::flash('error', $e->getMessage());
          return Redirect::back();
          } catch (\Stripe\Exception\AuthenticationException $e) {
          Session::flash('error', $e->getMessage());
          return Redirect::back();
          } catch (\Stripe\Exception\ApiConnectionException $e) {
          Session::flash('error', $e->getMessage());
          return Redirect::back();
          } catch (\Stripe\Exception\ApiErrorException $e) {
          Session::flash('error', $e->getMessage());
          return Redirect::back();
          } catch (\Exception $e) {
          Session::flash('error', $e->getMessage());
          return Redirect::back();
          }
          } catch (\Stripe\Exception\CardException $e) {
          Session::flash('error', $e->getMessage());
          return Redirect::back();
          } catch (\Stripe\Exception\RateLimitException $e) {
          Session::flash('error', $e->getMessage());
          return Redirect::back();
          } catch (\Stripe\Exception\InvalidRequestException $e) {
          Session::flash('error', $e->getMessage());
          return Redirect::back();
          } catch (\Stripe\Exception\AuthenticationException $e) {
          Session::flash('error', $e->getMessage());
          return Redirect::back();
          } catch (\Stripe\Exception\ApiConnectionException $e) {
          Session::flash('error', $e->getMessage());
          return Redirect::back();
          } catch (\Stripe\Exception\ApiErrorException $e) {
          Session::flash('error', $e->getMessage());
          return Redirect::back();
          } catch (\Exception $e) {
          Session::flash('error', $e->getMessage());
          return Redirect::back();
          }
        */
    }

    public function checkCardStatus(Request $request) {
        return $this->stripeActionService->checkCardStatus($request);
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function generate_orderinvoice($data){
        $html = '<h1>Generate html to PDF</h1>
                 <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry<p>';
        
        $pdf= PDF::loadHTML($html);
       
        return $pdf->download('invoice.pdf');
    }

}
