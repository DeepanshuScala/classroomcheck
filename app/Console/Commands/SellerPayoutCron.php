<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{User,OrderItem,StripeAccount,Product,Seller_Payout_Cron_History};
use Exception;

class SellerPayoutCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sellerPayout:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seller payout cron';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        //return 0;
        $curr_date  =   date('Y-m-d H:i:s');
       
        $sellerPayoutCronHistory = Seller_Payout_Cron_History::where('payout_status', 0)->get();
        if($sellerPayoutCronHistory->isNotEmpty()){
            foreach ($sellerPayoutCronHistory as $paidUser) {
                if(!($paidUser->payout_amount > 0)){
                    continue;
                }
                $sellerHistoryIdsArr    =   explode(',', $paidUser->payout_selling_history_id);
                $account_id = StripeAccount::where('user_id', $paidUser->seller_user_id)->first();

                // $account_id = $paidUser->stripeConnectUserDetails->account_id;
                $STRIPE_API_KEY = env('STRIPE_SECRET_KEY');

                $stripe = new \Stripe\StripeClient($STRIPE_API_KEY);
                
                if (!empty($stripe)) {
                  
                    try{
                        error_log("$curr_date $paidUser->payout_amount  $account_id->account_id  now \n ", 3, public_path("payOut-cron-log.log"));
                        // $stripeTransfer =   $stripe->charges->create(array(
                        //     'currency' => env('CURRENCY'),
                        //     'amount'   => 10000,
                        //     'source' => 'tok_bypassPending',
                        //     'description' => 'For test purpose adding balance and then sending money',
                        // ));

                        $stripeTransfer =   $stripe->transfers->create([
                            'amount'        => $paidUser->payout_amount * 100,
                            'currency'      => env('CURRENCY'),
                            'destination'   => $account_id->account_id,
                            'metadata' => [
                                          '1. Total Amount' => '$'.number_format((float)($paidUser->payout_amount+$paidUser->transaction_charges+$paidUser->commission+$paidUser->sales_tax), 2, '.', ''),
                                          '2. Commission' => '$'.number_format((float) ($paidUser->commission), 2, '.', ''),
                                          '3. Transaction Charge' => '$'.number_format((float)($paidUser->transaction_charges), 2, '.', ''),
                                          '4. Sales Tax' => '$'.number_format((float) ($paidUser->sales_tax), 2, '.', ''),
                                          'Net Amount' => '$'.number_format((float)($paidUser->payout_amount), 2, '.', ''),
                                        ]
                        ]);
                        error_log("$curr_date $paidUser->payout_amount 11111     \n", 3, public_path("payOut-cron-log.log"));
                    }
                    catch (\Stripe\Exception\CardException $e) {
                        error_log("$curr_date $e->getError()->message \n", 3, public_path("payOut-cron-log.log"));
                        //return Redirect::back()->with('error', );
                    } catch (\Stripe\Exception\RateLimitException $e) {
                        error_log("$curr_date $e->getError()->message \n", 3, public_path("payOut-cron-log.log"));
                        //return Redirect::back()->with('error', $e->getMessage());
                    } catch (\Stripe\Exception\InvalidRequestException $e) {
                        error_log("$curr_date $e->getError()->param \n", 3, public_path("payOut-cron-log.log"));
                        //return Redirect::back()->with('error', $e->getMessage());
                    } catch (\Stripe\Exception\AuthenticationException $e) {
                        error_log("$curr_date $e->getError()->message \n", 3, public_path("payOut-cron-log.log"));
                       // return Redirect::back()->with('error', $e->getMessage());
                    } catch (\Stripe\Exception\ApiConnectionException $e) {
                        error_log("$curr_date $e->getError()->message \n", 3, public_path("payOut-cron-log.log"));
                        //return Redirect::back()->with('error', $e->getMessage());
                    } catch (\Stripe\Exception\ApiErrorException $e) {
                        error_log("$curr_date $e->getError()->message \n", 3, public_path("payOut-cron-log.log"));
                        //return Redirect::back()->with('error', $e->getMessage());
                    } 
                    catch (\Exception $e) {
                        error_log("$curr_date $e->getError()->message \n", 3, public_path("payOut-cron-log.log"));
                        //return Redirect::back()->with('error', $e->getMessage());
                    }
                    
                    if($stripeTransfer->id){
                        error_log("$curr_date ==> Fund transfered successfully. \n", 3, public_path("payOut-cron-log.log"));
                        $sellerPayoutCronHistoryUpdate      = Seller_Payout_Cron_History::where('id', $paidUser->id)->update(['payout_status' => 1]);
                        $sellerHistoryPayoutStatusUpdate    = OrderItem::whereIn('id', $sellerHistoryIdsArr)->update(['payout_status' => 1]);
                    }
                    if($sellerPayoutCronHistoryUpdate && $sellerHistoryPayoutStatusUpdate){
                        error_log("$curr_date user_id=$paidUser->id ==> Fund transfered successfully & Status updated \n", 3, public_path("payOut-cron-log.log"));
                    } else {
                        error_log("$curr_date user_id=$paidUser->id ==> Fund transfered successfully & Status updated error! ==> _user_id_ $paidUser->id \n", 3, public_path("payOut-cron-log.log"));
                    }
                } else {
                    error_log("$curr_date ==> Stripe Not Ini... \n", 3, public_path("payOut-cron-log.log"));
                }
            }
        }
        
    }
}
