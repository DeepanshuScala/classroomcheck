<?php

namespace App\Http\Controllers\seller\marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    DB,
    Validator,
    Session,
    Redirect,
    Auth,
    Crypt
};
use \App\Models\{
    User,
    Product,
    FeatureList,
    UserCard
};

class FeatureController extends Controller {

    /**
     * used to show feature listing page and save featured product to database
     * @param Request $request - request type get/post
     * @return type
     */
    public function featureListings(Request $request) {
        if ($request->isMethod('post')) {
            
            $success = 0;
            $feature_id = '';
            $message = "";
            $dates = array();
            if(!empty($request->dates)){
                foreach($request->dates as $reqdt){
                     $dates[] = date('Y-m-d', strtotime($reqdt));
                }
            }
            $response = array();
            foreach($dates as $d){
                $featureProductCount = FeatureList::where('date', $d)->where('category',$request->category)->where('product_id',$request->product_id)->where('status', 1)->count();
                $samedaycheck = FeatureList::where('date', $d)->where('category',$request->category)->where('product_id',$request->product_id)->count();
                if($samedaycheck > 0){
                    $response[$d]['success'] = 0;
                    $response[$d]['message'] = " Slot already booked on " . date('d M, Y', strtotime($d)) . " for same product.";
                }
                elseif ($featureProductCount >= 4) {
                    $response[$d]['success'] = 0;
                    $response[$d]['message'] = " Slot not available for " . date('d M, Y', strtotime($d)). ".";
                } else {
                    $isAdded = FeatureList::create([
                                'user_id' => auth()->user()->id,
                                'category' => $request->category,
                                'product_id' => (int) $request->product_id,
                                'date' => $d,
                                'amount' => $request->amount,
                                'payment_status' => 0
                    ]);
                    if ($isAdded->id > 0) {
                        $response[$d]['success'] = 1;
                        $response[$d]['message'] = " Slot booked for " . date('d M, Y', strtotime($d)).".";
                    } else {
                        $response[$d]['success'] = 0;
                    }
                }
            }
            $success = 0;
            $check_slot_booked = 0;
            foreach($response as $r){
                if($r['success'] == 1){
                    $check_slot_booked = 1;
                    $success = 1;
                }
            }
            $message = (count($response)>1)?"Slots Already Booked For these dates.":"Slot Already Booked For this date.";
            if($check_slot_booked){
                $message = (count($response)>1)?'Slots Successfully Booked':'Slot Successfully Booked';
            }
            echo json_encode(array('success' => $success,  'message' => $message));
        } else {
            $data = [];
            $data['title'] = 'Featured Listings';
            $data['home'] = 'Home';
            $data['breadcrumb1'] = 'Store Dashboard';
            $data['breadcrumb1_link'] = route('store.dashboard');
            $data['breadcrumb2'] = 'Marketing';
            $data['breadcrumb2_link'] = route('storeDashboard.marketingDashboard');
            $data['breadcrumb3'] = 'Featured Listings';
            $data['productResult'] = Product::where('user_id', auth()->user()->id)
                            ->where('is_deleted', 0)->where('status',1)->select('id', 'product_title')->get();
            //get expired planned marketing count
            $data['expiredPlannedMarketingcount'] = FeatureList::where('user_id', auth()->user()->id)
                            ->whereIn('status', [2])
                            ->whereIn('payment_status', [0, 2])
                            ->where('date', '<', date('Y-m-d'))->count();
            //get planned marketing history
            $plannedMarketingResult = FeatureList::join('crc_products', function ($join) {
                                $join->on('crc_products.id', '=', 'crc_product_feature_list.product_id');
                            })->where('crc_product_feature_list.user_id', auth()->user()->id)
                            ->whereIn('crc_product_feature_list.status', [0, 2])
                            ->whereIn('crc_product_feature_list.payment_status', [0, 2])
                            ->where('crc_products.is_deleted',0)->where('crc_products.status',1)
                            ->select('crc_product_feature_list.*', 'crc_products.product_title')->orderBy('crc_product_feature_list.date','ASC')->get();
            $totalAmt = $plannedMarketingResult->sum('amount');
            $plannedMarketingResult->each(function ($val) {
                $val->encrypt_id = Crypt::encrypt($val->id);
            });
            $data['plannedMarketingResult'] = $plannedMarketingResult;
            $data['plannedMarketingTotal'] = $totalAmt;
            //get confirmed marketing history
            $confirmedMarketingResult = FeatureList::join('crc_products', function ($join) {
                                $join->on('crc_products.id', '=', 'crc_product_feature_list.product_id');
                            })->where('crc_product_feature_list.user_id', auth()->user()->id)
                            ->whereIn('crc_product_feature_list.payment_status', [1])
                            ->whereIn('crc_product_feature_list.status', [1])
                            ->select('crc_product_feature_list.*', 'crc_products.product_title')->orderBy('crc_product_feature_list.id','Desc')->get();
            $confirmedMarketingResult->each(function ($val) {
                $val->encrypt_id = Crypt::encrypt($val->id);
            });
            $data['confirmedMarketingResult'] = $confirmedMarketingResult;

            return view('store.marketing.feature_listings', compact('data'));
        }
    }

