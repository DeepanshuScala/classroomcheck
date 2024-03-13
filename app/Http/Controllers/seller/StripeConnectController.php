<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    Hash,
    Crypt,
    Auth,
    DB,
    Validator,
    Mail,
    Str,
    URL,
    Redirect,
    Session
};
use App\Models\{
    User,
    Country,
    StripeAccount
};
use Carbon\Carbon;

class StripeConnectController extends Controller {

    public function createStripeAccount(Request $request) {
        try {

            $user = auth()->user();
            $check_already_exist = StripeAccount::where('user_id', $user->id)->first();
            if (!empty($check_already_exist) && $check_already_exist->approved_status == 1) {
                return redirect()->route('become.a.seller')->with('success', 'Account already created!');
            }
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

            if (!empty($stripe)) {
                $countryRes = Country::where('name', $user->country)->first();
                $token = $stripe->accounts->create([
                    'country' => $countryRes->sortname,
                    'email' => $user->email,
                    'type' => 'express',
                    'capabilities' => [
                        'card_payments' => ['requested' => true],
                        'transfers' => ['requested' => true],
                    ],
                ]);

                if (!empty($token)) {
                    $stripe_create = [
                        'user_id' => $user->id,
                        'account_id' => $token->id,
                        'raw_data' => json_encode($token),
                        'approved_status' => '0',
                    ];
                    $account_id = StripeAccount::create($stripe_create);
                    if ($account_id) {
                        try {
                            $account_id = StripeAccount::where('user_id', $user->id)->first();
                            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
                            if (!empty($stripe)) {
                                $token = $stripe->accountLinks->create([
                                    'account' => $account_id->account_id,
                                    'refresh_url' => route('refresh.url'),
                                    'return_url' => route('return.url'),
                                    'type' => 'account_onboarding',
                                ]);
                                //echo '<script> window.location.replace("' . $token->url . '")</script>';
                                return redirect()->to($token->url);
                                // return $token->url;
                                exit;
                            } else {
                                return redirect()->back()->with('error', 'Stripe Not Initiated...');
                            }
                        } catch (\Stripe\Exception\RateLimitException $ex) {
                            return redirect()->back()->with('error', $ex->getMessage());
                        } catch (\Stripe\Exception\AuthenticationException $ex) {
                            return redirect()->back()->with('error', $ex->getMessage());
                        } catch (\Stripe\Exception\ApiConnectionException $ex) {
                            return redirect()->back()->with('error', $ex->getMessage());
                        } catch (\Stripe\Exception\InvalidRequestException $ex) {
                            return redirect()->back()->with('error', $ex->getMessage());
                        } catch (\Stripe\Exception\CardException $ex) {
                            return redirect()->back()->with('error', $ex->getMessage());
                        } catch (\Swift_TransportException $ex) {
                            return redirect()->back()->with('error', $ex->getMessage());
                        } catch (Exception $ex) {
                            return redirect()->back()->with('error', $ex->getMessage());
                        }
                    } else {
                        return redirect()->back()->with('error', 'Account not created!');
                    }
                } else {
                    return redirect()->back()->with('error', 'Account not created!');
                }
            } else {
                return redirect()->back()->with('error', 'Stripe Not Ini...');
            }
        } catch (\Stripe\Exception\RateLimitException $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        } catch (\Stripe\Exception\AuthenticationException $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        } catch (\Stripe\Exception\ApiConnectionException $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        } catch (\Stripe\Exception\InvalidRequestException $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        } catch (\Stripe\Exception\CardException $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        } catch (\Swift_TransportException $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    public function refreshUrl(Request $request) {
        try {
            $user = auth()->user();
            $account_id = StripeAccount::where('user_id', $user->id)->first();
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
            if (!empty($stripe)) {
                $token = $stripe->accountLinks->create([
                    'account' => $account_id->account_id,
                    'refresh_url' => route('refresh.url'),
                    'return_url' => route('return.url'),
                    'type' => 'account_onboarding',
//                    'collect' => 'eventually_due',
                ]);
                echo '<script> window.location.replace("' . $token->url . '")</script>';
                print_r($token->url);
                dd($token->url);
                exit;
            } else {
                return redirect()->back()->with('error', 'Stripe Not Ini...');
            }
        } catch (\Stripe\Exception\RateLimitException $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        } catch (\Stripe\Exception\AuthenticationException $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        } catch (\Stripe\Exception\ApiConnectionException $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        } catch (\Stripe\Exception\InvalidRequestException $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        } catch (\Stripe\Exception\CardException $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        } catch (\Swift_TransportException $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    public function returnUrl(Request $request) {
        //dd($request());
        $stripeConnectLoginLinkCreate = $this->stripeExpressConnectLoginLink($request);
        if ($stripeConnectLoginLinkCreate === true) {
            $account_id_login_link_create = StripeAccount::where('user_id', auth()->user()->id)->update(['approved_status' => 1]);
            $data = [
              "name" => auth()->user()->first_name,
              "email" => auth()->user()->email,
              "subject" => 'Thank You for Choosing Classroom Copy for Your Educational Resources',
              //"verify_user_token" => $accountUserCreate->verifyUser->token,
            ];

            $send_mail = Mail::send('emails/seller_welcome_mail', $data, function ($message)use ($data) {
              $message->to($data['email']);
              $message->cc('admin@classroomcopy.com');
              $message->subject($data['subject']);
            });
            User::where('id', auth()->user()->id)->update(['process_completion' => 3]);
            return redirect()->route('become.a.seller')->with('success', 'Stripe account created successfully. Also, Login link for stripe dashboard created');
        } else {
            return redirect()->route('become.a.seller')->with('success', 'Stripe account onboarding successfully. But, Login link for stripe dashboard has not created');
        }
    }

    public function stripeExpressConnectLoginLink(Request $request) {
        $check_already_exist = StripeAccount::where('user_id', auth()->user()->id)->whereNotNull('login_link')->first();
        $account_id = StripeAccount::where('user_id', auth()->user()->id)->first();
        if (!empty($check_already_exist)) {
            //return redirect()->route('become.a.seller')->with('success', 'Account login link  already created!');
            return true;
        }
        try{
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
            $express_login_link_create = $stripe->accounts->createLoginLink(
                    $account_id->account_id,
                    [],
            );
            // dd($express_login_link_create->url);
            if ($express_login_link_create) {
                $account_id_login_link_create = StripeAccount::where('user_id', auth()->user()->id)->update(['login_link' => $express_login_link_create->url]);
                if ($account_id_login_link_create) {
                    return true;
                    //            return redirect()->route('become.a.seller')->with('success', 'Your stripe connect login link created succesfully.You can now login your stripe connect Dashboard');
                } else {
                    return false;
                    //            return redirect()->route('become.a.seller')->with('error', 'Something went wrong!');
                }
            } else {
                return false;
            }
        }catch (\Stripe\Exception\InvalidRequestException $e) {
            return redirect()->route('become.a.seller')->with('error', 'Something went wrong!');
        } catch (\Exception $e) {
            // Handle general exceptions
            return redirect()->route('become.a.seller')->with('error', 'Something went wrong!');
        }
    }

}
