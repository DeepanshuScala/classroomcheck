<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    DB,
    Session,
    Redirect
};
use \App\Models\{
    User,
    UserCard,
    StripeAccount
};

class PaymentController extends Controller {

    /** + 
     * used to show payment system page
     * @param Request $request - request type get
     * @return type
     */
    public function index(Request $request) {
        $data = [];
        $data['title'] = 'Payment System';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Store Dashboard';
        $data['breadcrumb1_link'] = route('store.dashboard');
        $data['breadcrumb2'] = 'Payment System';
        $data['result'] = StripeAccount::where('user_id', auth()->user()->id)->where('approved_status', 1)->first();

        return view('store.payment.payment_system', compact('data'));
    }

    /** + 
     * used to get card list
     * @param Request $request - request type get
     * @return type
     */
    public function getCardList(Request $request) {
        $data = [];
        $data['title'] = 'Cards';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Store Dashboard';
        $data['breadcrumb1_link'] = route('store.dashboard');
        $data['breadcrumb2'] = 'Payment System';
        $data['breadcrumb2_link'] = route('seller.paymentsystem');
        $data['breadcrumb3'] = 'Cards';
        $data['result'] = UserCard::where('is_deleted', 0)->where('user_id', auth()->user()->id)->get();

        return view('store.payment.card_list', compact('data'));
    }

