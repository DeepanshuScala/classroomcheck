<?php
namespace App\Services;


use App\Models\{User,UserCard};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB,Session,Redirect};

class StripeActionsService{
    public $stripe_key;

    public function __construct(){
        $this->stripe_key = env('STRIPE_SECRET_KEY');
    }


    // ============================ Create Stripe Temporary Token ============================ //

    public function createStripeCardToken( $card_number, $card_exp_month, $card_exp_year, $card_cvc ){

        $stripe = new \Stripe\StripeClient( $this->stripe_key );
        return  $stripe->tokens->create([
            'card' => [
              'number' => $card_number,
              'exp_month' => $card_exp_month,
              'exp_year' => $card_exp_year,
              'cvc' => $card_cvc,
            ],
          ]);
    }
    // ======================================================================================= //

    // ============================= Charge Payment ================================ //

    public function chargePayment($amount, $currency, $customer_id){

        $stripe = new \Stripe\StripeClient( $this->stripe_key );
        return $stripe->charges->create([
                
            'amount' => (100 * $amount),
            'currency' => $currency,
            'customer' => $customer_id,

        ]);
    }

    // ============================================================================= //

    // ======================= generate customer stripe id ========================= //
        public function createCustomerId($stripe_token,$user_email){

            $stripe = new \Stripe\StripeClient( $this->stripe_key );
            return $stripe->customers->create([
                'source' => $stripe_token,
                'email' => $user_email,
            ]);
        }

    // ================= Add card for future payment use ================== //
       public function addCard(Request $request) {
        $user_info = auth()->user();
      
            $postData = $request->all();
            $checkCardExist = $this->checkCardStatus($request);
          
            if (collect($checkCardExist)->toArray()['original']['status'] != 'error') {
                return true;
            }
           
            $stripe = new \Stripe\StripeClient([
                "api_key" => env('STRIPE_SECRET_KEY'),
            ]);
            if ($user_info->customer_id == '') {
                //create customer
                try {
                    $stripe_customer = $stripe->customers->create([
                        'email' => $user_info->email,
                        'name' => $user_info->first_name . " " . $user_info->last_name,
                        'address' => ["country" => 'UK'],
                        'metadata' => array("user_id" => $user_info->id)
                    ]);
                   
                    User::where('id', $user_info->id)->update([
                        "customer_id" => $stripe_customer->id
                    ]);
                    $customer_id = $stripe_customer->id;
                } catch (\Stripe\Exception\CardException $e) {
                    Session::flash ( 'error', $e->getMessage() );
                    return Redirect::back ();
                } catch (\Stripe\Exception\RateLimitException $e) {
                    Session::flash ( 'error', $e->getMessage() );
                    return Redirect::back ();
                } catch (\Stripe\Exception\InvalidRequestException $e) {
                    Session::flash ( 'error', $e->getMessage() );
                    return Redirect::back ();
                } catch (\Stripe\Exception\AuthenticationException $e) {
                    Session::flash ( 'error', $e->getMessage() );
                    return Redirect::back ();
                } catch (\Stripe\Exception\ApiConnectionException $e) {
                    Session::flash ( 'error', $e->getMessage() );
                    return Redirect::back ();
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    Session::flash ( 'error', $e->getMessage() );
                    return Redirect::back ();
                } catch (\Exception $e) {
                    Session::flash ( 'error', $e->getMessage() );
                    return Redirect::back ();
                }
            } else {
                $customer_id = $user_info->customer_id;
            }
            try {
                $customerData = $stripe->customers->retrieve($customer_id);
                $default_source = $customerData->default_source;
                $StripeToken = $stripe->tokens->create([
                    "card" => [
                        "name" => $postData['card_holder_name'],
                        "number" => $postData['card_number'],
                        "cvc" => $postData['cvv'],
                        "exp_month" => $postData['exp_month'],
                        "exp_year" => $postData['exp_year']
                    ]
                ]);
                $token = $StripeToken->id;
                $stripe_card_id = $StripeToken->card->id;
                $stripe->customers->createSource($customer_id, array("source" => $token));
                $card_id = DB::table('user_card')->insertGetId([
                    'user_id' => $user_info['id'],
                    'stripe_token' => '',
                    'stripe_card_id' => $stripe_card_id,
                    'card_holder_name' => $postData['card_holder_name'],
                    "card_number" => $postData['card_number'],
                    "cvc" => $postData['cvv'],
                    "exp_month" => $postData['exp_month'],
                    "exp_year" => $postData['exp_year'],
                    'card_type' => $stripe->customers->retrieveSource(
                        $customer_id,
                        $default_source,
                        []
                      )->funding,
                    "created_at" => date('Y-m-d H:i:s')
                ]);
                if ($card_id > 0) {
                    return true;
                } else {
                    return false;
                }
            } catch (\Stripe\Exception\CardException $e) {
                Session::flash ( 'error', $e->getMessage() );
                return Redirect::back ();
            } catch (\Stripe\Exception\RateLimitException $e) {
                Session::flash ( 'error', $e->getMessage() );
                return Redirect::back ();
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                Session::flash ( 'error', $e->getMessage() );
                return Redirect::back ();
            } catch (\Stripe\Exception\AuthenticationException $e) {
                Session::flash ( 'error', $e->getMessage() );
                return Redirect::back ();
            } catch (\Stripe\Exception\ApiConnectionException $e) {
                Session::flash ( 'error', $e->getMessage() );
                return Redirect::back ();
            } catch (\Stripe\Exception\ApiErrorException $e) {
                Session::flash ( 'error', $e->getMessage() );
                return Redirect::back ();
            } catch (\Exception $e) {
                Session::flash ( 'error', $e->getMessage() );
                return Redirect::back ();
            }
    }

     public function checkCardStatus(Request $request){
        if (($request->has('card_number') && !empty($request->has('card_number'))) && auth()->user()) {
            $card_details = UserCard::where([['card_number' , $request->card_number],['is_deleted' , 0]])
            ->select('card_holder_name','card_number','exp_month','exp_year')->first();

            $data = [];
            if ($card_details) {
               $data['status'] = 'success';
               $data['data'] = $card_details;
            }else{
                $data['status'] = 'error';
               $data['data'] = [];
            }
            return response()->json($data);
        }
    }
}

?>