    /**
     * used t o delete feature product
     * @param Request $request - request type get
     * @param type $feature_id - encrypted id of feature product
     * @return type
     */
    public function deleteFeatureProduct(Request $request, $feature_id) {
        $decryptFeatureId = Crypt::decrypt($feature_id);
        $result = FeatureList::find($decryptFeatureId);
        if ($result == null) {
            return Redirect::to(url('seller/marketing/feature-listing'))->with('error', "Feature product not valid");
        }
        FeatureList::where('id', $decryptFeatureId)->delete();
        return Redirect::to(url('seller/marketing/feature-listing'))->with('success', "Product deleted successfully");
    }

    /**
     * used to show payment page and charge amount
     * @param Request $request - request type get/post
     * @return type
     */
    public function featureListingPayment(Request $request) {
        $date = date('Y-m-d');
        $result = FeatureList::where('user_id', auth()->user()->id)
                        ->whereIn('payment_status', [0, 2])
                        ->where('status', 0)->where('date', '>=', $date)->get();
        if (count($result) <= 0) {
            return Redirect::to(url('seller/marketing/feature-listing'));
        }
        $total = $result->sum('amount');
        if ($request->isMethod('post')) {
            foreach ($result as $row) {
                $featureProductCount = 0;
                $featureProductCount = FeatureList::where('status', 1)->where('payment_status', 1)
                                ->where('date', $row->date)->where('category',$row->category)->where('product_id',$row->product_id)->where('id', '!=', $row->id)->count();
                if ($featureProductCount >= 4) {
                    return Redirect::to(url('seller/marketing/feature-listing'))->with('error', "Slot not available for " . date('d M, Y', strtotime($row->date)));
                }
            }
            $cardRes = UserCard::where('user_id', auth()->user()->id)->where('id', $request->card_id)->where('is_deleted', 0)->first();
            if ($cardRes == null) {
                return redirect()->back()->with('error', "card not valid");
            }
            $chargeRes = $this->chargePayment($cardRes, $total);
            if ($chargeRes['success'] == 0) {
                foreach ($result as $row) {
                    FeatureList::where('id', $row->id)->update([
                        'payment_status' => 2,
                        'card_id' => $request->card_id,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
                return Redirect::to(url('seller/marketing/feature-listing'))->with('error', "Payment Failed!" . $chargeRes['message']);
            } else {
                foreach ($result as $row) {
                    FeatureList::where('id', $row->id)->update([
                        'payment_raw' => json_encode($chargeRes['result']),
                        'payment_status' => 1,
                        'payment_date' => $date,
                        'card_id' => $request->card_id,
                        'status' => 1,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }

                //Send email to users Who have on offers toggle in profile (Commented on 17-03-2023)
                // $mail_data = [
                //         'subject' => 'Feature List',
                //         'data' => 'Hi buyer listed some products to FeatureList',
                //     ];
                // $job = (new \App\Jobs\Sendfeaturlistingnoitifcation($mail_data))
                //             ->delay(now()->addSeconds(2)); 
                // dispatch($job);
                return Redirect::to(url('seller/marketing/feature-listing'))->with('success', "Payment Done Successfully");
            }
        } else {
            $data = [];
            $data['title'] = 'Featured Listings';
            $data['home'] = 'Home';
            $data['breadcrumb1'] = 'Store Dashboard';
            $data['breadcrumb1_link'] = route('store.dashboard');
            $data['breadcrumb2'] = 'Marketing';
            $data['breadcrumb2_link'] = route('storeDashboard.marketingDashboard');
            $data['breadcrumb3'] = 'Featured Listings';
            $data['breadcrumb3_link'] = route('feautere.listing');
            $data['breadcrumb4'] = 'Payment';
            $data['amount'] = $total;
            $cardRes = UserCard::where('user_id', auth()->user()->id)->where('is_deleted', 0)->get();
            $data['cards'] = $cardRes;

            return view('store.marketing.feature_listings_payment', compact('data'));
        }
    }

    /** +
     * used to charge charge payment
     * @param type $request - request params
     * @param type $stripe_card_id - stripe card id
     * @return type
     */
    public function chargePayment($cardRes, $amount) {
        $user_info = auth()->user();
        $stripe = new \Stripe\StripeClient([
            "api_key" => env('STRIPE_SECRET_KEY'),
        ]);
        $returnResponse = array('success' => 0, 'message' => '', 'result' => '');
        $customer_id = $user_info->stripe_customer_id;
        try {
            $result = $stripe->charges->create([
                'amount' => (100 * $amount),
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

    /**
     * used to get slot of confirmed marketing by month and year
     * @param Request $request- request type post
     * @return type
     */
    public function getSlotsForConfirmedMarketing(Request $request) {
        //DB::connection()->enableQueryLog();
        $yearArr = $monthArr = [];
        $year = $request->year;
        $yearArr[] = (int) $year;
        $month = $request->month;
        //$month = 12;
        $d = $year . "-" . $month . "-01";
        $nextmonth = date("Y-m", strtotime('+1 month', strtotime($d)));
        $nextmonthArr = explode('-', $nextmonth);
        $premonth = date("Y-m", strtotime('-1 month', strtotime($d)));
        $premonthArr = explode('-', $premonth);
        $monthArr[] = sprintf("%02d", $month);
        $monthArr[] = $nextmonthArr[1];
        $monthArr[] = $premonthArr[1];
        if (!in_array($nextmonthArr[0], $yearArr))
            $yearArr[] = $nextmonthArr[0];
        if (!in_array($premonthArr[0], $yearArr))
            $yearArr[] = $premonthArr[0];
        $slotResult = FeatureList::select('date', DB::raw('count(*) as total'))
                        //->whereMonth('date', $month)->whereYear('date', $year)
                        ->whereIn(DB::raw('MONTH(date)'), $monthArr)->whereIn(DB::raw('YEAR(date)'), $yearArr)
                        ->where('status', 1)->where('payment_status', 1)->groupBy('date')->get();
        if($request->category && $request->prodid){
            $slotResult = FeatureList::select('date', DB::raw('count(*) as total'))
                        //->whereMonth('date', $month)->whereYear('date', $year)
                        ->whereIn(DB::raw('MONTH(date)'), $monthArr)->whereIn(DB::raw('YEAR(date)'), $yearArr)
                        ->where('status', 1)->where('category',$request->category)->where('product_id',$request->prodid)->where('payment_status', 1)->groupBy('date')->get();
        }
        // dd(FeatureList::select('date', DB::raw('count(*) as total'))
        //                 //->whereMonth('date', $month)->whereYear('date', $year)
        //                 ->whereIn(DB::raw('MONTH(date)'), $monthArr)->whereIn(DB::raw('YEAR(date)'), $yearArr)
        //                 ->where('status', 1)->where('category',$request->category)->where('payment_status', 1)->groupBy('date')->toSql());
        $returnResponse['data'] = $slotResult;
        //$queries = DB::getQueryLog();
        return $returnResponse;
    }


    public function get_product_list_acc_to_cat(Request $request){
        $returnResponse['data'] = array();
        if(isset($request->category) && !empty($request->category)){
            $returnResponse['data'] = Product::where('user_id', auth()->user()->id)
                            ->where('is_deleted', 0)->where('status',1)->where('subject_area',$request->category)->select('id', 'product_title')->get();
        }
        return $returnResponse;
    }

}
