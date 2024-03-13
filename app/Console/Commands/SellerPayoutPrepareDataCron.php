<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{User,OrderItem,StripeAccount,Product,Seller_Payout_Cron_History,Store};

class SellerPayoutPrepareDataCron extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sellerPayoutPrepareData:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
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
        
        $stripeConnectUsers = StripeAccount::where('approved_status', 1)->get();
        $stripeConnectUserIdArr =   $stripeConnectUsers->pluck('user_id')->toArray();
        $ellerPayoutCronHistoryCheck    =   Seller_Payout_Cron_History::where('payout_status', 0)->get()->pluck('seller_user_id')->toArray();
        $payOutUserIdArr    = array_values(array_diff($stripeConnectUserIdArr, $ellerPayoutCronHistoryCheck));
       
        $sellers = User::where('role_id', 2)->where('status', 1)->whereIn('id', $payOutUserIdArr)->get();
        if($sellers->isNotEmpty()){

            foreach ($sellers as $seller) {
                $get_prodids = Product::where('user_id',$seller->id)->pluck('id')->toArray();
                $sellerSellingHistory = OrderItem::whereIn('product_id', $get_prodids)->where('payout_status', 0)->where('status', 1)->where('type','product')->get();

                if($sellerSellingHistory->isNotEmpty()){
                    $payOutSellingProdIds   =   $sellerSellingHistory->pluck('id')->toArray();
                    $sellerSellingTotalSum  =   OrderItem::whereIn('id', $payOutSellingProdIds)->get();
                    $earnings = 0;
                    $commissioncollected = 0;
                    $transactionchargecollected = 0;
                    $salestaxcollected = 0;
                    foreach($sellerSellingTotalSum as $ttl){
                       
                        $usrinfo = User::where('id',$ttl->user_id)->first();
                        $sellerinfo = Store::where('user_id',$seller->id)->first();
                        
                        // $transaction_charge = ( !empty($usrinfo) && $usrinfo->country != 'Aus') ?(!empty($sellerinfo->transactioncharge_other)?$sellerinfo->transactioncharge_other:env('TRANSACTION_CHARGE_OTHER')):(!empty($sellerinfo->transactioncharge_aus)?$sellerinfo->transactioncharge_aus:env('TRANSACTION_CHARGE_AUS'));
                        // $salescommission = !empty($sellerinfo->sale_commission)?$sellerinfo->sale_commission:env('SALE_COMMISION');
                        // $salescommission = (new \App\Http\Helper\Web)->checkifsellerundermembership($seller->id,$ttl->created_at,$salescommission);
                        // $salestax = !empty($sellerinfo->salestax)?$sellerinfo->salestax:env('SALE_TAX');
                        $commissioncollected += $ttl->commission;
                        $transactionchargecollected += $ttl->transaction_charges;
                        $salestaxcollected += $ttl->sales_tax;
                        $earnings  += $ttl->amount - $ttl->commission - $ttl->transaction_charges - $ttl->sales_tax;
                    }
                    if(!($earnings>0)){
                        continue;
                    }
                    $sellers_payout_data        =   [
                        'seller_user_id'               =>  $seller->id,
                        'payout_amount'                =>  $earnings,
                        'commission'                   =>  $commissioncollected,
                        'transaction_charges'          =>  $transactionchargecollected,
                        'sales_tax'                    =>  $salestaxcollected,
                        'payout_selling_history_id'    =>  implode(',', $payOutSellingProdIds),
                        'status'                       =>  0,
                    ];
                    $create = Seller_Payout_Cron_History::create($sellers_payout_data);
                    if($create){
                        error_log("Seller Payout Prepare Data Cron-Success! ==> $curr_date \n", 3, public_path("seller-payout-prepare-data-cron-log.log"));
                    } else {
                        error_log("Seller Payout Prepare Data Cron-Failed!=>_user_id_ $seller->id ==> $curr_date \n", 3, public_path("seller-payout-prepare-data-cron-log.log"));
                    }


                }

            }
        }
        
        
        
        
        
        
        
        
        
        
    }
}