    /** + 
     * used to remove card
     * @param type $card_id - id of card
     * @return type
     */
    public function removeCard($card_id) {
        try {
            $user_id = Auth()->user()->id;
            $cardRes = UserCard::where('user_id', $user_id)->where('id', $card_id)->first();
            if ($cardRes == null) {
                return Redirect::to('/seller/card-list')->with('error', "Card not valid");
            } else {
                UserCard::where('id', $card_id)->update([
                    'is_deleted' => 1,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                return Redirect::to('/seller/card-list')->with('success', "Card deleted successfully");
            }
        } catch (\Exception $e) {
            return Redirect::to('/seller/card-list')->with('error', $e->getMessage());
        }
    }

    /** + 
     * used to add new card
     * @param Request $request - request type get
     * @return type
     */
    public function addCard(Request $request) {
        $data = [];
        $data['title'] = 'Add Card';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Store Dashboard';
        $data['breadcrumb1_link'] = route('store.dashboard');
        $data['breadcrumb2'] = 'Payment System';
        $data['breadcrumb2_link'] = route('seller.paymentsystem');
        $data['breadcrumb3'] = 'Add Card';
        $data['prevURl'] = url()->previous();

        return view('store.payment.add_card', compact('data'));
    }

    /** + 
     * used to add/update card
     * @param Request $request - request type post
     */
    public function saveCard(Request $request) {
        try {
            $success = 0;
            $message = '';
            $user_id = Auth()->user()->id;
            //$exp_month = $request->card_expiry_month;
            $exp_month = sprintf("%02d", $request->card_expiry_month);
            if (isset($request->card_id)) {
                $checkCardExist = UserCard::where('user_id', $user_id)
                                ->where('id', $request->card_id)
                                ->where('is_deleted', 0)->first();
                if ($checkCardExist == null) {
                    $success = 3;
                } else {
                    $response = $this->updateCardToStripe($request, $checkCardExist);
                    if ($response['success'] == 0) {
                        $message = $response['message'];
                        $success = 0;
                    } else {
                        UserCard::where('id', $request->card_id)->update([
                            'card_holder_name' => $request->card_name,
                            'exp_month' => $exp_month,
                            'exp_year' => $request->card_expiry_year,
                            'is_default_card' => $request->default_card,
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]);
                        if ($request->default_card == 1) {
                            UserCard::where('id', '!=', $request->card_id)->update([
                                'is_default_card' => 0,
                                'updated_at' => date('Y-m-d H:i:s')
                            ]);
                        }
                        $success = 1;
                    }
                }
            } else {
                $checkCardExist = UserCard::where('user_id', $user_id)->where('card_number', $request->card_number)->where('is_deleted', 0)->get();
                if (count($checkCardExist) > 0) {
                    $success = 2;
                } else {
                    $response = $this->addCardToStripe($request);

                    if ($response['success'] == 0) {
                        $message = $response['message'];
                        $success = 0;
                    } else {
                        $card = UserCard::create([
                                    'user_id' => $user_id,
                                    'card_type' => $response['stripe_card_type'],
                                    'card_number' => $request->card_number,
                                    'card_holder_name' => $request->card_name,
                                    'exp_month' => $exp_month,
                                    'exp_year' => $request->card_expiry_year,
                                    'cvc' => '',
                                    'stripe_card_id' => $response['stripe_card_id'],
                                    'brand' => $response['brand'],
                                    'is_default_card' => $request->default_card
                        ]);
                        
                        if ($card->id > 0) {
                            if ($request->default_card == 1) {
                                UserCard::where('id', '!=', $card->id)->update([
                                    'is_default_card' => 0,
                                    'updated_at' => date('Y-m-d H:i:s')
                                ]);
                            }
                            $success = 1;
                        }
                    }
                }
            }
            return json_encode(array('success' => $success, 'message' => $message));
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /** + 
     * used to save card on stripe
     * @param type $request
     * @return type
     */
    public function addCardToStripe($request) {
        $user_info = auth()->user();
        $stripe = new \Stripe\StripeClient([
            "api_key" => env('STRIPE_SECRET_KEY'),
        ]);
        $returnResponse = array('success' => 0, 'message' => '', 'stripe_card_id' => '', 'stripe_card_type' => '', 'brand' => '');
        $postData = $request->all();
        if ($user_info->stripe_customer_id == '') {
            //create customer
            try {
                $stripe_customer = $stripe->customers->create([
                    'email' => $user_info->email,
                    'name' => $user_info->first_name . " " . $user_info->last_name,
                    'address' => ["country" => env('STRIPE_COUNTRY')],
                    'metadata' => array("user_id" => $user_info->id)
                ]);

                User::where('id', $user_info->id)->update([
                    "stripe_customer_id" => $stripe_customer->id
                ]);
                $customer_id = $stripe_customer->id;
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
        } else {
            $customer_id = $user_info->stripe_customer_id;
        }
        try {
            $customerData = $stripe->customers->retrieve($customer_id);
            $StripeToken = $stripe->tokens->create([
                "card" => [
                    "name" => $postData['card_name'],
                    "number" => base64_decode($postData['card_number']),
                    "cvc" => base64_decode($postData['cvv']),
                    "exp_month" => $postData['card_expiry_month'],
                    "exp_year" => $postData['card_expiry_year']
                ]
            ]);
            $token = $StripeToken->id;
            $stripe->customers->createSource($customer_id, array("source" => $token));
            $stripe_card_id = $StripeToken->card->id;
            $stripe_card_type = $StripeToken->card->funding;
            $brand = $StripeToken->card->brand;
            $returnResponse['success'] = 1;
            $returnResponse['stripe_card_id'] = $stripe_card_id;
            $returnResponse['stripe_card_type'] = $stripe_card_type;
            $returnResponse['brand'] = $brand;
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
     * used to update card on stripe
     * @param type $request
     * @return type
     */
    public function updateCardToStripe($request, $cardRes) {
        $user_info = auth()->user();
        $postData = $request->all();
        $stripe = new \Stripe\StripeClient([
            "api_key" => env('STRIPE_SECRET_KEY'),
        ]);
        $returnResponse = array('success' => 0, 'message' => '', 'stripe_card_id' => '', 'stripe_card_type' => '', 'brand' => '');
        $customer_id = $user_info->stripe_customer_id;
        try {
            $stripe->customers->updateSource($customer_id, $cardRes->stripe_card_id, [
                "name" => $postData['card_name'],
                "exp_month" => $postData['card_expiry_month'],
                "exp_year" => $postData['card_expiry_year']
            ]);
            $returnResponse['success'] = 1;
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
     * used to update card details
     * @param type $card_id - id of card
     * @return type
     */
    public function updateCard($card_id) {
        try {
            $user_id = Auth()->user()->id;
            $cardRes = UserCard::where('user_id', $user_id)->where('id', $card_id)->first();
            if ($cardRes == null) {
                return Redirect::to('/seller/card-list')->with('error', "Card not valid");
            } else {
                $data = [];
                $data['title'] = 'Cards';
                $data['home'] = 'Home';
                $data['breadcrumb1'] = 'Store Dashboard';
                $data['breadcrumb1_link'] = route('store.dashboard');
                $data['breadcrumb2'] = 'Cards';
                $data['result'] = $cardRes;

                return view('store.payment.edit_card', compact('data'));
            }
        } catch (\Exception $e) {
            return Redirect::to('/seller/card-list')->with('error', $e->getMessage());
        }
    }

}
